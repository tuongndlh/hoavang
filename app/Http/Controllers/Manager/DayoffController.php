<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Declares\Child;
use App\Models\Declares\ClassChild;
use App\Models\Declares\Cost;
use App\Models\Manager\DayOff;
use Auth;
use Session;
use DB;
class DayoffController extends Controller
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
      return view('manager.dayoff.index',compact('class'));
    }
    public function Get_dayoff(Request $request)
    {
     $input = $request->all();
     $id_class = $input['level']== 0 ? $id_class = '':  'and t2.id ='.$input['level'];

     $pre_month = "'".date('Y-m', strtotime('-1 month', time()))."'";
  //   $month = "'".date("Y-m")."'";
  //  print_r($month);die;
    $query ="SELECT @rownum := @rownum + 1 AS row,t.*
            FROM
                 ( select t2.name as classname,t3.discount, t3.dayoff,t3.id as ID_Save,t3.description as reason,
                   t3.update_date as Up_date,t1.id as child_id,
                   t1.*,@rownum := 0 from hh_child t1
                  LEFT JOIN hh_class as t2 ON t2.id = t1.class_id
                  LEFT JOIN hh_save_data as t3 ON t3.child_id = t1.id
                  WHERE (t3.month = $pre_month or t3.month is null)  and t1.status =1 $id_class
          		) t  ORDER BY Up_date DESC";
    $Child = DB::select($query);
  //   print_r($query);die;

     return Datatables::of($Child)

     ->addColumn('namechild', function($Child){
       if($Child->sex == 1){
         $sex = '<a data-popup="tooltip"  title="Nam"><i class="fas fa-male fa-lg" style="color:#2196F3"></i></a>';
       }else {
           $sex = '<a data-popup="tooltip"  title="Nữ"><i class="fas fa-female fa-lg" style="color:orange "></i></a>';
       }
       return $sex.' - '.'<span class="label label-primary">'.$Child->name.' ( <i>'.$Child->code.'</i> )'.'</span>';
   })

  ->addColumn('dayoff', function($Child){
    if($Child->dayoff == null){
      $dayoff = '<a href="#" class="dayoff" id="'.$Child->id.'">
                            <i class="fas fa-sign-out-alt"></i> Nhập ngày nghỉ</a>';
    }else {
      $dayoff = '<a href="#" class="dayoff_edit" id="'.$Child->id.'" >
      <span class ="label label-warning">'.$Child->dayoff.'</span> </a>';
    }
    return $dayoff ;
 })
 ->addColumn('discount', function($Child){
   if($Child->discount == null){
     $discount = '<a href="#"  class="discount" id="'.$Child->id.'" >
               <i class="fab fa-discourse"></i> Nhập miễn giảm</a>';
   }
   else{
     $discount = '<a href="#" class="discount_edit" id="'.$Child->id.'" >
     <span class ="label label-success">'.number_format_drop_zero_decimals($Child->discount,3).'</span>
     '.'<span class ="label label-default">'.$Child->reason.'</span> </a>';
   }
     return $discount;
})

 ->addColumn('STT', function($Child){
   return $Child->row;
})

     ->rawColumns(['STT','namechild','action','dayoff','discount','child_id'])
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

       $DayOff = DB::table('hh_save_data')->WHERE('child_id',$input['id'])
         ->WHERE('month',$pre_month)
        ->first();
        // print_r($DayOff);
        // die;
        if($DayOff){
          $dayoff = DayOff::find($DayOff->id);
          $dayoff->dayoff = $input['dayoff'];
          $dayoff->update_by = Auth::user()->id;
          $dayoff->update_date = Create_dateVN();
          $dayoff->save();
        }else{
          //print_r('k');
          $DayOff = new DayOff([
                     'child_id'      =>  $input['id'],
                     'dayoff'        =>  $input['dayoff'],
                     'status'        =>  0,
                     'month'         => $pre_month,
                     'create_by'     => Auth::user()->id,
                     'update_date'   => Create_dateVN(),
                     'create_date'   => Create_dateVN(),
              ]);
          $DayOff->save();
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
          $dayoff->description = $input['description'];
          $dayoff->discount = $discount_num;
          $dayoff->update_by = Auth::user()->id;
          $dayoff->update_date = Create_dateVN();
          $dayoff->save();
        }else{
          //print_r('k');
          $DayOff = new DayOff([
                  'child_id'      =>  $input['id'],
                  'discount'      =>  $discount_num,
                  'description'   =>  $input['description'],
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
             $DayOff = DB::table('hh_save_data')->select('discount','description')->WHERE('child_id',$id)->first();
             $output = array(
                 'description' => $DayOff->description,
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
}
