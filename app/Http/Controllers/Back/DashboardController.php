<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\Finance;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $startDate = \Carbon\Carbon::now()->startOfMonth();
        $endDate = \Carbon\Carbon::now()->endOfMonth();

        $daterange = $request->input('daterange');
        if ($daterange) {
            $dates = explode(' - ', $daterange);
            if (count($dates) == 2) {
                try {
                    $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                } catch (\Exception $e) {
                    // Fallback to default
                }
            }
        } else {
            $daterange = $startDate->format('m/d/Y') . ' - ' . $endDate->format('m/d/Y');
        }

        $invoiceBase = Invoice::whereBetween('created_at', [$startDate, $endDate]);

        $pkp = (clone $invoiceBase)->where('pkp_status', 'PKP')->count();
        $non_pkp = (clone $invoiceBase)->where('pkp_status', 'Non PKP')->count();

        // Lunas = Paid (has tgl_transfer)
        $lunas = Finance::whereNotNull('tgl_transfer')
            ->whereHas('invoice', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            })->count();

        // Belum Lunas = Unpaid (no tgl_transfer) - Make this cumulative (all time)
        $belum_lunas = Finance::whereNull('tgl_transfer')->count();

        // Total Belum Lunas = Total unpaid balance - Make this cumulative (all time)
        $total_belum_lunas = Finance::whereNull('tgl_transfer')->sum('total_tagihan');

        $total_invoice = (clone $invoiceBase)->count();

        // Total Pendapatan = Sum of total_tagihan where paid - Range filtered
        $total_pendapatan = Finance::whereNotNull('tgl_transfer')
            ->whereHas('invoice', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            })->sum('total_tagihan');

        // Belum Ditagih = status_tagihan is 'Belum' - Cumulative
        $belum_ditagih = Finance::where('status_tagihan', 'Belum')->count();

        // Sudah Ditagih = status_tagihan is 'Sudah ditagih' - Cumulative
        $sudah_ditagih = Finance::where('status_tagihan', 'Sudah ditagih')->count();

        $recent_invoices = Invoice::with(['pengirim', 'finance'])
            ->latest()
            ->take(5)
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
            'daterange'
        ));
    }
}
