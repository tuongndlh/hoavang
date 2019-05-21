<?php

namespace App\Http\Controllers\Declares;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Declares\ReportAll;
use Auth;
use Session;
use DB;
class ReportAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $group1 = DB::table('hv_report_all')->select('id','name_content')
      ->where('parent_id',null)
      ->orderBy('name_content', 'ASC')
      ->get()->toArray();

      $group2 = DB::table('hv_report_all')->select('id','name_content')
      ->whereNotNull('parent_id')
      ->orderBy('name_content', 'ASC')
      ->get()->toArray();

      return view('declare.report_all.index', compact('group1', 'group2'));
    }
    public function Get_Report_All()
    {
     // return Datatables::of(item_code::query())->make(true);
     $Report_All = ReportAll::select();

     return Datatables::of($Report_All)
     ->addColumn('action', function($Report_All){
         return '<a href="#" class="edit" id="'.$Report_All->id.'"><i class="fa far fa-edit"></i> Sửa</a>
          <a href="#" class="delete" id="'.$Report_All->id.'"><i class="fa fa-trash"></i> Xóa</a>';
     })
     ->addColumn('name', function($Report_All){
      return '<span class="label label-info">'.$Report_All->name.'</span>'.' - '.'<i>'.$Report_All->description.'</i>';
   })
   ->addColumn('name_delete', function($Class_){
     return $Class_->name;
 })
     ->rawColumns(['action','name_delete'])
     ->editColumn('id', '{{$id}}')
     ->setRowId('id')
     ->make(true);
    }

    function AddData(Request $request)
    {


          //  print_r($input);die;
            if( $input['button_action'] == 'insert')
            {
                $Report_All = new ReportAll([
                    'name_content'   =>  $input['name_content'],
                    'parent_id'      =>  $group,
                    'update_date'    =>  Create_dateVN(),
                    'create_date'    =>  Create_dateVN(),
                    'create_by'      =>  Auth::user()->id,
                    'company_id'     =>  Session::get('company_id'),
                ]);

                $Report_All->save();
              //  return back()->with('success', '<div class="alert alert-success">Data Inserted</div>');
                return response()->json(1);

            }

            if($request->get('button_action') == 'update')
            {
              //print_r($input);die;
                $Report_All = ReportAll::find($input['id']);
                $Report_All->code = $input['code'];
                $Report_All->name = $input['name'];
                $Report_All->rollback = $input['rollback'];
                $Report_All->is_Report_All = $input['is_Report_All'];
                $Report_All->price = str_replace(',','',$input['price']);
                $Report_All->description = $input['description'];
                $Report_All->update_date = Create_dateVN();
                $Report_All->update_by =  Auth::user()->id;
                $Report_All->save();
              //  $success_output = '<div class="alert alert-success">Data Updated</div>';
                return response()->json(1);
            }

    }
    function EditData(Request $request)
    {
        $id = $request->input('id');
        $Report_All = ReportAll::find($id);
        $output = array(
            'code'    =>  $Report_All->code,
            'name'    =>  $Report_All->name,
            'price'    =>  $Report_All->price,
            'rollback'    =>  $Report_All->rollback,
            'is_Report_All'    =>  $Report_All->is_Report_All,
            'description'    =>  $Report_All->description,
            'update_date'    =>  $Report_All->update_date,
            'id'=>$id,
        );
          return response()->json([$output]);
      //  echo json_encode($output);
    }
    public function DeleteData(Request $request)
    {
        $id = $request->input('id');

        $Report_All = ReportAll::find($id);
        if($Report_All != null) {
            $Report_All->delete();
            return response()->json(['success'=>'<span class="label label-success">Xóa thành công</span>']);
        }

    }
}
