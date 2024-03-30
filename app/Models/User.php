<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Auditorium;
use App\Models\Station;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

//public static $auditoriums = [];

  public $timestamps = false;  
  protected $primaryKey = 'UserID';
  protected $keyType = 'string';
  protected $table = 'vUsers';


   public function getAuthPassword() {
    return $this->password;
  }

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'UID',
        'RoleID',
        'login',
        'password',
        'UserDetails',
        'UserName',
        'RoleName',
        'RoleDetails',
    ];

    /**
     * Атрибуты, которые должны быть скрыты для массивов.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        /*'remember_token',*/
    ];

}
