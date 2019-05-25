<?php

namespace App\Http\Controllers\Sumary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Declares\Child;
use App\Models\Declares\ClassChild;
use App\Models\Declares\Cost;
use App\Models\Manager\DayOff;
use App\Models\Total\TotalSumary;
use Auth;
use Session;
use DB;
use Config;

class SumaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $query ="select distinct `month` from hh_total_sumary order by month desc ";
       $month = DB::select($query);
      return view('sumary.index', compact('month'));
    }

    public function Get_sumary(Request $request)
    {
     $input = $request->all();
     $date= $input['date'];
     $status_fil=  $input['status_fil'];
     $month_fm = "'".$input['level']."'";
     $month_cr = 'month ='."'".date('m-Y')."'";
     $month = $input['level']== 0 ? $month = '':  'month ='.$month_fm;
     $status_fil = $input['status_fil']== 0 ? $status_fil = '':  'and status ='.$status_fil;
     $input['level']== 0 ?    $date_fm = 'DATE_FORMAT(create_date, "%Y-%m-%d") BETWEEN '.$date
      : $date_fm = 'AND DATE_FORMAT(create_date, "%Y-%m-%d") BETWEEN '.$date;

     $query ="select  id, child_id, name_child, name_class,`month`, amount, `status`,
             create_date,create_by from hh_total_sumary where $month $date_fm $status_fil
             order by month desc";
    //print_r($status_fil);die;
   $Sumary = DB::select($query);
    return Datatables::of($Sumary)
    ->addColumn('STT', function($Sumary){
      return $Sumary->id;
   })
   ->addColumn('Status_Money', function($Sumary){
     $status = $Sumary ->status == 1 ?
     '<p href="#" class="done_money btn btn-success" id="'.$Sumary->id.'" >
           <i class="fa far fa-comments-dollar fa-2x"></i> Thu tiền  </p>'
      : '<p class="btn btn-label"  >
          <i class="fa far fa-donate fa-2x"></i> Đã thu tiền </p>';
     return $status;
  })
    ->rawColumns(['STT','Status_Money'])
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
  function AddData(Request $request)
  {
      $input = $request->all();
      $pre_month = date('Y-m', strtotime('-1 month', time()));
      $input = $request->all();

       $sumary = DB::table('hh_save_data')->WHERE('child_id',$input['id'])
         ->WHERE('month',$pre_month)
        ->first();
        // print_r($sumary);
        // die;
        if($sumary){
          $sumary = sumary::find($sumary->id);
          $sumary->sumary = $input['sumary'];
          $sumary->description = $input['description'];
          $sumary->update_by = Auth::user()->id;
          $sumary->update_date = Create_dateVN();
          $sumary->save();
        }else{
          //print_r('k');
          $sumary = new sumary([
                     'child_id'      =>  $input['id'],
                     'sumary'        =>  $input['sumary'],
                     'status'        =>  0,
                     'month'         => $pre_month,
                     'description'   =>  $input['description'],
                     'create_by'     => Auth::user()->id,
                     'update_date'   => Create_dateVN(),
                     'create_date'   => Create_dateVN(),
              ]);
          $sumary->save();
        }
       return response()->json(['success'=>'<span class="label label-success">Khởi tạo thành công</span>']);

  }
  function AddData_Discount(Request $request)
  {
      $input = $request->all();

      $pre_month = date('Y-m', strtotime('-1 month', time()));
      if($input['discount'] ==null){
        $discount_num = null;
      }else{
        $discount_num = str_replace(",","",$input['discount']);
      }
       $discount = DB::table('hh_save_data')->WHERE('child_id',$input['id'])
         ->WHERE('month',$pre_month)
        ->first();
        // print_r($discount->id);
        // die;
        if($discount){

          $dayoff = DayOff::find($discount->id);
          $dayoff->discount = $discount_num;
          $dayoff->update_by = Auth::user()->id;
          $dayoff->update_date = Create_dateVN();
          $dayoff->save();
        }else{
          //print_r('k');
          $DayOff = new DayOff([
                  'child_id'      =>  $input['id'],
                  'discount'      =>  $discount_num,
                  'status'        =>  0,
                  'month'         => $pre_month,
                  'create_by'     => Auth::user()->id,
                  'update_date'   => Create_dateVN(),
                  'create_date'   => Create_dateVN(),
                //  'company_id'    =>  Session::get('company_id'),
              ]);
          $DayOff->save();
        }
       return response()->json(['success'=>'<span class="label label-success">Khởi tạo thành công</span>']);
  }

   function EditData_DayOff(Request $request)
    {
          $input = $request->all();
          $id =$input['id'];
        //  $DayOff = DayOff::find($id);
          $DayOff = DB::table('hh_save_data')->WHERE('child_id',$id)->first();
        //  print_r($DayOff);die;
          $output = array(
              'dayoff'    =>  $DayOff->dayoff,
              'description'    =>  $DayOff->description,
              'id'=>$id,
          );
          echo json_encode($output);
        //  $DayOff = DB::table('hh_save_data')->select('dayoff','description')->WHERE('child_id',$id)->get()->toArray();

      // echo json_encode($DayOff);;
    }
      function EditData_Discount(Request $request)
       {
             $input = $request->all();
             $id =$input['id'];
            // $DayOff = DayOff::find($id);
             $DayOff = DB::table('hh_save_data')->select('discount')->WHERE('child_id',$id)->first();
             $output = array(
                 'discount'    => number_format_drop_zero_decimals($DayOff->discount,3) ,
                 'id'=>$id,
             );
             echo json_encode($output);
           //  $DayOff = DB::table('hh_save_data')->select('dayoff','description')->WHERE('child_id',$id)->get()->toArray();

         // echo json_encode($DayOff);;
       }

    public function Delete(Request $request)
    {
        $id = $request->input('id');

        $Child = Child::find($id);
        if($Child != null) {
            $Child->delete();
            return response()->json(['success'=>'<span class="label label-success">Xóa thành công</span>']);
        }

    }
    public function AddData_Total(Request $request)
    {
        $input = $request->all();


        $TotalSumary = TotalSumary::find($input['id']);
        //$child       = $input['id'];
        $TotalSumary->status = 2;
        $TotalSumary->update_by = Auth::user()->id;
        $TotalSumary->update_date = date("Y-m-d H:i:s");
        $TotalSumary->save();
        return response()->json(['OK']);
    }

}
