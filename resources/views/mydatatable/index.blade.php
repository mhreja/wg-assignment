@extends('layouts.app')

@section('title','My DataTable')

@section('head')
<style>
	.modal .modal-dialog-aside {
		width: 40%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}

	.modal .modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.modal .modal-dialog-aside .modal-content .modal-body {
		overflow-y: auto
	}

	.modal.fixed-left .modal-dialog-aside {
		margin-left: auto;
		transform: translateX(100%);
	}

	.modal.fixed-right .modal-dialog-aside {
		margin-right: auto;
		transform: translateX(-100%);
	}

	.modal.show .modal-dialog-aside {
		transform: translateX(0);
	}

	@media only screen and (max-width: 1024px) {
		.modal .modal-dialog-aside {
			width: 80%;
		}
	}
</style>
@endsection


@section('content')

<div class="container-fluid">
	<div class="card shadow mb-4">
		<div class="card-header text-right">
			<input type="date" name="fromdate" id="fromdate">
			<input type="date" name="todate" id="todate">
			<button type="button" id="filterBtn">Filter</button>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="newdataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Active Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Active Status</th>
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fixed-left fade" data-key="look" id="exampleModalLong" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-aside" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- Body -->
				</div>
				<div class="modal-footer">
					<!--footer -->
				</div>
			</div>
		</div>
	</div>
</div>

@endsection





@section('scripts')
<script>
	$(document).ready(function(){
        var dataTable = $('#newdataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{route('user.newgetusers')}}",
                     "dataType": "json",
                     "type": "GET",
                     "data": { 
                     	// _token: "{{csrf_token()}}",
                     	fromdate: $('#fromdate').val(),
                        todate: $('#todate').val(),
                     }
                     },
                   
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "email" },
                { "data": "created_at", "orderable": false, },
                { "data": "options", "orderable": false, }
            ]
        });

	    // $('#filterBtn').on('click',function(){
	    //     // $('#filter').val("filter");
	    //     dataTable.fnDraw();
	    // });

	    $("#filterBtn").click(function () {
            dataTable.draw();
        });
	});	        
</script>
@endsection