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


      return view('declare.report_all.index');
    }



    public function Get_Report_Input(Request $request)
    {
         //$Report_All = ReportAll::select();
     $input = $request->all();
     $company_id =Session::get('company_id');
     $month =   "'".date('m').'-'.date('Y')."'";
     $user_id = Auth::user()->id;
     $query =  "SELECT  t1.id, t1.name_content,t1.parent_id, t1.update_date,
                  (SELECT quantity from hv_report_input where month = $month and user_id =$user_id and report_all_id =t1.id) quantity
                  from hv_report_all t1
                  where t1.company_id = $company_id ORDER BY t1.id ";
    $Report_All = DB::select($query);
     //print_r($query );die;
     return Datatables::of($Report_All)

     ->addColumn('name_content', function($Report_All){
       $Report_All->parent_id != null ? $name_content = '<span>'.$Report_All->name_content.'</span>' :
                                        $name_content = '<span class="label label-success">'.$Report_All->name_content.'</span>';
      return $name_content;
   })
   ->addColumn('quantity', function($Report_All){
     $Report_All->parent_id != null ? $quantity = '<input tabindex="'.$Report_All->id.'"
     type="text" class="quantity" id="'."quantity".$Report_All->id.'" name="quantity"
     value="'.number_format_drop_zero_decimals($Report_All->quantity,3).'" />' : $quantity = null;
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
                $month =   date('m').'-'.date('Y');
                $user_id = Auth::user()->id;
                $report_all_id = $input['id'];
                //  print_r($month,$user_id,$report_all_id);die;
                ReportAllInput::where('report_all_id', $report_all_id)
                  ->where('user_id',$user_id)
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
