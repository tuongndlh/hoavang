<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\item_code;

class AddController extends Controller
{
  public function View()
  {      //Goi trang view trong thu muc user, file create.blade.php
      return view('item_code.Add');
  }
  //action de luu user moi khi form submit

    public function Add(Request $request)
    {
        $allRequest = $request->all();

        $code   = $allRequest['code'];
        $name        = $allRequest['name'];
        $unit        = $allRequest['unit'];
        $properties1      = $allRequest['properties1'];
        $properties2      = $allRequest['properties2'];
        $properties3      = $allRequest['properties3'];
        $properties4      = $allRequest['properties4'];
        $properties5      = $allRequest['properties5'];
        $update_date        = date("Y-m-d H:i:s");
      //  print_r($allRequest);
        $dataInsertToDatabase = array(
            'company_id' => 2,
            'code' => $code,
            'name'      => $name,
            'unit'      => $unit,
            'properties1'      => $properties1,
            'properties2'      => $properties2,
            'properties3'      => $properties3,
            'properties4'      => $properties4,
            'properties5'      => $properties5,
            'update_date'      => $update_date,
        );

       $objItemCode = new item_code();
       $objItemCode->insert($dataInsertToDatabase);
        return redirect('/item_code');
    }
    public function Edit($id)
    {
        $objUser     = new item_code();
        $getItemCodeById = $objUser->find($id)->toArray();
        return view('item_code.Edit')->with('getItemCodeById', $getItemCodeById);
    }
    public function update(Request $request)
    {
        $allRequest = $request->all();
        $code   = $allRequest['code'];
        $name        = $allRequest['name'];
        $unit        = $allRequest['unit'];
        $properties1      = $allRequest['properties1'];
        $properties2      = $allRequest['properties2'];
        $properties3      = $allRequest['properties3'];
        $properties4      = $allRequest['properties4'];
        $properties5      = $allRequest['properties5'];


        $id_ItemCode   = $allRequest['id'];

        $objUser               = new item_code();
        $getItemCodeById           = $objUser->find($id_ItemCode);
        $getItemCodeById->code = $code;
        $getItemCodeById->name      = $name;
        $getItemCodeById->unit      = $unit;
        $getItemCodeById->properties1      = $properties1;
        $getItemCodeById->properties2      = $properties2;
        $getItemCodeById->properties3      = $properties3;
        $getItemCodeById->properties4      = $properties4;
        $getItemCodeById->properties5      = $properties5;
        $getItemCodeById->update_date      = date("Y-m-d H:i:s");
        $getItemCodeById->save();

        return redirect('/item_code');
    }
    public function destroy($id)
    {
        // item_code::find($id)->delete();
        // return redirect('/item_code');

        $item_code = item_code::find($id);
        if($item_code != null) {
            $item_code->delete();          
            return redirect()->action('HomeController@View_Item_Code');
        }
        return redirect()->action('HomeController@View_Item_Code');
    }
}
