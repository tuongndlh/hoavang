<?php

namespace App\Http\Controllers\Account;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\User;
use App\Models\Account\UserAcc;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\RegisterRequest;
use Auth;
use Session;
use DB;

class UserController extends Controller
{

    public function index()
    {
      $dept = DB::table('lh_department')->select('id','name')
      ->where('company_id',Session::get('company_id'))->orderBy('name')->get();

      $manager_assign = DB::table('users')->select('id','fullname')
      ->where('company_id',Session::get('company_id'))
      ->where('ismanager',1)
      ->orderBy('fullname')->get();

      $ismanager = DB::table('users')->select('ismanager')
      ->where('company_id',Session::get('company_id'))
      ->orderBy('fullname')->get();
      // print_r($ismanager);
      // die;
       return view('account.user.index',compact('dept','manager_assign','ismanager'));
    }


    public function create()
    {
            $department = Department::select('id','name')->get()->toArray();
            return view('account.user.add',compact('department'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        // print_r($input);
        // die;
        if( $input['button_action'] == 'insert')
        {

            $User = new UserAcc([
                'code'               =>  $input['code'],
                'fullname'           =>  $input['name'],
                'username'           =>  $input['username'],
                'password'           =>  bcrypt($input['password']),
                'department_id'      =>  $input['dept'],
                'email'              =>  $input['email'],
                'mobile'             =>  $input['mobile'],
                'persional_id'       =>  $input['cmnd'],
                'manager_assign'     =>  $input['manager_assign'],
                'status'             =>  1,
                'birthday'           =>  date('Y-m-d', strtotime($input['birthday'])),
                'sex'                =>  $input['sex'],
                'ismanager'          =>  $input['ismanager'],
                'description'    =>  $input['description'],
                'updated_date'    =>  date("Y-m-d H:i:s"),
                'created_date'    =>  date("Y-m-d H:i:s"),
                'create_by'      =>  Auth::user()->id,
                'company_id'     =>  Session::get('company_id'),
            ]);

            $User->save();
          //  return redirect('/user');
          //  return back()->with('success', '<div class="alert alert-success">Data Inserted</div>');
            return response()->json(['success'=>'<span class="label label-success">Khởi tạo thành công</span>']);

        }

        //print_r($data_user);

    }
    public function blank()
     {
       return view('blank');
     }
    public function Get_User()
     {
      $company_id = Session::get('company_id');
      $querydata ="SELECT @rownum := @rownum + 1 AS row,t.*
  FROM
       ( select u2.fullname as manager,u.* ,d.name as dept,@rownum := 0 from users u
        LEFT JOIN lh_department as d ON d.id=u.department_id
				LEFT JOIN users as u2 on u2.id = u.manager_assign
				 WHERE  u.company_id=$company_id) t ORDER BY created_date DESC";
      $user = DB::select($querydata);

      return Datatables::of($user)

      ->addColumn('stt',function($user){
          return $user->row;
      })
      ->addColumn('action', function ($user) {
          return '<a href="#" class="edit" id="'.$user->id.'"><i class="fa far fa-edit"></i> Sửa</a>
           <a href="#" class="delete" id="'.$user->id.'"><i class="fa fa-trash"></i> Xóa</a>';
          })
      ->addColumn('fullname', function($user){
        if($user->sex == 1){
          $sex = '<a data-popup="tooltip"  title="Nam"><i class="fas fa-male fa-lg" style="color:#2196F3"></i></a>';
        }else {
            $sex = '<a data-popup="tooltip"  title="Nữ"><i class="fas fa-female fa-lg" style="color:orange "></i></a>';
        }
        return $sex.' - '.$user->fullname.' ('.$user->code.')'.'</br>'.'<span class="label label-success">'.$user->dept.'</span>';
    })
      ->rawColumns(['stt','fullname','action'])
      ->editColumn('id', '{{$id}}')
      ->setRowId('id')
      ->make(true);

     }

     public function edit(Request $request)
    {
        $id = $request->input('id');
        $data = UserAcc::find($id);
        // print_r($data);
        // die;
        $output = array(
            'fullname'         =>  $data->fullname,
            'username'         =>  $data->username,
            'sex'              =>  $data->sex,
            'dept'             =>  $data->department_id,
            'email'            =>  $data->email,
            'mobile'           =>  $data->mobile,
            'cmnd'             =>  $data->persional_id,
            'birthday'         =>  $data->birthday,
            'manager_assign'   =>  $data->manager_assign,
            'ismanager'        =>  $data->ismanager,
            'description'      =>  $data->description,
            'id'=>$id,
        );
        $department = DB::table('lh_department')->select('name','id')
        ->WHERE('company_id', Session::get('company_id'))->get();

        $manager_assign = DB::table('users')->select('id','fullname')
        ->where('company_id',Session::get('company_id'))
        ->where('ismanager',1)
        ->orderBy('fullname')->get();

        return response()->json([$output,$department,$manager_assign]);
        //return view('account.user.index',compact('data','dept','manager_assign','ismanager'));
    }


    public function update(Request $request, $id)
    {
        $data_user = User::find($id);
        $data_user->company_id = Session::get('company_id');
        $data_user->department_id   = $request->department_id;
        $data_user->fullname   = $request->fullname;
        $data_user->username   = $request->username;
        $data_user->position   = $request->position;
        $data_user->email   = $request->email;
        $data_user->tel   = $request->tel;
        $data_user->mobile   = $request->mobile;
        $permission=$request->permission;
        if($permission == 0){
          $data_user->permission = 0;
        }
        else{
          $data_user->permission   = $permission;
        }

        $data_user->comment   = $request->comment;
        $data_user->update_by = Auth::user()->id;
        $data_user->save();

        if(strlen($request->password)){
            $data_user->password = bcrypt($request->password);
            $data_user->save();
          }
        return redirect('/user');
    }


    function ChangeLock($id,$lock)
    {
      $data_user = User::find($id);
      if($lock == 0){
        $locked =1;
      }
      else{
        $locked =0;
      }
      $data_user->update_by = Auth::user()->id;
      $data_user->locked = $locked;
      $data_user->save();
      return redirect('/user');
    }

}
