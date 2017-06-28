@extends('admin.layout.app')

@section('css')
	{{-- <link rel="stylesheet" type="text/css" href="app.css"> --}}
	<!-- Bootstrap Datepicker -->
    <link href="/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
@endsection

@section('content')
	@if (session('message'))
	    <div class="alert alert-success">
	        {{ session('message') }}
	    </div>
	@endif
	<h2>"List All Post"</h2>
	<div class="row">
	    <div class="col-md-12 form-horizontal">
	        <div class="form-group">
	            <label class="col-md-2 control-label">Date Range</label>
	            <div class="col-md-8">
	                <div class="input-group input-daterange">
	                    <input type="text" class="form-control" name="start" id="start" placeholder="Date Start" />
	                    <span class="input-group-addon">to</span>
	                    <input type="text" class="form-control" name="end" id="end" placeholder="Date End" />
	                </div>
	            </div>
	        </div>
	    </div>    
	</div>

	<table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Body</th>
                <th>CreatedDate</th>
                <th>UpdatedDate</th>
            </tr>
        </thead>
    </table>

@endsection

@section('script')

<!-- Bootstrap Datepicker -->
<script src="/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


<script>
$(document).ready(function(){
    $('#start').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true
    });
    $('#end').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true
    });
})

$(function() {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var oTable = $('#users-table').DataTable({
        dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
            "<'row'<'col-xs-12't>>"+
            "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/post',
            data: function (d) {
                d.name = $('input[name=name]').val();
                d.email = $('input[name=email]').val();
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'body', name: 'body'},
            {data: 'start', name: 'start'},
            {data: 'end', name: 'end'}
        ]
    });

    $('#start').on('change', function() {
        oTable.draw();
    });
});
</script>
@endsection