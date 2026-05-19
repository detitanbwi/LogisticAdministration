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
                    $startDate = \Carbon\Carbon::parseIndonesian(trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::parseIndonesian(trim($dates[1]))->endOfDay();
                } catch (\Exception $e) {
                    // Fallback to default
                }
            }
        } elseif (!$isAllTime) {
            $daterange = $startDate->translatedFormat('d-M-Y') . ' - ' . $endDate->translatedFormat('d-M-Y');
        }

        // Invoice base query with container etd filter
        $invoiceQuery = Invoice::query();
        if (!$isAllTime) {
            $invoiceQuery->whereHas('container', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('etd', [$startDate, $endDate]);
            });
        }

        // Finance base query with container etd filter
        $financeQuery = Finance::query();
        if (!$isAllTime) {
            $financeQuery->whereHas('invoice.container', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('etd', [$startDate, $endDate]);
            });
        }

        // Status counts - Periodic
        $total_invoice = (clone $invoiceQuery)->count();
        $pkp = (clone $invoiceQuery)->where('pkp_status', 'PKP')->count();
        $non_pkp = (clone $invoiceQuery)->where('pkp_status', 'Non PKP')->count();

        // Lunas = Paid (has tgl_transfer)
        $lunas = (clone $financeQuery)->whereNotNull('tgl_transfer')->count();

        // Belum Lunas = Unpaid (no tgl_transfer)
        $belum_lunas = (clone $financeQuery)->whereNull('tgl_transfer')->count();

        // Total Belum Lunas = Total unpaid balance
        $total_belum_lunas = (clone $financeQuery)->whereNull('tgl_transfer')->sum('total_tagihan');

        // Total Pendapatan = Sum of total_tagihan where paid
        $total_pendapatan = 0;
        if (auth()->user()->can('view_total_pendapatan.dashboard')) {
            $total_pendapatan = (clone $financeQuery)->whereNotNull('tgl_transfer')->sum('total_tagihan');
        }

        // Belum Ditagih = status_tagihan is 'Belum'
        $belum_ditagih = (clone $financeQuery)->where('status_tagihan', 'Belum')->count();

        // Sudah Ditagih = status_tagihan is 'Sudah ditagih'
        $sudah_ditagih = (clone $financeQuery)->where('status_tagihan', 'Sudah ditagih')->count();

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
