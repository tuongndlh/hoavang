<?php

namespace App\Http\Controllers\Declares;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Declares\Cost;
use Auth;
use Session;
use DB;
class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('declare.cost.index');
    }
    public function Get_Cost()
    {
     // return Datatables::of(item_code::query())->make(true);
     $Cost = Cost::select()->where('company_id', Session::get('company_id'));

     return Datatables::of($Cost)
     ->addColumn('action', function($Cost){
         return '<a href="#" class="edit" id="'.$Cost->id.'"><i class="fa far fa-edit"></i> Sửa</a>
          <a href="#" class="delete" id="'.$Cost->id.'"><i class="fa fa-trash"></i> Xóa</a>';
     })
     ->addColumn('name', function($Cost){
      return '<span class="label label-info">'.$Cost->name.'</span>'.' - '.'<i>'.$Cost->description.'</i>';
   })
   ->addColumn('name_delete', function($Class_){
     return $Class_->name;
 })
     ->rawColumns(['name','action','name_delete'])
     ->editColumn('id', '{{$id}}')
     ->setRowId('id')
     ->make(true);
    }
    function Get_Code_Cost()
    {
         $code = 'HH_COST_'.str_pad( DB::table('hh_type_cost')->count('*')+1, 4, "0", STR_PAD_LEFT);
         // print_r($code);
         // die;
         return response()->json([$code]);
    }
    function AddData(Request $request)
    {
            $input = $request->all();
          //  print_r($input);die;
            if( $input['button_action'] == 'insert')
            {
                $Cost = new Cost([
                    'code'           =>  $input['code'],
                    'name'           =>  $input['name'],
                    'rollback'       =>  $input['rollback'],
                    'is_cost'        =>  $input['is_cost'],
                    'price'          =>  str_replace(',','',$input['price']),
                    'other'          =>  $input['other'],
                    'date_apply'     =>  $input['date_apply'],
                    'description'    =>  $input['description'],
                    'update_date'    =>  Create_dateVN(),
                    'create_date'    =>  Create_dateVN(),
                    'create_by'      =>  Auth::user()->id,
                    'company_id'     =>  Session::get('company_id'),
                ]);

                $Cost->save();
              //  return back()->with('success', '<div class="alert alert-success">Data Inserted</div>');
                return response()->json(1);

            }

            if($request->get('button_action') == 'update')
            {
              //print_r($input);die;
                $Cost = Cost::find($input['id']);
                $Cost->code = $input['code'];
                $Cost->name = $input['name'];
                $Cost->rollback = $input['rollback'];
                $Cost->is_cost = $input['is_cost'];
                $Cost->date_apply = $input['date_apply'];
                $Cost->price = str_replace(',','',$input['price']);
                $Cost->description = $input['description'];
                $Cost->update_date = Create_dateVN();
                $Cost->update_by =  Auth::user()->id;
                $Cost->save();
              //  $success_output = '<div class="alert alert-success">Data Updated</div>';
                return response()->json(1);
            }

    }
    function EditData(Request $request)
    {
        $id = $request->input('id');
        $Cost = Cost::find($id);
        $output = array(
            'code'           =>  $Cost->code,
            'name'           =>  $Cost->name,
            'price'          =>  $Cost->price,
            'rollback'       =>  $Cost->rollback,
            'is_cost'        =>  $Cost->is_cost,
            'other'          =>  $Cost->other,
            'date_apply'     =>  $Cost->date_apply,
            'description'    =>  $Cost->description,
            'update_date'    =>  $Cost->update_date,
            'id'=>$id,
        );
          return response()->json([$output]);
      //  echo json_encode($output);
    }
    public function DeleteData(Request $request)
    {
        $id = $request->input('id');

        $Cost = Cost::find($id);
        if($Cost != null) {
            $Cost->delete();
            return response()->json(['success'=>'<span class="label label-success">Xóa thành công</span>']);
        }

    }
}
