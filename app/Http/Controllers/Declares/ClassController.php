<?php

namespace App\Http\Controllers\Declares;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Declares\ClassController;
use Yajra\Datatables\Datatables;
use App\Models\Declares\ClassChild;
use Auth;
use Session;
use DB;
class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $cost = DB::table('hh_type_cost')->select('id','name','price')
      ->where('company_id',Session::get('company_id'))
      ->where('is_cost',1)
      ->where('rollback',0)
      ->orderBy('name')->get();
      return view('declare.class.index',compact('cost'));
    }
    public function Get_Class()
    {
     $cmp = Session::get('company_id');
     $query = "select t2.price, t1.* from hh_class t1
              left join hh_type_cost t2 on t2.id = t1.fee  ";
    $Class_ = DB::select($query);
     return Datatables::of($Class_)
     ->addColumn('action', function($Class_){
         return '<a href="#" class="edit" id="'.$Class_->id.'"><i class="fa far fa-edit"></i> Sửa</a>
          <a href="#" class="delete" id="'.$Class_->id.'"><i class="fa fa-trash"></i> Xóa</a>';
     })
     ->addColumn('name', function($Class_){
       return '<span class="label label-success">'.$Class_->name.'</span>'.' - '.'<i>'.$Class_->description.'</i>';
   })
     ->addColumn('name_delete', function($Class_){
       return $Class_->name;
   })
     ->rawColumns(['name','action','name_delete'])
     ->editColumn('id', '{{$id}}')
     ->setRowId('id')
     ->make(true);
    }
    function Get_Code()
    {
         $code = 'HH'.str_pad( DB::table('hh_class')->count('*')+1, 4, "0", STR_PAD_LEFT);
         return response()->json([$code]);
    }
    function AddData(Request $request)
    {
            $input = $request->all();
            $code = 'HH'.str_pad( DB::table('hh_class')->count('*')+2, 4, "0", STR_PAD_LEFT);
            if( $input['button_action'] == 'insert')
            {
                $Class = new ClassChild([
                    'code'           =>  $input['code'],
                    'name'           =>  $input['name'],
                    'fee'            =>  $input['fee'],
                    'description'    =>  $input['description'],
                    'update_date'    =>  Create_dateVN(),
                    'create_date'    =>  Create_dateVN(),
                    'create_by'      =>  Auth::user()->id,
                    'company_id'     =>  Session::get('company_id'),
                ]);

                $Class->save();
               return response()->json([$code]);
              //  return back()->with('success', '<div class="alert alert-success">Data Inserted</div>');
                // return response()->json(['success'=>'<span class="label label-success">Khởi tạo thành công</span>']);

            }

            if($request->get('button_action') == 'update')
            {
                $ClassChild = ClassChild::find($input['id']);
                $ClassChild->code = $input['code'];
                $ClassChild->name = $input['name'];
                $ClassChild->fee = $input['fee'];
                $ClassChild->description = $input['description'];
                $ClassChild->update_date = Create_dateVN();
                $ClassChild->update_by =  Auth::user()->id;
                $ClassChild->save();
              //  $success_output = '<div class="alert alert-success">Data Updated</div>';
              return response()->json(['success'=>'<span class="label label-success">Cập nhật thành công</span>']);
            }
    }
    function EditData(Request $request)
    {
        $id = $request->input('id');
        $ClassChild = ClassChild::find($id);
        $output = array(
            'code'    =>  $ClassChild->code,
            'name'    =>  $ClassChild->name,
            'fee'     =>  $ClassChild->fee,
            'description'    =>  $ClassChild->description,
            'update_date'    =>  $ClassChild->update_date,
            'id'=>$id,
        );

        $fee = DB::table('hh_type_cost')->select('name','price','id')->where('is_cost','1')->get();
        return response()->json([$output,$fee]);

    }
    public function DeleteData(Request $request)
    {
        $id = $request->input('id');

        $ClassChild = ClassChild::find($id);
        if($ClassChild != null) {
            $ClassChild->delete();
            return response()->json(['success'=>'<span class="label label-success">Xóa thành công</span>']);
        }

    }
}
