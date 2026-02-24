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

        $lunas = Finance::where('status_tagihan', 'Sudah ditagih')
            ->whereHas('invoice', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            })->count();

        $belum_lunas = Finance::where('status_tagihan', '!=', 'Sudah ditagih')
            ->whereHas('invoice', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            })->count();

        $total_invoice = (clone $invoiceBase)->count();

        $total_pendapatan = Finance::whereHas('invoice', function($q) use ($startDate, $endDate) {
            $q->whereBetween('created_at', [$startDate, $endDate]);
        })->sum('total_tagihan');

        $belum_ditagih = Finance::where('status_tagihan', 'Belum')
            ->whereHas('invoice', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            })->count();

        $sudah_ditagih = Finance::where('status_tagihan', 'Sudah ditagih')
            ->whereHas('invoice', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            })->count();

        $recent_invoices = Invoice::with(['pengirim', 'finance'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->take(5)
            ->get();

        return view('back.pages.dashboard.index', compact(
            'lunas',
            'belum_lunas',
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
