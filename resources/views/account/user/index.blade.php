@extends('master')
@section('content')
<html lang="en">
<head>
        <script src="{{ asset('public/js/jquery.min.js') }}"></script>
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
             <li class="breadcrumb-item"><a href="/linkhouse"><i class="fa far fa-arrow-circle-left"></i> Quản trị</a></li>
             <li class="breadcrumb-item active" href="">Danh sách thành viên</li>
		       </ol>

		        <!-- <div class="panel-body"> -->

					<input type="hidden" name="_token" value="{!! csrf_token() !!}">


						<!-- DK áp dụng -->
						<div class="col-md-12">

							<div class="content-header">
									 <div class="panel panel-flat">
										 <ol class="panel-heading">
											 <div >
													<div class="pull-right">
														<div class="pull-right">
															<div id="add_data"><span class="btn btn-primary"><i class="fa fa-plus-circle fa-fw fa-lg"></i>Thêm mới</span> </div>
														</div>

													</div>
													<h5 class="panel-title">Khai báo nhân viên</h5>
											 </div>
											</ol>
											<div class="panel-body">
													<div class="table-responsive">
														<div class="container-fluid">
															 <div class="animate fadeIn">
																	<div class="panel-body">
                                    <table width="100%" class="box table table-striped table-hover display responsive nowrap m-t-0" cellspacing="0" id="table">
                                      <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên thành viên</th>
                                            <th>Tên đăng nhập</th>
                                            <th>Điện thoại</th>
                                            <th>Email</th>
                                            <th>Quản lý</th>
                                            <th>Đăng nhập lần cuối</th>
                                            <th>Tác vụ</th>
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
									 <!-- /.panel-body -->
						</div>
						</div>
</section>
	  <div id="group_customer" class="modal fade" role="dialog"  data-backdrop="false">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
        <form method="POST" id="group_customer_form" action="{{ route('user.store') }}" autocomplete="off" >
          <div class="modal-header  bg-primary">
            <h4 class="modal-title">Thêm mới</h4>
             <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <div class="modal-body modal-body-new">
          <div class="form-group row">
            <label class="control-label col-sm-4">Hình ảnh</label>
            <div class="col-sm-8">

            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-4">Mã nhân viên <span class="text-danger">*</span></label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="code" id="code"
              value="{!!'LHMT'.str_pad( DB::table('users')->count('*')+1, 4, "0", STR_PAD_LEFT);!!}">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-4">Tên nhân viên <span class="text-danger">*</span></label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="name" id="name"
               required="required" placeholder="Nhập nhân viên" value="">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-4">Tên đăng nhập <span class="text-danger">*</span></label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="username" id="username" required="required"
              placeholder="Nhập tên đăng nhập" value="">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-4">Giới tính<span class="text-danger">*</span></label>
            <div class="col-sm-8">
              <input  required="required" type="radio" name="sex" id ="nam" value="1"> Nam
              <input type="radio"   name="sex" id ="nu"  value="0"> Nữ
            </div>
          </div>
          <div class="form-group row">
                <label class="control-label col-sm-4">Bộ phận <span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                  <select class="select form-control"  required="required" data-width="100%"
                          name="dept" id="dept" data-placeholder="Chọn bộ phận">
                    <option ></option>
                    @foreach ($dept as $group_item)
                        <option value="{{ $group_item->id}}">{{ $group_item->name}}</option>
                    @endforeach
                  </select>
                </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-4">Email<span class="text-danger">*</span></label>
            <div class="col-sm-8">
              <input type="text" class="form-control" required="required"
               required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" name="email" id="email"  placeholder="Nhập email" value="">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-4">Điện thoại</label>
            <div class="col-sm-8">
              <input  class="form-control"  name="mobile" id="mobile"  placeholder="Nhập điện thoại" value="">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-4">CMND <span class="text-danger">*</span></label>
            <div class="col-sm-8">
              <input type="number" class="form-control"  name="cmnd" id="cmnd"
               required="required" placeholder="Nhập CMND" value="">
            </div>
          </div>
          <div class="form-group row {{ $errors->has('birthday') ? ' has-error' : '' }}">
								  <label class="control-label col-sm-4">Ngày sinh <span class="text-danger">*</span></label>
									<div class="col-lg-3 float-right">
										<div class="input-group">
											<span class="input-group-addon"><i class="far fa-calendar-alt fa-lg"></i></span>
											<input type="text"  required="required" placeholder="Nhập ngày sinh"
												class="form-control" name="birthday" id="birthday" value="{{ old('to_date') }}">
      										@if ($errors->has('birthday'))
                              <span class="help-block">
                                  <strong class="alert alert-danger">{{ $errors->first('birthday') }}</strong>
                              </span>
      		                @endif
										</div>
									</div>
					</div>
          <div class="form-group row">
            <label class="control-label col-sm-4">Người quản lý</label>
            <div class="col-sm-8">
              <select class="select form-control" data-width="100%" name="manager_assign" id="manager_assign"
               data-placeholder="Chọn người quản lý">
                <option ></option>
                @foreach ($manager_assign as $group_item)
                    <option value="{{ $group_item->id}}">{{ $group_item->fullname}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-4">Là quản lý</label>
            <div class="col-sm-8">
              <input type="checkbox" name="ismanager" id="ismanager" value=""/>
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
            <button type="submit" onClick="check_type(1)" name="submit" id="action" class="btn btn-primary">Lưu dữ liệu</button>
            <button type="submit" onClick="check_type(2);" name="action_new" id="action_new" class="btn btn-primary" >Lưu & Tạo mới</button>
        </div>
        </form>
          </div>
      </div>
  </div>
      	<script type="text/javascript">

        function check_type(type) {
          window.type = type;
        }
       	$(document).ready(function() {

          $('.select').select2({
           allowClear: true,
           //minimumResultsForSearch: Infinity,
         });
         $("#birthday").datepicker(
             {
                todayHighlight:true,
                clearBtn:true,
                format:'dd-mm-yyyy',
                todayBtn:true,
                autoclose:true,
             }
         )
         $("#mobile,#cmnd").keypress(function(event){
           console.log(event.which);
       if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
           event.preventDefault();
       }});
	         $(function() {
	               $('#table').DataTable({
	               processing: true,
	               serverSide: true,
	               ajax: '{{ url('getlist_user') }}',
	               columns: [
	               			    { data: 'stt', name: 'stt', className : 'text-center'},
	                        { data: 'fullname', name: 'fullname' },
	                        { data: 'username', name: 'username' },
	                        { data: 'mobile', name: 'mobile' },
                          { data: 'email', name: 'email' },
	                        { data: 'manager', name: 'manager' },
	                        { data: 'lastvisited', name: 'lastvisited' , className : 'text-center'},
	                        { data: 'action', name: 'action',  orderable: false, searchable: false, className : 'text-center', },
	                     ],
	                 "iDisplayLength": 25,
	                  order: [0, 'asc'],
	                  "language": {
	                  "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json"
	              				},

	            });
	         });
           // Open
           $('#add_data').click(function(){

                  $('#group_customer').modal('show');
                  $('#group_customer_form')[0].reset();
                  $('#form_output').html('');
                  $('#button_action').val('insert');
                  $('.modal-title').text('Thêm mới');
              });
              // Them du lieu
                 $('#group_customer_form').on('submit', function(event){
                      event.preventDefault();

                      var sex =$('input[name=sex]:checked', '#group_customer_form').val();
                      var code = $("#code").val();
                      var ismanager = $("#ismanager").val();
                      var name = $("#name").val();
                      var username = $("#username").val();
                      var dept = $("#dept").val();
                      var email = $("#email").val();
                      var mobile = $("#mobile").val();
                      var cmnd = $("#cmnd").val();
                      var birthday = $("#birthday").val();
                      var manager_assign = $("#manager_assign").val();
                      var description = $("#description").val();
                      var button_action = $("#button_action").val();
                      var id =  window.id;
                    //  alert(window.type);
                      $.ajax({
                          url:"{{ route('user.store') }}",
                          method:"POST",
                          data:{
                            id:id,
                            code:code,
                            name:name,
                            username:username,
                            password:'abc@123', // pass mặc định
                            sex:sex,
                            dept:dept,
                            email:email,
                            mobile:mobile,
                            cmnd:cmnd,
                            birthday:birthday,
                            manager_assign:manager_assign,
                            ismanager:ismanager,
                            description:description,
                            button_action:button_action,
                            _token: '{{csrf_token()}}'
                          },
                          dataType:"JSON",
                          success:function(data)
                          {
                            //console.log(data[0]);
                                  $('#form_output').html(data.success);
                                  $('#group_customer_form')[0].reset();
                                //  $('form[name=group_customer_form]').get(0).reset();
                                  $('.modal-title').text('Thêm mới');
                                  $('#button_action').val('insert');
                                  $('#table').DataTable().ajax.reload();
                                  if(window.type == 1 ){
                                    $('#group_customer').modal('hide');
                                  }
                          }
                      })
                  });
                  // Sửa
                  $(document).on('click', '.edit', function(){
                      var id = $(this).attr("id");
                      window.id = $(this).attr("id");;
                      //$('#form_output').html('');
                      $.ajax({
                          url:"{{route('user.edit',"id")}}",
                          method:'GET',
                          data:{id:id, _token: '{{csrf_token()}}'},
                          dataType:'JSON',
                          success:function(data)
                          {
                        //  console.log(data[0].fullname);
                              $('#name').val(data[0].fullname);
                              $('#username').val(data[0].username);
                              $('#email').val(data[0].email);
                              $('#cmnd').val(data[0].cmnd);
                              $('#mobile').val(data[0].mobile);
                              $('#birthday').val(data[0].birthday);
                              $('#description').val(data[0].description);

                              if(data[0].sex == 1){
                                  $("#nam").prop("checked", true);
                              }else{  $("#nu").prop("checked", true);}
                              //Bo phan
                              $.each(data[1], function () {
                                  if(data[0].dept == this.id){
                                        $("#dept").append(
                                            '<option value="'+this.id+'" selected >'+this.name+'</option>'
                                          )
                                      }
                                  else {
                                          $("#dept").append(
                                            '<option value="'+this.id+'">'+this.name+'</option>'
                                          )
                                        }
                              });
                              //NV quản lý
                              $.each(data[2], function () {
                                  if(data[0].manager_assign == this.id){
                                        $("#manager_assign").append(
                                            '<option value="'+this.id+'" selected >'+this.fullname+'</option>'
                                          )
                                      }
                                  else {
                                          $("#manager_assign").append(
                                            '<option value="'+this.id+'">'+this.fullname+'</option>'
                                          )
                                        }
                              });
                              $('#group_customer').modal('show');
                              $('#action').val('Edit');
                              $('.modal-title').text('Sửa dữ liệu');
                              $('#button_action').val('update');
                          }
                      })
                  });
     	})
     	</script>

   	</body>
</html>
@endsection
