<?php

namespace App\Http\Controllers\Account;


use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\Account\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AddUserDepartmentRequest;

use App\User;
use Auth;
use DB;
use Session;

class DepartmentController extends Controller
{
    
    public function index()
    {
        
        return view('Account.department.index');    
    }
    public function store(Request $request)
    {
        $ordeby = Departmemt::count();
        $department               = new Department();
        $department->company_id   = Auth::user()->company_id ;
        $department->name         =$request->name;
        $department->orderby      = $ordeby ;
        $department->lastupdated  = date("Y-m-d H:i:s");
        $department->save();
        return redirect('/department');

    }


    public function Get_Department()
     {
      $department = Department::select(['id','name','orderby', 'lastupdated','name as name_delete'])->get();
      return Datatables::of($department)
      ->editColumn('name',function($department){
        return '<b><a href="department/view/'.$department->id.'">'.$department->name.'</a></b>';
      })
      ->addColumn('action', function ($department) {
              return '<a href="#" id="'. $department->id.'" class="edit"> <i class="fa far fa-edit"></i> Sửa</a>
              <a href="#" id="'.$department->id.'" class="delete"><i class="fa fa-trash"></i> Xóa</a>';

          })
      ->editColumn('lastupdated', function ($department) {
                return date('d-m-Y H:i', strtotime($department->lastupdated));
            })
      ->rawColumns(['name','action'])
      ->editColumn('id', '{{$id}}')
        ->setRowId('id')
      ->make(true);
     }
    function AddData(Request $request)
    {
            $input = $request->all();
            $orderby = DB::table('biz_department')->count();
            $create_by=Auth::user()->id;
            
            if( $input['button_action'] == 'insert')
            {
                $department = new Department([
                    'name'           =>  $input['name'],
                    'lastupdated'    =>  date("Y-m-d H:i:s"),
                    'orderby'    =>  $orderby,
                    'company_id'    =>   Session::get('company_id'),
                ]);

               $department->save();
                return response()->json(['success'=>'<span class="label label-success">Khởi tạo thành công</span>']);

            }

            if($request->get('button_action') == 'update')
            {
                $department = Department::find($input['id']);
                $department->name = $input['name'];
                $department->lastupdated = date("Y-m-d H:i:s");
                $department->save();
               return response()->json(['success'=>'<span class="label label-success">Cập nhật thành công</span>']);
            }
    }
    function EditData(Request $request)
    {
        $id = $request->input('id');
        $department = Department::find($id);
        $output = array(
            'name'    =>  $department->name,
            'lastupdated'    =>  $department->lastupdated,
            'orderby'    =>  $department->orderby,
            'id'=>$id,
        );
        echo json_encode($output);
    }
    
    public function DeleteData(Request $request)
    {
        $id = $request->input('id');
        
        $department = Department::find($id);
        $data = Department::find($id)->User()->get()->toArray();
        if($data == null  ) {
          if($department != null){
            $department->delete();          
           }
          
            return response()->json(['ok']);
          }
        
        return response()->json(['success'=> '<span class="label label-success">Xóa không thành công</span>']);

    }

/*----------------------------------Chi tiết nhóm thành viên----------------------------------*/ 

  public function View_index($id)
    {
        $department = Department::find($id);
        return view('Account.department.view',compact('department'));    
    }


}
