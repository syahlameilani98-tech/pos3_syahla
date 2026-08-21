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
        'foto',
        'user_id',
    ];

    /**
     * Relasi ke user yang menambahkan jenis ini
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}