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
use Config;
use Excel;
class AdminViewReportAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('declare.report_all.index_reportAll');
    }

    public function Get_Admin_Report_All(Request $request)
    {
         //$Report_All = ReportAll::select();
     $input = $request->all();
     $user_id = Auth::user()->id;
     $company_id =Session::get('company_id');

     // $query =  "SELECT t1.id, t1.name_content,t1.parent_id, t2.quantity, t2.month from hv_report_all t1
     //                left join hv_report_input t2 on t2.report_all_id = t1.id
     //                where t1.company_id = $company_id and t2.user_id = $user_id $input_date_month ORDER BY t1.id";
     $query =  "SELECT  t1.id, t1.name_content,t1.parent_id, t1.update_date,
                   (SELECT sum(quantity) from hv_report_input where  user_id =2 and report_all_id = t1.id)  HoaBac,
            			 (SELECT sum(quantity) from hv_report_input where  user_id =3 and report_all_id = t1.id)  HoaNinh,
            			 (SELECT sum(quantity) from hv_report_input where  user_id =4 and report_all_id = t1.id)  Hoalien,
            			 (SELECT sum(quantity) from hv_report_input where  user_id =5 and report_all_id = t1.id)  Hoason,
            			 (SELECT sum(quantity) from hv_report_input where  user_id =6 and report_all_id = t1.id)  Hoachau,
            			 (SELECT sum(quantity) from hv_report_input where  user_id =7 and report_all_id = t1.id)  Hoatien,
            			 (SELECT sum(quantity) from hv_report_input where  user_id =8 and report_all_id = t1.id)  Hoaphuoc,
            			 (SELECT sum(quantity) from hv_report_input where  user_id =9 and report_all_id = t1.id)  Hoaphong,
            			 (SELECT sum(quantity) from hv_report_input where  user_id =10 and report_all_id = t1.id) Hoakhuong,
            			 (SELECT sum(quantity) from hv_report_input where  user_id =11 and report_all_id = t1.id) Hoanhon,
            			 (SELECT sum(quantity) from hv_report_input where  user_id =11 and report_all_id = t1.id) Hoaphu
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
     ->rawColumns(['name_content'])
     ->editColumn('id', '{{$id}}')
     ->setRowId('id')
     ->make(true);
    }

    public function downloadExcel($type)
     {
       $company_id =Session::get('company_id');
       $query =  "SELECT  t1.id , t1.name_content,t1.parent_id,
                    (SELECT sum(quantity) from hv_report_input where  user_id =2 and report_all_id = t1.id)  HoaBac,
                    (SELECT sum(quantity) from hv_report_input where  user_id =3 and report_all_id = t1.id)  HoaNinh,
                    (SELECT sum(quantity) from hv_report_input where  user_id =4 and report_all_id = t1.id)  Hoalien,
                    (SELECT sum(quantity) from hv_report_input where  user_id =5 and report_all_id = t1.id)  Hoason,
                    (SELECT sum(quantity) from hv_report_input where  user_id =6 and report_all_id = t1.id)  Hoachau,
                    (SELECT sum(quantity) from hv_report_input where  user_id =7 and report_all_id = t1.id)  Hoatien,
                    (SELECT sum(quantity) from hv_report_input where  user_id =8 and report_all_id = t1.id)  Hoaphuoc,
                    (SELECT sum(quantity) from hv_report_input where  user_id =9 and report_all_id = t1.id)  Hoaphong,
                    (SELECT sum(quantity) from hv_report_input where  user_id =10 and report_all_id = t1.id) Hoakhuong,
                    (SELECT sum(quantity) from hv_report_input where  user_id =11 and report_all_id = t1.id) Hoanhon,
                    (SELECT sum(quantity) from hv_report_input where  user_id =11 and report_all_id = t1.id) Hoaphu,
                    t1.update_date
               from hv_report_all t1
              where t1.company_id = $company_id ORDER BY t1.id ";
          $output = DB::select($query);
          $array = array();
          foreach ($output as  $item) {

                  $data_row = array(
                        'STT'         => $item->id ,
                        'Nội dung'    =>  str_replace('</br>', '', $item->name_content) ,
                        'Hòa Bắc'     => $item->HoaBac    != null ? number_format_drop_zero_decimals($item->HoaBac,3) : null ,
                        'Hòa Ninh'    => $item->HoaNinh   != null ? number_format_drop_zero_decimals($item->HoaNinh,3) : null ,
                        'Hòa Liên'    => $item->Hoalien   != null ? number_format_drop_zero_decimals($item->Hoalien,3) : null ,
                        'Hòa Sơn'     => $item->Hoason    != null ? number_format_drop_zero_decimals($item->Hoason,3) : null ,
                        'Hòa Châu'    => $item->Hoachau   != null ? number_format_drop_zero_decimals($item->Hoachau,3) : null ,
                        'Hòa Tiến'    => $item->Hoatien   != null ? number_format_drop_zero_decimals($item->Hoatien,3) : null ,
                        'Hòa Phước'   => $item->Hoaphuoc  != null ? number_format_drop_zero_decimals($item->Hoaphuoc,3) : null ,
                        'Hòa Phong'   => $item->Hoaphong  != null ? number_format_drop_zero_decimals($item->Hoaphong,3) : null ,
                        'Hòa Khương'  => $item->Hoakhuong != null ? number_format_drop_zero_decimals($item->Hoakhuong,3) : null ,
                        'Hòa Nhơn'    => $item->Hoanhon   != null ? number_format_drop_zero_decimals($item->Hoanhon,3) : null ,
                        'Hòa Phú'     => $item->Hoaphu    != null ? number_format_drop_zero_decimals($item->Hoaphu,3) : null ,
                        'Ngày nhập'   => ($item->parent_id != null ? $output[0]->update_date : null)
                  );
                  //  print_r($data_row)
                      array_push($array,$data_row);
                      Config::set('data_row', $array);
                }

          return Excel::create('baocaotonghop', function($excel) use ($output) {
                $excel->sheet('Sheet', function($sheet) use ($output)
                {
                    $data_row=     Config::get('data_row');
                    $data= json_decode( json_encode($data_row), true);
                    $sheet->fromArray($data);
                });            

            })->download($type);
     }


}
