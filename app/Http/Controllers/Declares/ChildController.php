<?php

namespace App\Http\Controllers\Declares;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Declares\Child;
use App\Models\Declares\ClassChild;
use App\Models\Declares\Cost;
use Auth;
use Session;
use DB;
class ChildController extends Controller
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
      return view('declare.child.index', compact('class'));
    }
    public function Get_Child(Request $request)
    {
    $input = $request->all();
    $id_class = $input['level']== 0 ? $id_class = '':  'where t.child_id ='.$input['level'];

    $query ="SELECT @rownum := @rownum + 1 AS row,t.*
            FROM
                 ( select t2.id as child_id,t2.name as classname,t1.*,@rownum := 0 from hh_child t1
                  LEFT JOIN hh_class as t2 ON t2.id = t1.class_id
          		) t  $id_class ORDER BY create_date DESC";
      //  print_r($query);die;
    $Child = DB::select($query);
     return Datatables::of($Child)
     ->addColumn('action', function($Child){
         return '<a href="'.'child/'.$Child->id.'/edit_child'.'" ><i class="fa far fa-edit"></i> Sửa</a>
          <a href="#" class="delete" id="'.$Child->id.'"><i class="fa fa-trash"></i> Xóa</a>';
     })
     ->addColumn('namechild', function($Child){
       if($Child->sex == 1){
         $sex = '<a data-popup="tooltip"  title="Nam"><i class="fas fa-male fa-lg" style="color:#2196F3"></i></a>';
       }else {
           $sex = '<a data-popup="tooltip"  title="Nữ"><i class="fas fa-female fa-lg" style="color:orange "></i></a>';
       }
       if($Child->status == 1){
         $name =
         '<div class="col-lg-2 col-md-2 col-sm-3 col-xs-2">
             <div><span class="label label-success">'.$sex.' - '.$Child->name.' ('.$Child->code.')'.'</span></div>
         </div>';

       }else{
         $name =    '<div class="col-lg-2 col-md-2 col-sm-3 col-xs-2">
               <div> <span class="label label-danger">'.$sex.' - '.$Child->name.' ('.$Child->code.')'.'</span></div>
               </div>';

       }
       return $name;
   })
   ->addColumn('update_date',function($Child){
      $update_date  = date('Y-m-d', strtotime($Child->update_date));
      return $update_date;
   })
   ->addColumn('name_delete',function($Child){

      return $Child->name;
   })
    ->addColumn('fee', function($Child){
         $fee= $Child->fee;
         $list_id = explode(",",str_replace("'","",$fee));

         $Cost = Cost::whereIn('id',$list_id)->get();
         $name_cost  ='';
         foreach ($Cost as $item) {
           $name_cost .= ' <span class="label label-primary">'.$item->name.'</span> ';
         }
         return $name_cost;
       })
 //   ->addColumn('name_delete', function($Class){
 //     return $Class->name;
 // })
 ->addColumn('STT', function($Child){
   return $Child->row;
})
     ->rawColumns(['STT','namechild','fee','action','update_date'])
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
      ->whereNotIn('is_cost',[1])
      ->where('company_id',Session::get('company_id')) ->get()->toArray();

      return view('declare.child.add_child',compact('code','class','cost'));
  }
  function AddData_Child(Request $request)
  {
      $input = $request->all();
       //  print_r($input);
       // die;

      $input['class'] == null ? $class = 0 : $class = $input['class'];

      if(isset($input['cost'])){
        $cost = implode(",",$input['cost']);
      }
      else{
        $cost= '';
      }

      if( $input['button_action'] == 'insert')
        {
          $class_child = new Child([
                  'code'           =>  $input['code'],
                  'name'           =>  $input['name'],
                  'sex'            =>  $input['sex'],
                  'status'         =>  $input['status'],
                  'family_name'    =>  $input['family'],
                  'address'        =>  $input['address'],
                  'mobile'         =>  $input['mobile'],
                  'class_id'       =>  $class,
                  'fee'           =>  $cost,
                  'create_by'     => Auth::user()->id,
                  'update_date'   => date("Y-m-d H:i:s"),
                  'create_date'   => date("Y-m-d H:i:s"),
                  'company_id'    =>  Session::get('company_id'),
              ]);
          $class_child->save();
            return redirect('/child');
        }

        if($request->get('button_action') == 'update')
          {
              $child = Child::find($input['id']);
              //$child       = $input['id'];
              $child->code = $input['code'];
              $child->name = $input['name'];
              $child->sex =$input['sex'];
              $child->status = $input['status'];
              $child->family_name = $input['family'];
              $child->address = $input['address'];
              $child->mobile = $input['mobile'];
              $child->class_id =$class;
              $child->fee = $cost;

              $child->update_by = Auth::user()->id;
              $child->update_date = date("Y-m-d H:i:s");
              $child->save();


          }
          //   return response()->json(['success'=>'<span class="label label-success">Khởi tạo thành công</span>']);
          return redirect('/child');
  }

    function Get_Code_Child()
    {
         $code = 'HH_'.str_pad( DB::table('hh_type_child')->count('*')+1, 4, "0", STR_PAD_LEFT);
         // print_r($code);
         // die;
         return response()->json([$code]);
    }

    public function EditData_Child($id)
      {
          $data = Child::find($id);
          $classChild = ClassChild::select('id','name')->get();
          $cost = Cost::where('company_id',Session::get('company_id'))->whereNotIn('is_cost',[1]) ->get();
          $fee_id_list = DB::table('hh_child')->select('id','fee')->where('id',$id)->get()->toArray();

          // print_r($fee_id_list);
          // die;
          return view('declare.child.edit_child',compact('classChild','data','cost','fee_id_list'));
      }
    function EditData(Request $request)
    {
        $id = $request->input('id');
        $Child = Child::find($id);
        $output = array(
            'code'    =>  $Child->code,
            'name'    =>  $Child->name,
            'price'    =>  $Child->price,
            'description'    =>  $Child->description,
            'update_date'    =>  $Child->update_date,
            'id'=>$id,
        );
        echo json_encode($output);
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
