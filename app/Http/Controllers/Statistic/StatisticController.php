<?php

namespace App\Http\Controllers\Statistic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Declares\Child;
use App\Models\Declares\ClassChild;
use App\Models\Declares\Cost;
use App\Models\Manager\DayOff;
use App\Models\Total\Total;
use App\Models\Statistic\Statistic;

use Auth;
use Session;
use DB;
use Config;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    //  print_r($select_report);die;
    //  return Datatables::of($select_report);

      return view('statistic.index');
    }
    public function Print_report(Request $request){

      $getdate_select= "SELECT t.*, t.total_day-t.sunday as day_amount from(
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
        $getdate = DB::select($getdate_select);
        $dayofmonth = $getdate[0]->day_amount;

      $input = $request->all();
      $child_id =$input['child_id'];
    //  print_r($input);die;


       $query =   "select t1.`name` as name_child, t2.`name` as name_class,
        t3.price,t1.fee,t.total_amount,t.sunday,t.day_off,t.discount from hh_total_amount t
                      LEFT JOIN hh_child t1 on t1.id = t.child_id
                      LEFT JOIN hh_class t2 on t2.id = t1.class_id
        		          LEFT JOIN hh_type_cost t3 on t3.id = t2.fee
                      WHERE t.`status` =0 and t1.id = $child_id ";
        $select_report = DB::select($query);


      //   print_r($select_report[0]->fee);die;
        $fee= $select_report[0]->fee;
        $list_id = explode(",",str_replace("'","",$fee));

        $Cost = Cost::whereIn('id',$list_id)->where('rollback',1)->get();
        $name_cost  ='';
        foreach ($Cost as $item) {
          $name_cost .= '<li>'.$item->name.': <b>'.
          number_format_drop_zero_decimals($item->price*$dayofmonth,3).'</b></li>';
        }
        $Cost_NotRB = Cost::whereIn('id',$list_id)->where('rollback',0)->where('is_cost',0)->get();
        $name_cost__NotRB  ='';
        foreach ($Cost_NotRB as $item) {
          $name_cost__NotRB .= '<li>'.$item->name.': <b>'.
            number_format_drop_zero_decimals($item->price,3).'</b></li>';
        }
        $all_name_cost = $name_cost.$name_cost__NotRB;
        $Cost = Cost::whereIn('id',$list_id)->where('rollback',1)->get();
        $money_day_off  =0;
        foreach ($Cost as $item) {
          $money_day_off +=
                  $item->price * $select_report[0] ->day_off;
        }
        $price = number_format_drop_zero_decimals($select_report[0]->price,3);
        $total_amount = number_format_drop_zero_decimals($select_report[0]->total_amount,3);
        $discount= $select_report[0] ->discount;
        $money_dayoff=number_format_drop_zero_decimals($money_day_off+$select_report[0]->discount,3);
        // print_r($name_cost);die;
        return response()->json([$select_report,$all_name_cost,$price,$total_amount,$money_dayoff]);
    }

    public function Get_sumary()   {

      $query= "select t.*,t1.`name` as name_child, t2.`name` as name_class from hh_total_amount t
              LEFT JOIN hh_child t1 on t1.id = t.child_id
              LEFT JOIN hh_class t2 on t2.id = t1.class_id
              WHERE t.`status` =0";
      $Statistic = DB::select($query);
       // print_r($query);die;
       return Datatables::of($Statistic)
       ->addColumn('STT', function($Statistic){
         return $Statistic->id;
      })
      ->addColumn('print', function($Statistic){
        return '<p href="#" class="done_money btn btn-success" id="'.$Statistic->child_id.'" >
              <i class="fas fa-print"></i> In phiếu  </p>';
        })
         ->rawColumns(['STT','print'])
         ->editColumn('id', '{{$id}}')
         ->setRowId('id')
         ->make(true);
    }
  public function View_Child()
  {
      $data = Child::count()+1;
      $code = "HH".'-'. (str_pad($data, 4, "0", STR_PAD_LEFT));
      $class = DB::table('hh_class')->select('id','name')->get()->toArray();
      $cost = DB::table('hh_type_cost')->select('id','name')
      ->where('company_id',Session::get('company_id')) ->get()->toArray();

      return view('declare.child.add_child',compact('code','class','cost'));
  }
  // public function prnpriview()
  //    {
  //          $Total = Total::all();
  //          return view('print.index')->with('total', $Total);;
  //    }

}
