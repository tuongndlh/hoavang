<?php

namespace App\Models\Total;

use Illuminate\Database\Eloquent\Model;

class TotalSumary extends Model
{
  protected $table = "hh_total_sumary";
  protected $fillable = [
    'id','child_id','name_child','name_class','fee_detail','price','day_off','discount','amount','month','status',
    'description','create_by','update_date','create_date','update_by'
  ];
  public $timestamps = false;

}
