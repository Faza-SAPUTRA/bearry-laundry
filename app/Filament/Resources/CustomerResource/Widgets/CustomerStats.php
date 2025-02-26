<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class CustomerStats extends BaseWidget
{
    protected function getStats(): array
    {
        // Total Customer Baru Minggu Ini (Semua Tipe Customer)
        $totalCustomersThisWeek = $this->getWeeklyCustomers();
        $weeklyStats = $this->buildWeeklyStats($totalCustomersThisWeek);

        // Total Customer Baru Bulan Ini (Tipe Membership)
        $totalMembershipThisMonth = $this->getMonthlyMembershipCustomers();
        $monthlyStats = $this->buildMonthlyStats($totalMembershipThisMonth);

        // Customer yang paling banyak mencuci minggu ini
        $topCustomer = $this->getTopCustomerThisWeek();
        $topCustomerStats = $this->buildTopCustomerStats($topCustomer);

        return [$weeklyStats, $monthlyStats, $topCustomerStats];
    }

    private function getWeeklyCustomers(): int
    {
        return Customer::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();
    }

    private function buildWeeklyStats(int $count): Stat
    {
        $hasCustomers = $count > 0;

        return Stat::make('Total Customer Baru Minggu Ini', $count)
            ->description($hasCustomers ? 'Peningkatan Customer Baru' : 'Tidak ada customer baru pada minggu ini')
            ->icon('heroicon-o-user-group')
            ->color($hasCustomers ? 'success' : 'warning')
            ->chart($hasCustomers ? $this->generateAscendingChart() : $this->generateFlatChart());
    }

    private function getMonthlyMembershipCustomers(): int
    {
        return Customer::where('tipe_customer', 'membership')
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])->count();
    }

    private function buildMonthlyStats(int $count): Stat
    {
        $hasCustomers = $count > 0;

        return Stat::make('Total Customer Baru Bulan Ini (Membership)', $count)
            ->description($hasCustomers ? 'Peningkatan Customer Baru Membership' : 'Tidak ada customer baru bulan ini')
            ->icon('heroicon-o-users')
            ->color($hasCustomers ? 'success' : 'warning')
            ->chart($hasCustomers ? $this->generateAscendingChart() : $this->generateFlatChart());
    }

    private function getTopCustomerThisWeek()
    {
        return DB::table('detail_transaksi')
            ->join('transaksi', 'detail_transaksi.id_transaksi', '=', 'transaksi.id_transaksi')
            ->join('customer', 'transaksi.id_customer', '=', 'customer.id_customer')
            ->select('customer.nama_customer', DB::raw('SUM(detail_transaksi.berat) as total_berat'))
            ->whereBetween('transaksi.created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy('customer.id_customer', 'customer.nama_customer')
            ->orderByDesc('total_berat')
            ->first();
    }

    private function buildTopCustomerStats($customer): Stat
    {
        return Stat::make('Customer Paling Banyak Mencuci Minggu Ini', $customer ? $customer->nama_customer : 'Tidak ada data')
            ->description($customer ? "Total {$customer->total_berat} Kg" : 'Belum ada transaksi minggu ini')
            ->icon('heroicon-o-user')
            ->color($customer ? 'success' : 'warning')
            ->chart($customer ? [3, 5, 4, 8, 7, 12, 10, 15, 14, 18] : array_fill(0, 7, 0));
    }

    private function generateFlatChart(): array
    {
        return array_fill(0, 7, 0);
    }

    private function generateAscendingChart(): array
    {
        return [3, 5, 4, 8, 7, 12, 10, 15, 14, 18];
    }
}
