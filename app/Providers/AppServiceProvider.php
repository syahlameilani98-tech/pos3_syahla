<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use App\Models\User;
use App\Policies\DashboardPolicy; // Memperbaiki namespace (P besar)
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\ItemPenjualan;
use App\Policies\ItemPenjualanPolicy;
use App\Policies\PenjualanPolicy;
use App\Policies\ProdukPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Policy mappings for the application.
     */
    protected $policies = [
        User::class          => DashboardPolicy::class,
        Produk::class        => ProdukPolicy::class,
        Penjualan::class     => PenjualanPolicy::class, // <-- Tanda koma ditambahkan di sini
        ItemPenjualan::class => ItemPenjualanPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Carbon::setLocale('id');
        $this->registerPolicies();
    }
}