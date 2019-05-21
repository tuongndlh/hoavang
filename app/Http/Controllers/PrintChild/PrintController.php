<?php

namespace App\Http\Controllers\PrintChild;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Declares\Child;
use App\Models\Declares\ClassChild;
use App\Models\Declares\Cost;
use App\Models\Manager\DayOff;
use App\Models\Total\Total;
use App\Models\Total\TotalSumary;


use Auth;
use Session;
use DB;
use Config;

class PrintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $class = DB::table('hh_class')->select('id','name')
      ->orderBy('name', 'ASC')
      ->get()->toArray();

      return view('print.index',compact('class'));
    }

    public function Get_List_Print(Request $request)  {

       $input = $request->all();
       $id_class = $input['level']== 0 ? $id_class = '':  'WHERE t2.id ='.$input['level'];

      $query= "select t1.id, t1.name `name_child`, t2.`name` name_class,t1.fee, t3.price,
                   t4.dayoff, t4.discount,t5.`status` FROM hh_child t1
                   left join hh_class t2 on t2.id = t1.class_id
                   left join hh_type_cost t3 on t3.id = t2.fee
                   LEFT JOIN hh_save_data  t4 on t4.child_id = t1.id
                   LEFT JOIN hh_total_sumary t5 on t5.child_id = t1.id
                   $id_class
                   ORDER BY t2.id
                   ";
      $List = DB::select($query);
      //  print_r($List);die;
       return Datatables::of($List)
       ->addColumn('STT', function($List){
           return $List->id;
        })
      ->addColumn('fee_detail', function($Child){
           $fee= $Child->fee;
           $list_id = explode(",",str_replace("'","",$fee));
           // Tính phí ăn sáng, trưa, tối
           $Cost = Cost::whereIn('id',$list_id)->where('rollback',1)->get();
           $name_cost  ='';
           $name_cost_hide  =0;
           foreach ($Cost as $item) {
             $name_cost .= number_format_drop_zero_decimals($item->price * Get_Day_Sunday(),3).'; ';
             $name_cost_hide += $item->price * Get_Day_Sunday();
             Config::set('name_cost_hide', $name_cost_hide);
           }
           // Tính tiếng anh, erobic

           $Cost_NotRB = Cost::whereIn('id',$list_id)->where('rollback',0)->where('is_cost',0)->get();
           $name_cost__notRB  ='';
           $name_cost__notRB_hide=0;
           foreach ($Cost_NotRB as $item) {
             $name_cost__notRB .= number_format_drop_zero_decimals($item->price,3).'; ';
             $name_cost__notRB_hide += $item->price;
              Config::set('name_cost__notRB_hide', $name_cost__notRB_hide);
           }
           return $name_cost.$name_cost__notRB;
         })
         // Ngày nghỉ
      ->addColumn('day_off', function($Child){
           $fee= $Child->fee;
           $list_id = explode(",",str_replace("'","",$fee));
           $Cost = Cost::whereIn('id',$list_id)->where('rollback',1)->get();
           $money_day_off  =0;
           foreach ($Cost as $item) {
             $money_day_off += $item->price * $Child->dayoff;
              Config::set('money_day_off', $money_day_off);
           }
           return $money_day_off;
        })
        ->addColumn('amount', function($List){
            $name_cost_hide = Config::get('name_cost_hide');
            $name_cost__notRB_hide = Config::get('name_cost__notRB_hide');
            $money_day_off = Config::get('money_day_off');
            $amount_sum = $name_cost_hide+$name_cost__notRB_hide+$List->price;
            $amount_sub = $money_day_off + $List->discount;
            return $amount_sum -$amount_sub;
         })
      ->addColumn('print', function($List){
        if($List->status == 1)
        {
            $status_print = '<p href="#" class="done_money btn btn-primary" id="'.$List->id.'" >
                <i class="fas fa-print"></i> In phiếu  </p>';
        }
        else if($List->status == 2)
        {
            $status_print = '<p href="#" class="done_money btn btn-label" id="'.$List->id.'" >
                <i class="fas fa-print"></i> In phiếu  </p>';
        }
        else
        {
            $status_print = '<p href="#" class="done_money btn btn-success" id="'.$List->id.'" >
                <i class="fas fa-print"></i> In phiếu  </p>';
        }
        return $status_print;
        })
         ->rawColumns(['STT','print','fee_detail','day_off','amount'])
         ->editColumn('id', '{{$id}}')
         ->setRowId('id')
         ->make(true);
    }

  public function Print_report_before(Request $request)
     {
            $input = $request->all();
            $child_id =    $input['child_id']  ;
            $month = date('m').'-'.date('Y');
            // In
            $query= "select t1.id, t1.name `name_child`, t2.`name` name_class,t1.fee, t3.price,
                         COALESCE(t4.dayoff,0) dayoff, t4.discount,t5.`status` FROM hh_child t1
                         left join hh_class t2 on t2.id = t1.class_id
                         left join hh_type_cost t3 on t3.id = t2.fee
                         LEFT JOIN hh_save_data  t4 on t4.child_id = t1.id
                         LEFT JOIN hh_total_sumary t5 on t5.child_id = t1.id
                         where t1.id = $child_id
                         ORDER BY t2.id
                         ";
          $List = DB::select($query);

          $fee= $List[0]->fee;
          $list_id = explode(",",str_replace("'","",$fee));
             // Tính phí ăn sáng, trưa, tối
          $Cost = Cost::whereIn('id',$list_id)->where('rollback',1)->get();
          $name_cost  ='';
          $name_cost_hide  =0;
          foreach ($Cost as $item) {
            $name_cost .=
             '<li>'.$item->name.': <b>'.
              number_format_drop_zero_decimals($item->price,3).'</b>'.' x '.'<b>'.
              Get_Day_Sunday().'</b>'.' = '.'<b>'.
             number_format_drop_zero_decimals($item->price * Get_Day_Sunday(),3).'</b></li>';

            $name_cost_hide += $item->price * Get_Day_Sunday();
            Config::set('name_cost_hide', $name_cost_hide);
          }
          // Tính tiếng anh, erobic
          $Cost_NotRB = Cost::whereIn('id',$list_id)->where('rollback',0)->where('is_cost',0)->get();
          $name_cost__notRB  ='';
          $name_cost__notRB_hide=0;
          foreach ($Cost_NotRB as $item) {
            $name_cost__notRB .=
            '<li>'.$item->name.': <b>'.
            number_format_drop_zero_decimals($item->price,3).'</b></li>';
            $name_cost__notRB_hide += $item->price;
             Config::set('name_cost__notRB_hide', $name_cost__notRB_hide);
          }
          //Ngày nghỉ
          $Cost = Cost::whereIn('id',$list_id)->where('rollback',1)->get();
          $money_day_off  =0;
          foreach ($Cost as $item) {
             $money_day_off += $item->price * $List[0]->dayoff;
             Config::set('money_day_off', $money_day_off);
          }
           $day_off_name  =  ' ('.$List[0]->dayoff.' ngày )';
          // Tổng tiền
          $name_cost_hide = Config::get('name_cost_hide');
          $name_cost__notRB_hide = Config::get('name_cost__notRB_hide');
          $money_day_off = Config::get('money_day_off');
          $amount_sum = $name_cost_hide+$name_cost__notRB_hide+$List[0]->price;
          $amount_sub = $money_day_off + $List[0]->discount;
          $total_amount =  number_format_drop_zero_decimals($amount_sum -$amount_sub,3);


          $all_name_cost = $name_cost.$name_cost__notRB;
          $all_day_off   = number_format_drop_zero_decimals($money_day_off,3).$day_off_name;
          $name_child    = $List[0]->name_child;
          $name_class    = $List[0]->name_class;
          $price         = number_format_drop_zero_decimals($List[0]->price,3);
          $discount         = number_format_drop_zero_decimals($List[0]->discount,3);
        //  print_r($total_amount);die;
            // Chèn vào database
          $check_print = TotalSumary::select('id')->where('month',$month)->where('child_id',$child_id)
          ->where('status',2)->count();
          //  print_r($check_print); die;
          if($check_print == 0){
          $check = TotalSumary::select('id')->where('month',$month)->where('child_id',$child_id)
          ->count();
       //print_r($check); die;
          if($check == 0){
            $TotalSumary = new TotalSumary([
                'child_id'              =>  $input['child_id'],
                'name_child'            =>  $input['name_child'],
                'name_class'            =>  $input['name_class'],
                'fee_detail'            =>  $input['fee_detail'],
                'price'                 =>  $input['price'],
                'day_off'               =>  $input['day_off'],
                'discount'              =>  $input['discount'],
                'amount'                =>  $input['amount'],
                'month'                 =>  $month,
                'status'                 =>  1,
                'update_date'    =>  Create_dateVN(),
                'create_date'    =>  Create_dateVN(),
                'create_by'      =>  Auth::user()->id,
                'company_id'     =>  Session::get('company_id'),
            ]);

           $TotalSumary->save();
        //   return response()->json(['Insert_OK']);

         }else{
               TotalSumary::where('child_id', $child_id)
               ->where('status',1)
               ->update(['day_off' => $input['day_off'],
                        'discount' => $input['discount'],
                        'amount' => $input['amount'],
                        'update_by' => Auth::user()->id,
                        'update_date' =>  Create_dateVN(),
                      ]);
         }
      }
   return response()->json([$all_name_cost,$all_day_off,$name_child,$name_class,$price,$discount,$total_amount]);
        //   print_r($name_cost);die;

     }

}
