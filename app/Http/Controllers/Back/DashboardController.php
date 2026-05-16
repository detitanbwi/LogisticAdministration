<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\Finance;
use App\Models\Container;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $startDate = \Carbon\Carbon::now()->startOfMonth();
        $endDate = \Carbon\Carbon::now()->endOfMonth();

        $daterange = $request->input('daterange');
        $isAllTime = $request->has('daterange') && empty($daterange);

        if ($daterange) {
            $dates = explode(' - ', $daterange);
            if (count($dates) == 2) {
                try {
                    $startDate = \Carbon\Carbon::parse(trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::parse(trim($dates[1]))->endOfDay();
                } catch (\Exception $e) {
                    // Fallback to default
                }
            }
        } elseif (!$isAllTime) {
            $daterange = $startDate->format('d-M-Y') . ' - ' . $endDate->format('d-M-Y');
        }

        // Periodic but also used as base for some filters below if needed
        $invoiceBase = Invoice::whereBetween('created_at', [$startDate, $endDate]);

        // Status counts - Made cumulative (all time) to better represent current state
        $total_invoice = Invoice::count();
        $pkp = Invoice::where('pkp_status', 'PKP')->count();
        $non_pkp = Invoice::where('pkp_status', 'Non PKP')->count();

        // Lunas = Paid (has tgl_transfer) - Cumulative
        $lunas = Finance::whereNotNull('tgl_transfer')->count();

        // Belum Lunas = Unpaid (no tgl_transfer) - Cumulative
        $belum_lunas = Finance::whereNull('tgl_transfer')->count();

        // Total Belum Lunas = Total unpaid balance - Cumulative
        $total_belum_lunas = Finance::whereNull('tgl_transfer')->sum('total_tagihan');

        // Total Pendapatan = Sum of total_tagihan where paid - Range filtered (Periodic performance)
        $total_pendapatan = 0;
        if (auth()->user()->can('view_total_pendapatan.dashboard')) {
            $total_pendapatan_query = Finance::whereNotNull('tgl_transfer');
            if (!$isAllTime) {
                $total_pendapatan_query->whereHas('invoice', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                });
            }
            $total_pendapatan = $total_pendapatan_query->sum('total_tagihan');
        }

        // Belum Ditagih = status_tagihan is 'Belum' - Cumulative
        $belum_ditagih = Finance::where('status_tagihan', 'Belum')->count();

        // Sudah Ditagih = status_tagihan is 'Sudah ditagih' - Cumulative
        $sudah_ditagih = Finance::where('status_tagihan', 'Sudah ditagih')->count();

        $recent_invoices = Invoice::with(['pengirim', 'finance'])
            ->latest()
            ->take(5)
            ->get();

        // Vessel Summary for Dashboard - Filtered by ETD
        $vessel_summary_query = Container::with('kapal')
            ->leftJoin('invoice', 'container.id', '=', 'invoice.container_id');
        
        if (!$isAllTime) {
            $vessel_summary_query->whereBetween('container.etd', [$startDate, $endDate]);
        }

        $vessel_summary = $vessel_summary_query->select('container.kapal_id', 'container.etd')
            ->selectRaw('count(DISTINCT container.id) as total_container')
            ->selectRaw('count(invoice.id) as total_invoice')
            ->groupBy('container.kapal_id', 'container.etd')
            ->orderBy('container.etd', 'asc')
            ->get();

        return view('back.pages.dashboard.index', compact(
            'lunas',
            'belum_lunas',
            'total_belum_lunas',
            'pkp',
            'non_pkp',
            'total_invoice',
            'total_pendapatan',
            'belum_ditagih',
            'sudah_ditagih',
            'recent_invoices',
            'vessel_summary',
            'daterange'
        ));
    }
}
