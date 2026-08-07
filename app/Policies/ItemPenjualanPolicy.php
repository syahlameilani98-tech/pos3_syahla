<?php

namespace App\Policies;

use App\Models\ItemPenjualan;
use App\Models\User;

class ItemPenjualanPolicy
{
    /**
     * Create a new policy instance.
     */
    public function delete(user $user, ItemPenjualan $itempenjualan): bool
    {
        return $user->role->name === 'admin';
    }
}
