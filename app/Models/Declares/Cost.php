<?php

namespace App\Models\Declares;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
  protected $table = "hh_type_cost";
  protected $fillable = [
    'id','code','name','price','rollback','is_cost','other','date_apply','description','create_by','update_date','company_id','create_date','update_by'
  ];
  public $timestamps = false;

}
