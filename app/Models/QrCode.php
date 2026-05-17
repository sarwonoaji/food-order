<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $table = 'qrcodes';
    protected $fillable = ['table_number', 'code', 'status'];
}
