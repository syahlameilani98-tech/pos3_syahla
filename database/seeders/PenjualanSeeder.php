<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penjualan;
use App\Models\Itempenjualan;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction (function () {

        Penjualan::factory()
        ->count(50)
        ->create()
        ->each(function ($Penjualan) {

        $items = Itempenjualan::Factory()
        ->count(rand(1, 5))
        ->make([
            'penjualan_id' => $Penjualan->id,
        ]);
        $total = $items->sum('subtotal');

        $Penjualan->Itempenjualan()->saveMany($items);

        $Penjualan->update([
            'total_Pembayaran' => $total,
        ]);
        });
        });
    }
} 