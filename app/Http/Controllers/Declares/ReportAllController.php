<?php

namespace App\Http\Controllers\Declares;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Declares\ReportAll;
use App\Models\Declares\ReportAllInput;
use Auth;
use Session;
use DB;
use Carbon;
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
     //$Report_All = ReportAll::select();
     $company_id =Session::get('company_id');
     $query =  "select t1.id, t1.name_content, t2.quantity, t1.update_date from hv_report_all t1
                    left join hv_report_input t2 on t2.report_all_id = t1.id
                    where t1.company_id = $company_id";
    $Report_All = DB::select($query);

     return Datatables::of($Report_All)

     ->addColumn('name_content', function($Report_All){
      return '<span class="label label-info">'.$Report_All->name_content.'</span>';
   })
   ->addColumn('quantity', function($Report_All){
    return '<input type="text" class="quantity" id="'."quantity".$Report_All->id.'" name="quantity" value="'.$Report_All->quantity.'" />';
 })

     ->rawColumns(['name_content','quantity'])
     ->editColumn('id', '{{$id}}')
     ->setRowId('id')
     ->make(true);
    }

    function AddData(Request $request)
    {
        //    print_r($request->all());die;
        $input = $request->all();
              $query  = ReportAllInput::where('report_all_id',$input['id'])
              ->where('user_id', Auth::user()->id)
              ->where('month', date('m').'-'.date('Y'))
              ->first();
 //print_r($query);die;
              if(!isset($query)){
                $ReportAllInput = new ReportAllInput([
                    'user_id'        =>  Auth::user()->id,
                    'report_all_id'  =>  $input['id'],
                    'quantity'       =>  $input['value'],
                    'month'          =>  date('m').'-'.date('Y'),
                    'update_date'    =>  Create_dateVN(),
                    'create_date'    =>  Create_dateVN(),
                    'create_by'      =>  Auth::user()->id,
                    'company_id'     =>  Session::get('company_id'),
                ]);
                $ReportAllInput->save();

              }else{
                    $ReportAllInput = ReportAllInput::find($input['id']);
                    $ReportAllInput->quantity = $input['value'];
                    $ReportAllInput->update_by = Auth::user()->id;
                    $ReportAllInput->update_date = Create_dateVN();
                    $ReportAllInput->save();
              }
                ReportAll::where('id', $input['id'])
                ->update([
                         'update_date' =>  Create_dateVN(),
                       ]);

              return response()->json('success');
    }


}
