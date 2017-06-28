@extends('layouts.app')

@section('css')
	 <link href="/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
   <!-- Datatables -->
   <link href="/libs/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> All Transactions </span>
              <div id="all_transcount" class="count"></div>
              <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-check" aria-hidden="true"></i> Success Transactions</span>
              <div id="success_trans" class="count blue"></div>
              <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span> -->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-exclamation-triangle"></i> Pending Transactions</span>
              <div id="pending_trans" class="count green"></div>
              <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-ban"></i> Failed Transactions </span>
              <div id="fail_trans" class="count red"></div>
              <!-- <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span> -->
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>  Transaction Monitoring </h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="transaction-table">
                             <thead>
                                 <tr>
                                     <th>Transaction Date</th> 
                                     <th>Transaction ID</th> 
                                     <th>Agent Card No</th> 
                                     <th>Status</th> 
                                     <th>Transaction Detail</th> 
                                 </tr>
                             </thead>
                    </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- /top tiles -->
          <br />
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

$(function() {
   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     var table = $('#transaction-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/transaction',
        columns: [
          


            {data: 'Date', name: 'transactionlog.transactionlog_datetime'},
            {data: 'TransactionID', name: 'transactionlog.transactionlog_id'},
            {data: 'AgentCardNo', name: 'agentcard.factory_cardno'},
            {data: 'Status', name: 'transactionlog.transaction_status'},
            {data: 'Details', name: 'transactionlog.activities_ref'}

        ]
    });

});
</script>
<script>
  $(document).ready(function(){

    window.setInterval(function(){
      getUser();
    }, 3000);
    
  })

  function getUser(){
    $.ajax({
      url: '/dashboard_trans',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        $('#all_transcount').text(data.all_transcount);
        $('#success_trans').text(data.success_trans);
        $('#pending_trans').text(data.pending_trans);
        $('#fail_trans').text(data.fail_trans);
      }
    })
  }
</script>
@endsection


