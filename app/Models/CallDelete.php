<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class CallDelete extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'Calls';
    protected $primaryKey = 'UID';
    protected $guarded = [];
    protected $fillable = ['UserID'];
   



}
