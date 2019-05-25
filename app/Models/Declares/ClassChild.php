<?php

namespace App\Models\Declares;

use Illuminate\Database\Eloquent\Model;

class ClassChild extends Model
{
  protected $table = "hh_class";
  protected $fillable = [
    'id','code','name','fee','description','create_by','update_date','create_date','update_by'
  ];
  public $timestamps = false;

}
