<?php

namespace App\Models;

use App\Models\User;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function produk(){
        return $this->belongsTo(Produk::class, 'id_produk')->withTrashed();
    }
    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
