<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Model;

class DayOff extends Model
{
  protected $table = "hh_save_data";
  protected $fillable = [
    'id','child_id','dayoff','discount','status','month',
    'description','create_by','update_date','create_date','update_by'
  ];
  public $timestamps = false;

}
