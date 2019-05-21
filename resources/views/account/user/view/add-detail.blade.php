@extends('master')
@section('content')
<html lang="en">
<head>
      <script src="{{ asset('public/js/jquery.min.js') }}"></script>
</head>
	<body>
		<section class="content">
		    <div class="row">
		    	<div class='notifications hidden-right'>
			        <span class="alert alert-success" role="alert" style="display:none"  >

			        </span>
			        @if ($errors->has('check'))
                        <span class="help-block">

                            <strong class="alert alert-danger" >{{ $errors->first('check') }}</strong>
                        </span>
                    @endif


		      	</div>
		      <div class="col-md-12">
		        <ol class="breadcrumb">
		         <!-- <li class="breadcrumb-item">Home</li> -->
		         <li class="breadcrumb-item"><a href="/template"><i class="fa far fa-arrow-circle-left"></i> Quản trị</a></li>
		         <li class="breadcrumb-item "><a href="{{ route('user') }}">Danh sách thành viên</a></li>
		         <li class="breadcrumb-item "><a href="{{ route('View_User',$user_id) }}">Chi tiết thành viên</a></li>
		         <li class="breadcrumb-item active" href="">Danh sách thành viên</li>
		       </ol>

				<form action="{{ route('Add_User_Manager') }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" id="user_id" name="user_id" value="{{ $user_id }}">
					<div class="content-header">
		             <div class="panel panel-flat">
		               <ol class="panel-header">
		                 <div >

		                   <button type="submit" class="btn btn-primary pull-right" style="margin-right : 20px"> <i class="fa fa-plus-circle fa-fw fa-lg"></i> Thêm </button>

							<h5 class="panel-title"> Danh sách thành viên</h5>
		                 </div>
		                </ol>
		             </div>
		          </div>


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
		                                  <th width="5%" height="15" align="center" ><input class="styled"  type="checkbox" id="check_all" name="check_all" onclick="checkall()"></th>
		                                  {{ csrf_field() }}

		                              </tr>
		                            </thead>


		                          </table>
		                        </div>
		                     </div>
		                    </div>
		                 </div>
		                 <!-- /.table-responsive -->
		             </div>

				</form>
		             <!-- /.panel-body -->



		             <!-- /.modal add -->


		             <!-- /.modal edit -->


		      </div>
		      <!-- /.col-lg-12 -->
		  </div>
		  <!-- /.row -->
		</section>
		<!-- /.content -->

       <script>
         function checkall(){

			$('.item_check').prop('checked',$('#check_all').prop('checked')).uniform('refresh');

		}

				function check_type(type) {
				  window.type = type;
				}
				  setTimeout(function() {
				         $(".alert").alert('close');
				     }, 10000);


         $(document).ready(function() {
     			$(function() {


	               $('#table').DataTable({

	               	processing: true,
	               	serverSide: true,
	               	ajax:
	               	({
	               	url: "{{ url('list_user_add_manager',$user_id) }}",
	               	}),

	               	columns: [
	                        { data: 'stt', name: 'stt' },
	                        { data: 'name', name: 'name' },
	                        { data: 'email', name: 'email' },
	                        { data: 'action', name: 'action',  orderable: false, searchable: false, className : 'text-center', },

	                     ],
                 	"iDisplayLength": 25,
            	  	order: [0, 'asc'],
                  	"language": {
                  	"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json"
	              				},

	            });
     		})
     		})
     	</script>

   	</body>
</html>
@endsection
