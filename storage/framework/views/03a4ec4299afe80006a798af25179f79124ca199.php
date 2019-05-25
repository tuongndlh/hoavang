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
                    <div class="form-group row">
                      <div class="col-md-3">
                        <div class="col-md-4 text-right">
                          <label> Theo tháng: </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control input_date" name="input_date_month" id="input_date_month" placeholder="Theo tháng" />
                        </div>
                      </div>
                      </div>
                    <h2 class="panel-title">Khai báo danh mục báo cáo</h2>
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
                                   <th>STT</th>
                                   <th>Nội dung</th>
                                   <th>Số lượng</th>
                                   <th>Tháng</th>
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

               processing: true,
               serverSide: true,
               ajax: {
                        url : '<?php echo url('view_reportall_ajax'); ?>',
               data: function(d){
                          var input_date_month = $('#input_date_month').val();
                          d.input_date_month =    input_date_month;
                      },
                    },
               columns: [
                        { data: 'id', name: 'id' },
                        { data: 'name_content' },
                        { data: 'quantity'},
                        { data: 'month'},
                      //  { data: 'action', name: 'action', orderable: false, searchable: false, className : 'text-center', }
                     ],

                "iDisplayLength": 251,
                order: [0, 'asc'],
                "language": {
                  "url": "public/Vietnamese.json"
              },

            });
            $('#input_date_month').change(function (e) {
               table.draw();
           });

            $('#table tbody').on( 'keyup', '.quantity', function () {
                   var data = table.row( $(this).parents('tr') ).data();
                   var oTable = $('#table').DataTable();
                   var datatable = table
                               .rows()
                               .data();
                    for (var i=0; i < datatable.length ;i++){
                      if(i == data['id'] ){
                        $('#quantity'+i).maskMoney({thousands: ',', decimal: '.', precision: 0});
                        $('#quantity'+i).keypress(function(event){
                                // console.log(event.which);
                             if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
                                 event.preventDefault();
                             }});


                        var value =$('#quantity'+i).val();
                        var button_action = $("#button_action").val();
                         //console.log(i,value);
                                 $.ajax({
                                     url:"<?php echo e(route('add_reportall')); ?>",
                                     method:"POST",
                                     data:{
                                       id:i,
                                       value:value,
                                       button_action:button_action,
                                       _token: '<?php echo e(csrf_token()); ?>'
                                     },
                                     dataType:"JSON",
                                     success:function(data)
                                     {
                                        console.log(data);
                                     }
                                 })
                      }
                    }
               } );

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