<?php

namespace App\Models\Declares;

use Illuminate\Database\Eloquent\Model;

class ReportAll extends Model
{
  protected $table = "hv_report_all";
  protected $fillable = [
    'id','name_content','parent_id','create_by','update_date','company_id','create_date','update_by'
  ];
  public $timestamps = false;

}
