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
		         <li class="breadcrumb-item"><a href="/template"><i class="fa far fa-arrow-circle-left"></i> Quản trị</a></li>
		         <li class="breadcrumb-item"><a href="{{ route('user') }}"> Danh sách thành viên</a></li>
		         <li class="breadcrumb-item active" href="">Khởi tạo thành viên</li>
		       </ol>


				<form method="POST" id="user_add_" action="{{ route('user.store') }}" >
					<input type="hidden" name="_token" value="{!! csrf_token() !!}">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h5 class="panel-title">Chi tiết</h4>
								<div class="heading-elements">
									<ul class="icons-list">

				                	</ul>
			                	</div>
							</div>

							<div class="panel-heading" >
								<div class="form-group row">
									<label class="col-lg-2 control-label">Tên thành viên <span class="text-danger">*</span></label>
									<div class="col-lg-4 float-right">
										<input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname') }}" required="required" placeholder="Nhập tên thành viên">
									</div>
								</div>
								<div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
									<label class="col-lg-2 control-label">Email đăng nhập <span class="text-danger">*</span></label>
									<div class="col-lg-4 float-right">
										<input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" required="required" placeholder="Nhập email ">
										@if ($errors->has('email'))
		                                    <span class="help-block">

		                                        <strong class="alert alert-danger">{{ $errors->first('email') }}</strong>
		                                    </span>
		                                @endif
									</div>
								</div>

								<div class="form-group row {{ $errors->has('username') ? ' has-error' : '' }}">
									<label class="col-lg-2 control-label">Tên đăng nhập <span class="text-danger">*</span></label>
									<div class="col-lg-4 ">
										<input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required="required" placeholder="Nhập user name ">
										@if ($errors->has('username'))
		                                    <span class="help-block">

		                                        <strong class="alert alert-danger">{{ $errors->first('username') }}</strong>
		                                    </span>
		                                @endif
									</div>
								</div>

								<div class="form-group row {{ $errors->has('department_id') ? ' has-error' : '' }}">
									<label class="col-lg-2 control-label">Nhóm thành viên :</label>
									<div class="col-lg-4">

										<select class=" select form-control" name="department_id" id="department_id">

											<option disabled selected> -- Chọn nhóm thành viên --</option>
											@foreach ($department as $item_depart)
											@if ($item_depart["id"] == old('department_id'))
													<option value="{{ $item_depart["id"]}}" selected=selected >{{ $item_depart["name"]}}</option>
												@else
													<option value="{{ $item_depart["id"]}}">{{ $item_depart["name"]}}</option>
												@endif


											@endforeach
										</select>
										@if ($errors->has('department_id'))
	                                    <span class="help-block">

	                                        <strong class="alert alert-danger">{{ $errors->first('department_id') }}</strong>
	                                    </span>
	                                @endif

									</div>

								</div>
								<div class="form-group row">
									<label class="col-lg-2 control-label">Chức vụ :</label>
									<div class="col-lg-4 float-right">
										<input type="text" class="form-control" name="position" id="position" value="{{ old('position') }}">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-lg-2 control-label">Điện thoại :</label>
									<div class="col-lg-4 float-right">
										<input type="tel" class="form-control" name="tel" id="tel" value="{{ old('tel') }}">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 control-label">Di động :</label>
									<div class="col-lg-4 float-right">
										<input type="tel" class="form-control" name="mobile" id="mobile" value="{{ old('mobile') }}">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 control-label">Ghi chú :</label>
									<div class="col-lg-4 float-right">
										<textarea rows="5" cols="45" class="form-control" id="comment" name="comment" >{{ old('comment') }}</textarea>
									</div>
								</div>


								<div class="text-right">

		          					<button type="submit" name="submit" class="btn btn-primary action">Lưu dữ liệu</button>
								</div>

							</div>
						</div>




						<div class="panel panel-flat">
							<div class="panel-heading">
								<h5 class="panel-title">Mật khẩu</h4>
							</div>

							<div class="panel-heading">
								<div class="form-group row {{ $errors->has('password') ? ' has-error' : '' }}">
									<label class="col-lg-2 control-label">Mật khẩu :</label>
									<div class="col-lg-4 ">
										<input type="password" minlength="6" class="form-control" required="required" id="password" name="password" value="abc123">
									@if ($errors->has('password'))
	                                    <span class="help-block">

	                                        <strong class="alert alert-danger">{{ $errors->first('password') }}</strong>
	                                    </span>
	                                @endif

									</div>
								</div>
								<div class="text-right">

		          					<button type="submit" name="submit" class="btn btn-primary action">Lưu dữ liệu</button>
								</div>

							</div>

						</div>


						<div class="panel panel-flat">
							<div class="panel-heading">
								<h5 class="panel-title">Phân quyền</h4>
							</div>

							<div class="panel-heading">
								<div class="form-group row">
									<label class="col-lg-2 control-label"></label>
									<div class="col-lg-4 radio ">
										<input type="radio" class="permission form-check-input" name="permission"  value="0" checked>Thành viên

									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 control-label"></label>
									<div class="col-lg-4 radio ">
										<input type="radio" class="permission form-check-input" name="permission"  value="4" >Quản trị

									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 control-label"></label>
									<div class="col-lg-4 radio ">
										<input type="radio" class="form-check-input permission" name="permission"  value="5" >Quản trị cao cấp

									</div>
								</div>
								<div class="text-right">
									<input type="hidden" name="button_action" id="button_action" value="insert" />
		          					<button type="submit"  name="submit" class="btn btn-primary action">Lưu dữ liệu</button>

								</div>

							</div>

						</div>

					</form>







					<!-- Footer -->

		        <!-- </div> -->



			<script type="text/javascript">
				$(document).ready(function() {
				    $('.select').select2({
				    });
				});
			</script>
			<script type="text/javascript">
				function check_type(type) {
				  window.type = type;
				}
				  setTimeout(function() {
				         $(".alert").alert('close');
				     }, 10000);

			</script>



		</section>
		<!-- /.content -->


   	</body>
</html>
@endsection
