<?php $__env->startSection('content'); ?>
<html lang="en">
<head>
      <script src="<?php echo e(asset('public/js/jquery-3.2.1.js')); ?>"></script>
      <script src="<?php echo e(asset('public/maskmoney/jquery.maskMoney.js')); ?>"></script>
      <style>
      .title {
        border-style: solid;
        border-color: coral;
      }

      /* div {
        border-style: solid;
        border-color: coral;
      } */
      </style>
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
         <li class="breadcrumb-item active" href="<?php echo e(route('child')); ?>">Thống kê & In phiếu</li>
       </ol>
          <div class="content-header">
             <div class="panel panel-flat">
               <ol class="panel-heading">
                 <div >
                    <h2 class="panel-title">Thống kê chi tiết tiền học</h2>
                 </div>
                </ol>
                <!-- Lọc -->
                <div class="content-header">
                    <div class="panel panel-flat">
                       <div class="form-group row">
                          <label class="control-label col-sm-2 text-right ">Lọc theo lớp:</label>
                           <div class="col-sm-2">
                           <select class="select custom-select" id="name_class" data-width="100%"  data-placeholder="">
                             <option value="0">Tất cả </option>
                             <?php $__currentLoopData = $class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <option value="<?php echo e($group_item->id); ?>"><?php echo e($group_item->name); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                         </div>
                      </div>
                      </div>
                   </div>

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
                                   <th>Lớp học</th>
                                   <th>Phí chi tiết</th>
                                   <th>Học phí</th>
                                   <th>Ngày nghỉ</th>
                                   <th>Miễn giảm</th>
                                   <th>Còn lại</th>
                                   <th>In phiếu</th>
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
<!-- <div id="print_report" class="modal fade" role="dialog"  data-backdrop="false">
  MẪU GIÁO HOA HỒNG

</div> -->

<div  id="print_report" class="modal fade" data-backdrop="false">
  <fieldset style="margin-top:10px;margin-left:-7px;margin-right:-7px;">
    <div class="row" >

          <div style=" margin-top:15px;">
                <img src="<?php echo e(asset('public/img/logo.png')); ?>" class="img-thumbnail profile_ detail"
                width="150">
          </div>


    <div style="text-align:center;">
        <b><h2> MẪU GIÁO HOA HỒNG </h2></b>
    </div>
    <div style="text-align:center;">
      THÔNG BÁO THU TIỀN THÁNG <b> <?php echo date('m'); ?> / <?php echo date('Y'); ?></b>
    </div>
    <div style="margin-top:10px;">
      Kính gởi phụ huynh cháu: <b> <label id="name_child" name="name_child"/></b>
    </div>
    <div style="margin-top:5px;">
      Học lớp:  <b><label id="name_class_id" name="name_class_id"/></b>
    </div>
    <div style="margin-top:5px;" >
      Tiền học phí:  <b> <label id="price" name="price"/></b>
    </div>
    <div  style="margin-left:30px;margin-top:5px; ">
      <div id="fee"></div>
    </div>
    <div style="margin-top:5px;">
      Tiền nghỉ:  <b><label id="money_day_off" name="money_day_off"/></b>
    </div>
    <div style="margin-top:5px;">
      Tiền miễn giảm:  <b><label id="discount" name="discount"/></b>
    </div>
    <div style="margin-top:5px;">
      Tổng tiền: <b><label id="total_amount" name="total_amount"/></b>
    </div>
    <div style="text-align:right;">
      <i>Ngày <?php echo date('d'); ?>  tháng <?php echo date('m'); ?>  năm <?php echo date('Y'); ?></i>
    </div>
    <div style="text-align:right; margin:5px; margin-right:50px; margin-bottom:80px;">
      Chủ nhóm
    </div>
  </div>
</fieldset>
</div>
<!-- /.content -->


  <script type="text/javascript">

  $(document).ready(function() {
    $('.select').select2({
              allowClear: true,
            });
           $(function() {
            var t =  $('#table').DataTable({
                 processing: true,
                 serverSide: true,
                 ajax: {
                        url :   '<?php echo route('Print_ajax'); ?>',
                        data: function(d){
                            d.level =   $('#name_class').val()
                        }
                    },
                 columns: [
                  { data: 'STT', },
                  { data: 'name_child' },
                  { data: 'name_class', },
                  { data: 'fee_detail'},
                  { data: 'price', render: $.fn.dataTable.render.number( ',', '.', 0 )},
                  { data: 'day_off', render: $.fn.dataTable.render.number( ',', '.', 0 )},
                  { data: 'discount', render: $.fn.dataTable.render.number( ',', '.', 0 )},
                  { data: 'amount', render: $.fn.dataTable.render.number( ',', '.', 0 )},
                  { data: 'print'},
                  { data: 'status', visible:false},
                   ],

                    "iDisplayLength": 25,
                   order: [8, 'desc'],
                  "language": {
                    "url": "public/Vietnamese.json"
                },
              });


              t.on( 'order.dt search.dt', function () {
       t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
           cell.innerHTML = i+1;
       } );
   } ).draw();
             $('#name_class').change(function (e) {
                 t.draw();
             });
           });


           // Thu tiền
           $(document).on('click', '.done_money', function(){
                var table = $('#table').DataTable();
                var data = table.row( $(this).parents('tr') ).data();
                var child_id =data["id"];
                var name_child =data["name_child"];
                var name_class =data["name_class"];
                var fee_detail =data["fee_detail"];
                var price =data["price"];
                var day_off =data["day_off"];
                var discount =data["discount"];
                var amount =data["amount"];
                var divToPrint=document.getElementById('print_report');
                var newWin=window.open('','Print-Window');
                        $.ajax({
                                  url:"<?php echo e(route('Print_report_before')); ?>",
                                  method:"post",
                                  data:{
                                    child_id:child_id,
                                    name_child:name_child,
                                    name_class:name_class,
                                    fee_detail:fee_detail,
                                    price:price,
                                    day_off:day_off,
                                    discount:discount,
                                    amount:amount,
                                   _token: '<?php echo e(csrf_token()); ?>'
                                  },
                                  dataType:"json",
                                  success:function(data)
                                  {
                                    // console.log(data[0]);
          //var money_day_off = data[4] == 0 ? '' : data[4]+' ( '+ data[0][0].day_off +' ngày )';
                                     $('#name_child').html(data[2]);
                                     $('#name_class_id').html(data[3]);
                                     $('#price').html(data[4]);
                                     $('#discount').html(data[5]);
                                     $('#total_amount').html(data[6]);
                                     $("#fee").html(data[0]);
                                     $("#money_day_off").html(data[1]);

                                    newWin.document.open();
            newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
                                    newWin.document.close();
                                    setTimeout(function(){newWin.close();},10);
                                      table.draw();
                                  }
                              })

                  //      setTimeout(function(){newWin.close();},100);




           });
         })

         function openPrintDialogue(){
           var table = $('#table').DataTable();
           var data = table.row( $(this).parents('tr') ).data();
          // console.log(data);
         //  var child_id =data["child_id"];
           $('<iframe>', {
             name: 'myiframe',
             class: 'printFrame'
           })
           .appendTo('body')
           .contents().find('body')
           .append('');

           window.frames['myiframe'].focus();
           window.frames['myiframe'].print();

           setTimeout(() => { $(".printFrame").remove(); }, 1000);
         };

         </script>

   </body>
</html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>