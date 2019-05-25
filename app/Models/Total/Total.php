<?php

namespace App\Models\Total;

use Illuminate\Database\Eloquent\Model;

class Total extends Model
{
  protected $table = "hh_total_amount";
  protected $fillable = [
    'id','child_id','sum_amount','day_off','month','discount','total_amount','status','sunday',
    'description','create_by','update_date','create_date','update_by'
  ];
  public $timestamps = false;

}
