<?php

namespace App\Models\Declares;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
  protected $table = "hh_child";
  protected $fillable = [
    'id','class_id','code','name','family_name','address','mobile','fee','sex','status',
    'description','create_by','update_date','create_date','update_by'
  ];
  public $timestamps = false;

}
