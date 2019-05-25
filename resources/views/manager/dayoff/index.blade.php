@extends('master')
@section('content')
<html lang="en">
<head>
      <script src="{{ asset('public/js/jquery-3.2.1.js') }}"></script>
      <script src="{{ asset('public/maskmoney/jquery.maskMoney.js') }}"></script>
</head>

<body>

<section class="content">
    <div class="row">
      <div class='notifications text-right'></div>
        <span class="alert alert-success" role="alert" style="display:none" ></span>
      </div>
      <div class="col-md-12">

        <ol class="breadcrumb">
         <!-- <li class="breadcrumb-item">Home</li> -->
         <li class="breadcrumb-item"><a href="/hoahong"><i class="fa far fa-arrow-circle-left"></i> Trang chủ</a></li>
         <li class="breadcrumb-item active" href="{{route('child')}}">Danh sách các cháu</li>
       </ol>
      <div class="content-header">
          <div class="panel panel-flat">
             <div class="form-group row">
                <label class="control-label col-sm-2 text-right ">Lọc theo lớp:</label>
                 <div class="col-sm-2">
                 <select class="select custom-select" id="name_class" data-width="100%"  data-placeholder="">

                   <option value="0">Tất cả </option>
                   @foreach ($class as $group_item)
                         <option value="{{ $group_item->id}}">{{ $group_item->name}}</option>
                     @endforeach
                 </select>
               </div>
            </div>
            </div>
         </div>


          <div class="content-header">
             <div class="panel panel-flat">
               <ol class="panel-heading">
                 <div >
                    <h2 class="panel-title">Nhập ngày nghỉ trong tháng trước</h2>
                 </div>
                </ol>



                <div class="panel-body">
                    <div class="table-responsive">
                      <div class="container-fluid">
                         <div class="animate fadeIn">
                            <div class="panel-body">
                             <table width="100%" class="display nowrap" style="width:100%" cellspacing="0" id="table">
                               <thead>
                                 <tr>
                                   <th> STT </th>
                                   <th>Tên cháu</th>
                                   <th>Lớp</th>
                                   <th>Ngày nghỉ</th>
                                   <th>Miễn giảm</th>
                                   <th></th>
                                   <th></th>
                                 </tr>
                               </thead>
                             </table>
                           </div>
                        </div>
                       </div>
                    </div>
                    <!-- /.table-responsive -->
                </div>
             </div>
          </div>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
<div id="dayoff" class="modal fade" role="dialog"  data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
      <form method="POST" id="dayoff_form" >
        <div class="modal-header  bg-primary">
          <h4 class="modal-title">Thêm mới</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body modal-body-new">
        <div class="form-group row">
          <label class="control-label col-sm-3">Số ngày nghỉ</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="dayoff_input" id="dayoff_input" placeholder="Nhập số ngày nghỉ" value="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <!-- <input type="hidden" name="group_id" id="group_id" value="" /> -->
          <input type="hidden" name="button_action" id="button_action" value="insert" />
          <button type="submit" name="submit" id="action" class="btn btn-primary">Lưu dữ liệu</button>
      </div>
      </form>
        </div>
    </div>
</div>

<div id="discount" class="modal fade" role="dialog"  data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
      <form method="POST" id="discount_form" >
        <div class="modal-header  bg-primary">
          <h4 class="modal-title">Thêm mới</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body modal-body-new">
        <div class="form-group row">
          <label class="control-label col-sm-4">Số tiền miễn giảm <span class="text-danger"></span></label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="discount_input" id="discount_input"
            placeholder="Nhập số tiền miễn giảm" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-sm-4">Ghi chú <span class="text-danger"></span></label>
          <div class="col-sm-8">
              <textarea rows="5" cols="5" class="form-control" id="description" name="description" placeholder="Nhập ghi chú" ></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <!-- <input type="hidden" name="group_id" id="group_id" value="" /> -->
          <input type="hidden" name="button_action" id="button_action" value="insert" />
          <button type="submit" name="submit" id="action" class="btn btn-primary">Lưu dữ liệu</button>
      </div>
      </form>
        </div>
    </div>
</div>

  <script type="text/javascript">
  $('#discount_input').maskMoney({thousands: ',', decimal: '.', precision: 0});
  $("#dayoff_input").keypress(function(event){
          // console.log(event.which);
       if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
           event.preventDefault();
       }});

  $(document).ready(function() {

  //   $('#name_class li').on('click', function(){
  //     alert($(this).text());
  // });
    $('.select').select2({
              allowClear: true,
              //minimumResultsForSearch: Infinity,
            });
           $(function() {
var allUsersTable =   $('#table').DataTable({
                 processing: true,
                 serverSide: true,
                 ajax: {
                        url :   '{!! route('dayoff_ajax') !!}',
                        data: function(d){
                            d.level =   $('#name_class').val()
                        }
                    },

                 columns: [
                  { data: 'STT', },
                  { data: 'namechild' },
                  { data: 'classname', },
                  { data: 'dayoff',name: 'dayoff'},
                  { data: 'discount'},
                  { data: 'Up_date',visible:false},
                  { data: 'child_id',visible:false },
                   ],
                  "iDisplayLength": 25,
                   order: [5, 'desc'],
                  "language": {
                  "url": "public/Vietnamese.json"

                },
              });
              $('#name_class').change(function (e) {
            allUsersTable.draw();
        });

           });



           // DayOff
           $(document).on('click', '.dayoff', function(){
               $('#dayoff').modal('show');
               var id = $(this).attr("id");
               window.id = $(this).attr("id");
              // alert( window.id );
           });
         })
         // Discount
         $(document).on('click', '.discount', function(){
             //$('#discount_input').html('');
             $('#discount').modal('show');
             var id = $(this).attr("id");
             window.child_id = $(this).attr("id");
          //  alert(window.child_id);
         });


         // Insert DayOff
         $('#dayoff_form').on('submit', function(event){
                   event.preventDefault();
                   //
                    var dayoff = $("#dayoff_input").val();
                    var button_action = $("#button_action").val();
                   $.ajax({
                       url:"{{route('add_dayoff')}}",
                       method:'POST',
                       data:{
                         id:window.id,
                         dayoff:dayoff,
                         button_action:button_action,
                          _token: '{{csrf_token()}}'},

                        dataType:'JSON',
                       success:function(data)
                       {
                           $('#dayoff').modal('hide');
                           $("#dayoff_input").val("");
                           $('#button_action').val('insert');
                           $('#table').DataTable().ajax.reload();
                       }
                   })
              })
              // Edit DayOff
              $(document).on('click', '.dayoff_edit', function(){
                    var id = $(this).attr("id");
                    window.id = $(this).attr("id");;
                //  $('#dayoff_form').html('');
                  $.ajax({
                      url:"{{route('edit_dayoff')}}",
                      method:'GET',
                      data:{id:id, _token: '{{csrf_token()}}'},
                      dataType:'JSON',
                      success:function(data)
                      {

                          $('#dayoff_input').val(data.dayoff);
                           $('#dayoff').modal('show');
                           $('#action').val('Edit');
                           $('.modal-title').text('Sửa dữ liệu');
                           $('#button_action').val('update');
                      }
                  })
              });
              // Insert Discount
              $('#discount_form').on('submit', function(event){
                        event.preventDefault();
                         var discount = $("#discount_input").val();
                         var description = $("#description").val();
                         var button_action = $("#button_action").val();
                        $.ajax({
                            url:"{{route('add_discount')}}",
                            method:'POST',
                            data:{
                               id:window.child_id,
                              discount:discount,
                              description:description,
                              button_action:button_action,
                               _token: '{{csrf_token()}}'},

                             dataType:'JSON',
                            success:function(data)
                            {
                                $('#discount').modal('hide');
                                $("#discount_input").val("");
                                $("#description").val("");
                                $('#button_action').val('insert');
                                $('#table').DataTable().ajax.reload();
                            }
                        })
                   })
                   // Edit Discount
                   $(document).on('click', '.discount_edit', function(){
                         var id = $(this).attr("id");
                         window.child_id = $(this).attr("id");;
                        // alert(id);
                       $.ajax({
                           url:"{{route('edit_discount')}}",
                           method:'GET',
                           data:{id:id, _token: '{{csrf_token()}}'},
                           dataType:'JSON',
                           success:function(data)
                           {
                                $('#discount_input').val(data.discount);
                                $('#description').val(data.description);
                                $('#discount').modal('show');
                                $('#action').val('Edit');
                                $('.modal-title').text('Sửa dữ liệu');
                                $('#button_action').val('update');
                           }
                       })
                   });


         </script>

   </body>
</html>
@endsection
