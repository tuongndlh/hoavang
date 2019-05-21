<?php
use Yajra\Datatables\Datatables;

function number_format_drop_zero_decimals($n, $n_decimals)
    {
      return ((floor($n) == round($n, $n_decimals)) ? number_format($n) : number_format($n, $n_decimals));
    }

  function createPin($len){

    	$maxNbrStr = str_repeat('9',$len);

	    $maxNbr = intval($maxNbrStr);

	    $n = mt_rand(0, $maxNbr);

	    $pin = str_pad($n, $len, "0", STR_PAD_LEFT);

	    return $pin;

	}
  function Create_Session()
  {
    if($user = Auth::user())
      {
        $id_user = Auth::user()->id;
        if($id_user > 0){
          $company_id = DB::table('users')->where('id',$id_user)->value('company_id');
          Session::put('company_id',$company_id); // a single variable
        }
      }
  }
  function Create_dateVN()
   {
       date_default_timezone_set("Asia/Bangkok");
       return $date = date('Y-m-d H:i:s');
   }
   function Get_Day_Sunday(){
     //use DB;
     $query= "SELECT t.total_day-t.sunday as day_amount from(
                 SELECT  DAY(LAST_DAY(now())) as total_day,CASE DAYOFMONTH(LAST_DAY(now() ))
                         WHEN 31 THEN
                             CASE DAYOFWEEK(LAST_DAY(now() ))
                                 WHEN 1 THEN 5
                                 WHEN 2 THEN 5
                                 WHEN 3 THEN 5
                                 ELSE 4
                             END
                         WHEN 30 THEN
                             CASE DAYOFWEEK(LAST_DAY(now() ))
                                 WHEN 1 THEN 5
                                 WHEN 2 THEN 5
                                 ELSE 4
                             END
                         WHEN 29 THEN
                             CASE DAYOFWEEK(LAST_DAY(now() ))
                                 WHEN 1 THEN 5
                                 ELSE 4
                             END
                         ELSE 4
                     END sunday ) t ";
        $getdate_select = DB::select($query);
      //  print_r($getdate_select[0]->day_amount);die;
       return $getdate_select[0]->day_amount;
   }
