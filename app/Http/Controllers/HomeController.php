<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\item_code;
use App\customer;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }


    // Khách hàng
    public function Get_Customer()
    {
      return Datatables::of(customer::query())->make(true);
    }
    public function View_Customer()
     {
       return view('customer.index');
     }
     // Sản phẩm
     public function Get_Item_Code()
     {
      // return Datatables::of(item_code::query())->make(true);
      $item_code = item_code::select(['id','code','name', 'unit','tax','price','update_date']);

      return Datatables::of($item_code)
      ->addColumn('action', function ($item_code) {
              return '<a href="itemcode/'. $item_code->id.'/edit"> <i class="fa far fa-edit"></i> Sửa</a>
              <a onclick="return myFunction();" href="itemcode/'.$item_code->id.'/delete"><i class="fa fa-trash"></i> Xóa</a>';

          })
          ->editColumn('id', '{{$id}}')
          ->setRowId('id')
          ->make(true);
     }
     public function View_Item_Code()
      {
        return view('item_code.index');
      }
}
