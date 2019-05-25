<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\group_customer;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Validator;
use Session;

class GroupCustomerController extends Controller
{
    public function List()
    {
          return view('customers.group_customer.index');
    }

    public function Get_List()
    {
     // return Datatables::of(item_code::query())->make(true);
     $group_customer = group_customer::select(['id','name', 'point_from','point_to','update_date']);

     return Datatables::of($group_customer)
     ->addColumn('action', function($group_customer){
         return '<a href="#" class="edit" id="'.$group_customer->id.'"><i class="fa far fa-edit"></i> Sửa</a>
          <a href="#" class="delete" id="'.$group_customer->id.'"><i class="fa fa-trash"></i> Xóa</a>';
     })
         ->editColumn('id', '{{$id}}')
         ->setRowId('id')
         ->make(true);
    }
    function AddData(Request $request)
    {
            $input = $request->all();
            //print_r($input);
            if( $input['button_action'] == 'insert')
            {
                $group_customer = new group_customer([
                    'name'           =>  $input['name'],
                    'point_from'     =>  $input['point_from'],
                    'point_to'       =>  $input['point_to'],
                    'description'    =>  $input['description'],
                    'update_date'    =>   date("Y-m-d H:i:s"),
                    'create_date'    =>   date("Y-m-d H:i:s"),
                    'company_id'    =>   2,
                ]);

               $group_customer->save();
               //return back()->with('success', '<div class="alert alert-success">Data Inserted</div>');
                return response()->json(['success'=>'<span class="label label-success">Khởi tạo thành công</span>']);

            }

            if($request->get('button_action') == 'update')
            {
                $group_customer = group_customer::find($input['id']);
                $group_customer->name = $input['name'];
                $group_customer->point_from = $input['point_from'];
                $group_customer->point_to = $input['point_to'];
                $group_customer->description = $input['description'];
                $group_customer->update_date = date("Y-m-d H:i:s");
                $group_customer->save();
              //  $success_output = '<div class="alert alert-success">Data Updated</div>';
              return response()->json(['success'=>'<span class="label label-success">Cập nhật thành công</span>']);
            }
    }
    function EditData(Request $request)
    {
        $id = $request->input('id');
        $group_customer = group_customer::find($id);
        $output = array(
            'name'    =>  $group_customer->name,
            'point_from'    =>  $group_customer->point_from,
            'point_to'    =>  $group_customer->point_to,
            'description'    =>  $group_customer->description,
            'update_date'    =>  $group_customer->update_date,
            'id'=>$id,
        );
        echo json_encode($output);
    }
    public function DeleteData(Request $request)
    {
        $id = $request->input('id');

        $group_customer = group_customer::find($id);
        if($group_customer != null) {
            $group_customer->delete();
            return response()->json(['success'=>'<span class="label label-success">Xóa thành công</span>']);
        }

    }
}
