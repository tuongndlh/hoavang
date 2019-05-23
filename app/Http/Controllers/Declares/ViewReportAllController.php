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
class ViewReportAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      return view('declare.report_all.index_report');
    }



    public function Get_Report_All(Request $request)
    {
         //$Report_All = ReportAll::select();
     $input = $request->all();
     $user_id = Auth::user()->id;
     $input['input_date_month'] != null ? $input_date_month = 'and t2.month ='."'".$input['input_date_month']."'" : $input_date_month = '';
     $company_id =Session::get('company_id');

     $query =  "select t1.id, t1.name_content,t1.parent_id, t2.quantity, t1.update_date from hv_report_all t1
                    left join hv_report_input t2 on t2.report_all_id = t1.id
                    where t1.company_id = $company_id and t2.user_id = $user_id $input_date_month ORDER BY t1.id";
    $Report_All = DB::select($query);
    print_r($query );die;
     return Datatables::of($Report_All)

     ->addColumn('name_content', function($Report_All){
       $Report_All->parent_id != null ? $name_content = '<span>'.$Report_All->name_content.'</span>' :
                                        $name_content = '<span class="label label-success">'.$Report_All->name_content.'</span>';
      return $name_content;
   })
   ->addColumn('quantity', function($Report_All){
     $Report_All->parent_id != null ? $quantity = number_format_drop_zero_decimals($Report_All->quantity,3) : $quantity = null;
    return $quantity;
  })
  ->addColumn('update_date', function($Report_All){
    $Report_All->parent_id != null ? $update_date = $Report_All->update_date :
                                     $update_date = '';
   return $update_date;

 })

     ->rawColumns(['name_content','quantity','update_date'])
     ->editColumn('id', '{{$id}}')
     ->setRowId('id')
     ->make(true);
    }

    function AddData(Request $request)
    {
        //  print_r($request->all());die;
              $input = $request->all();
              $query  = ReportAllInput::where('report_all_id',$input['id'])
              ->where('user_id', Auth::user()->id)
              ->where('month', date('m').'-'.date('Y'))
              ->first();
            //  print_r($query);die;
              if(!isset($query)){
                $ReportAllInput = new ReportAllInput([
                    'user_id'        =>  Auth::user()->id,
                    'report_all_id'  =>  $input['id'],
                    'quantity'       =>  str_replace(",","",$input['value']),
                    'month'          =>  date('m').'-'.date('Y'),
                    'update_date'    =>  Create_dateVN(),
                    'create_date'    =>  Create_dateVN(),
                    'create_by'      =>  Auth::user()->id,
                    'company_id'     =>  Session::get('company_id'),
                ]);
                $ReportAllInput->save();

              }else{
              // print_r($query);die;
                $month =   "'".date('m').'-'.date('Y')."'";

                ReportAllInput::where('report_all_id', $input['id'])
                  ->where('user_id', Auth::user()->id)
                  ->where('month', $month)
                  ->update([
                           'quantity' => str_replace(",","",$input['value']),
                           'update_by' => Auth::user()->id,
                           'update_date' => Create_dateVN()
                         ]);

              }

                ReportAll::where('id', $input['id'])
                ->update([
                         'update_date' =>  Create_dateVN(),
                       ]);

              return response()->json('success');
    }


}
