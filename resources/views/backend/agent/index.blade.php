@extends('layouts.app')

@section('css')
   <link href="/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
   <!-- Datatables -->
   <link href="/libs/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/gentelella/css/custom.min.css" rel="stylesheet">
@endsection

@section('content')
<!-- page content -->
   <div class="right_col" role="main">
      <div class="">
         <div class="page-title">
              <div class="title_left">
                
              </div>
         </div>
         <div class="row">
            
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                  <div class="x_title">
                  <label class="col-md-2 control-label">Date Range</label>
                        <div class="col-md-8">
                           <div class="input-group input-daterange">
                              <input type="text" class="form-control" name="start" id="start" placeholder="Date Start" />
                              <span class="input-group-addon">to</span>
                              <input type="text" class="form-control" name="end" id="end" placeholder="Date End" />
                           </div>
                        </div>
                        <button id="submit" class="col-md-1 btn btn-success">Submit</button>
                    <div class="clearfix"></div>
                  </div>


<!-- <div id="loading" style="background-color:#e6f9ff;"> Loading </div> -->
                 <a href="/transaction/export_excel" id="export_excel" class="btn btn-info" role="button">Export Excel</a>  
                
                  <!-- <div id='loading' style="background-color:#e6f9ff;"> Loading </div> -->
                  <div class="x_content">                     
                      
                          <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="transaction-table">
                            <thead>
                                <tr>
                                     <th style="width:20%">TransactionDate</th> 
                                     <th>Description</th> 
                                     <th>Mobile Number</th> 
                                     <th style="width:20%">Pre Balance</th>
                                     <th>Post Balance</th>
                                     <!-- <th>Amount</th> -->
                                     <th>Commission</th>
                                     <!-- <th>Status</th> -->
                                 </tr>
                            </thead>
                          </table>
                     
                     <!-- /.table-responsive -->
                  </div>
                </div>
            </div>

         </div>
      </div>  
   </div>
   <!-- /page content -->
@endsection

@section('js')
<script src="/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!-- Datatables -->
    <script src="/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/libs/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/libs/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/libs/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/libs/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="/libs/datatables.net-scroller/js/datatables.scroller.min.js"></script>

<script>
$(document).ready(function(){
    $('#start').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,
            setDate: today,
        });
        $('#end').datepicker({
            format: 'yyyy-mm-dd',
            setDate: today,
            autoclose: true
        });

        var date = new Date();
        var today = date.getFullYear() + "-" + (date.getMonth()+1) +"-"+ date.getDate();

        $('#start').val(today);
        $('#end').val(today);
      })
$(function() {
  $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });

  
 var table = $('#transaction-table').DataTable({
        dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
            "<'row'<'col-xs-12't>>"+
            "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: {
            url: '/transaction',
            error: function(xhr, error){
                if (xhr.status === 401) {
                   window.location.href = '/login';
                }
            },
            data: function (d) {
                  d.start_date = $('#start').val();
                  d.end_date = $('#end').val();
                  // d.search_result = $('.dataTables_filter input').val();
            },
        },
       columns: [
            {data: 'transaction_date', name: 'transaction_date'},
            {data: 'description', name: 'description'},
            {data: 'mobile_no', name: 'mobile_no'},
            {data: 'pre_balance', name: 'pre_balance'},
            {data: 'post_balance', name: 'post_balance'},
            {data: 'commission', name: 'commission'},
           
        ]
         
    });
   $('#submit').on('click', function() {
        table.draw();
    });
     $('#export_excel').on('click',function(){
        var start = $('#start').val();
        var end = $('#end').val();
       
        $(this).attr('href','/transaction/export_excel?start='+ start +'&end='+ end  + '');
       
    });
  
});
</script>
@endsection