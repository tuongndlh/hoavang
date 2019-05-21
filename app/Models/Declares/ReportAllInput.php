<?php

namespace App\Models\Declares;

use Illuminate\Database\Eloquent\Model;

class ReportAllInput extends Model
{
  protected $table = "hv_report_input";
  protected $fillable = [
    'id','user_id','report_all_id','quantity','month','create_by','update_date','company_id','create_date','update_by'
  ];
  public $timestamps = false;

}
