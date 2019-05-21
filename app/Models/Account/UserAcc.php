<?php

namespace App\Models\account;

use Illuminate\Database\Eloquent\Model;

class UserAcc extends Model
{
    protected $table = 'users';
    protected $fillable = [
      'company_id','department_id','code','fullname','username','password','email','mobile','manager_assign',
      'status','birthday','sex','description','ismanager','persional_id',
      'lastvisited','create_by','update_by','created_date','updated_date'
    ];
    public $timestamps=false;

    public function User(){
    	return $this->belongTo('App\User');
    }
}
