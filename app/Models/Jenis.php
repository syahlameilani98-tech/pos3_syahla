<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'jenis';

    /**
     * Kolom yang boleh diisi lewat mass assignment (create/update)
     */
    protected $fillable = [
        'nama',
    ];
}