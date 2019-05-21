<?php

namespace App\Http\Controllers\Account;

use App\Models\Account\User_assign;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\Account\UserAssignRequest;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Session;
use DB;

class UserAssignController extends Controller
{

    public function Get_View_User($id)
    {
        $data_user = User::find($id);
        return view('Account.user.view.index',compact('data_user'));
    }



    public function Get_View_Add_Detail($id)
    {
        $user_id = $id;
        return view('Account.user.view.add-detail',compact('user_id'));
    }

    public function List_User_Add_Manager($id)
    {
        $company_id = Session::get('company_id');
        $querydata ="
        SELECT (@row := @row + 1) AS row, id, fullname, email 
        from users t, (SELECT@row := 0) r where t.id <> '$id'
        and company_id = $company_id and not exists
        (select 1 from biz_user_assign where user_id = '$id' and user_member_id=t.id)";
        $data_user = DB::select($querydata);
        return Datatables::of($data_user)
      ->editColumn('stt',function($data_user){
        return $data_user->row;
      })
      ->addColumn('name',function($data_user){
        return $data_user->fullname;
      })
      ->addColumn('action', function ($data_user) {
              return '
              <input class="styled item_check"  type="checkbox" id="check" name="check[]" value="'.$data_user->id.'" >';

          })

      ->rawColumns(['action'])
      ->editColumn('id', '{{$id}}')
        ->setRowId('id')
      ->make(true);

    }




    public function Get_User_Manager($id)
     {
      $query = DB::table(DB::raw('biz_user_assign, (SELECT @row := 0) r'));
      $user_manager = $query
      ->select([
        DB::raw('@row := @row + 1 AS row'),
        'id','user_id','user_member_id','note'])->where('user_id',$id) ->get();
      
      return Datatables::of($user_manager)
      ->editColumn('stt',function($user_manager){
        return $user_manager->row;
      })
      ->addColumn('name',function($user_manager){
        $name= User::where('id',$user_manager->user_member_id)->first();

        return $name->fullname;
      })
      ->addColumn('email',function($user_manager){
        $email= User::where('id',$user_manager->user_member_id)->first();

        return $email->email;
      })
      ->addColumn('action', function ($user_manager) {
              return '
              <a href="#" id="'.$user_manager->id.'" class="delete"><i class="fa fa-trash"></i> Xóa</a>';

          })

      ->rawColumns(['action'])
      ->editColumn('id', '{{$id}}')
        ->setRowId('id')
      ->make(true);

    }

    
    
    public function AddUser(UserAssignRequest $request)
    {


        $user_id = $request->user_id;

        foreach ($request->check as $checkbox) {
          $user_assign = new User_assign();
          if(isset($checkbox)){
            $user_assign->user_id = $user_id;
            $user_assign->user_member_id = $checkbox;
            $user_assign->create_by = Auth::user()->id;
            
            $user_assign->save();
          }
        }

        return redirect('user/view/'.$user_id);
    }



    public function DeleteData(Request $request)
    {
        $id = $request->input('id');

        $user_manager = User_assign::find($id);

          if($user_manager != null){
            $user_manager->delete();
           }
        return response()->json(['success'=> '<span class="label label-success">Xóa thành công</span>']);

    }



}
