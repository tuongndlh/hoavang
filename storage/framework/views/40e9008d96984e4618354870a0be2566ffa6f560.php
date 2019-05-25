<?php $__env->startSection('content'); ?>
<html lang="en">
<head>
      <script src="<?php echo e(asset('public/js/jquery-3.2.1.js')); ?>"></script>
      <script src="<?php echo e(asset('public/maskmoney/jquery.maskMoney.js')); ?>"></script>
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
         <li class="breadcrumb-item active" href="<?php echo e(route('reportall')); ?>">Danh mục báo cáo</li>
       </ol>
          <div class="content-header">
             <div class="panel panel-flat">
               <ol class="panel-heading">
                 <div class="col-md-10">
                    <h2 class="panel-title">Khai báo danh mục báo cáo</h2>
                 </div>
                </ol>
                <div class="panel-body">
                    <div class="table-responsive">
                      <div class="container-fluid">
                         <div class="animate fadeIn">
                            <div class="panel-body">
                             <a href="<?php echo e(url('downloadExcel/xlsx')); ?>"><button class="btn btn-success">Download Excel</button></a>
                             <table width="100%" class="display nowrap" style="width:100%" cellspacing="0" id="table">
                               <thead>
                                 <tr>
                                    <th>STT</th>
                                    <th>Nội dung</th>
                                    <th>Hòa Bắc</th>
                                    <th>Hòa Ninh</th>
                                    <th>Hòa Liên</th>
                                    <th>Hòa Sơn</th>
                                    <th>Hòa Châu</th>
                                    <th>Hòa Tiến</th>
                                    <th>Hòa Phước</th>
                                    <th>Hòa Phong</th>
                                    <th>Hòa Khương</th>
                                    <th>Hòa Nhơn</th>
                                    <th>Hòa Phú</th>
                                   <th>Cập nhật</th>
                                   <!-- <th>Tác vụ</th> -->
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

<script type="text/javascript">

function check_type(type) {
  window.type = type;
}
  setTimeout(function() {
         $(".alert").alert('close');
     }, 10000);

</script>
  <script type="text/javascript">
      $('#quantity').maskMoney({thousands: ',', decimal: '.', precision: 0});

      $("#quantity_input").keypress(function(event){
              // console.log(event.which);
           if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
               event.preventDefault();
       }});


       $(document).ready(function() {
         var today = new Date();
         var month1 = today.getMonth()+1;
         var month = ("0" + month1).slice(-2);
         var year  = today.getFullYear();
         var value = month + '-'+ year;
      //   console.log(month+'-'+ year);

        $("#input_date_month").val(value);

         $('#input_date_month').datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months",
            autoclose:true,
        });
         $('.select').select2({
                    allowClear: true,
                    //minimumResultsForSearch: Infinity,
                  });
         $(function() {
          var table =     $('#table').DataTable({
               scrollY:        "600px",
               scrollX:        true,
               scrollCollapse: true,
               paging:         false,
               columnDefs: [
                   { width: 100, targets: 1 }
               ],
               fixedColumns: true,
               processing: true,
               serverSide: true,
               ajax: {
                       url : '<?php echo url('view_adminreportall_ajax'); ?>',
                   },
               columns: [
                        { data: 'id', name: 'id' },
                        { data: 'name_content' },
                        { data: 'HoaBac',render: $.fn.dataTable.render.number( ',', '.', 0 ) },
                        { data: 'HoaNinh',render: $.fn.dataTable.render.number( ',', '.', 0 ) },
                        { data: 'Hoalien',render: $.fn.dataTable.render.number( ',', '.', 0 ) },
                        { data: 'Hoason',render: $.fn.dataTable.render.number( ',', '.', 0 ) },
                        { data: 'Hoachau',render: $.fn.dataTable.render.number( ',', '.', 0 ) },
                        { data: 'Hoatien',render: $.fn.dataTable.render.number( ',', '.', 0 ) },
                        { data: 'Hoaphuoc',render: $.fn.dataTable.render.number( ',', '.', 0 ) },
                        { data: 'Hoaphong',render: $.fn.dataTable.render.number( ',', '.', 0 ) },
                        { data: 'Hoakhuong',render: $.fn.dataTable.render.number( ',', '.', 0 ) },
                        { data: 'Hoanhon',render: $.fn.dataTable.render.number( ',', '.', 0 ) },
                        { data: 'Hoaphu',render: $.fn.dataTable.render.number( ',', '.', 0 ) },                        

                        { data: 'update_date'},
                      //  { data: 'action', name: 'action', orderable: false, searchable: false, className : 'text-center', }
                     ],

                "iDisplayLength": 251,
                order: [0, 'asc'],
                "language": {
                  "url": "public/Vietnamese.json"
              },


            });




          })


         $('#add_data').click(function(){
                $('#group_customer').modal('show');
                $('#group_customer_form')[0].reset();
                $('#form_output').html('');
                $('#button_action').val('insert');
                $('.modal-title').text('Thêm mới');

            });

       })

         </script>

   </body>
</html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>