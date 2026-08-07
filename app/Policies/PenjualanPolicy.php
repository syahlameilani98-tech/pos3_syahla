<?php

namespace App\Policies;

use App\Models\Penjualan;
use App\Models\User;

class PenjualanPolicy
{
    /**
     * Policy untuk menghapus penjualan */
    public function delete(User $user, Penjualan $penjualan): bool
    {
        return $user->role->name === 'admin'
        && $penjualan->status === 'OPEN';
    }

    /**
     * Policy untuk melihat penjualan
     */
    public function view(User $user, Penjualan $penjualan): bool
    {
       return $user->role->name === 'admin'
       && $penjualan->status === 'OPEN';
    }
}