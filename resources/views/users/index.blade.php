@extends('layouts.app')

@section('title','Users')

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
		<div class="card-header py-3">
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalLong"
				onclick="addUser()">
				<i class="fa fa-plus"></i> Add New User
			</button>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Active Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
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
					<form id="saveForm">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="name" placeholder="John Doe">
							<span class="invalid-feedback" role="alert" id="nameError"></span>
						</div>
						<div class="form-group">
							<label>Email ID</label>
							<input type="email" class="form-control" name="email" placeholder="john@doe.com">
							<span class="invalid-feedback" role="alert" id="emailError"></span>
						</div>
						<div class="form-group">
							<label>Active Status</label>
							<select name="is_active" class="form-control">
								<option selected disabled>Select</option>
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
							<span class="invalid-feedback" style="color: #e74a3b; font-size: 80%;" role="alert"
								id="is_activeError"></span>
						</div>
						<div class="form-group">
							<label>Activation Token</label>
							<input type="text" class="form-control" name="activation_token" placeholder="XYZ001">
							<span class="invalid-feedback" role="alert" id="activation_tokenError"></span>
						</div>
						<div class="form-group" id="pass">
							<label>Password</label>
							<input type="password" class="form-control" name="pass" placeholder="Create Your Password">
							<span class="invalid-feedback" role="alert" id="passError"></span>
						</div>
					</form>
					<form id="updateForm">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="name" placeholder="John Doe">
							<span class="invalid-feedback" role="alert" id="nameError"></span>
						</div>
						<div class="form-group">
							<label>Email ID</label>
							<input type="email" class="form-control" name="email" placeholder="john@doe.com">
							<span class="invalid-feedback" role="alert" id="emailError"></span>
						</div>
						<div class="form-group">
							<label>Active Status</label>
							<select name="is_active" class="form-control">
								<option selected disabled>Select</option>
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
							<span class="invalid-feedback" style="color: #e74a3b; font-size: 80%;" role="alert"
								id="is_activeError"></span>
						</div>
						<div class="form-group">
							<label>New Password</label>
							<input type="password" class="form-control" name="newpassword" placeholder="New Password">
							<span class="invalid-feedback" role="alert" id="newpasswordError"></span>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-dark" data-dismiss="modal"
						id="modalClose">Close</button>
					<button type="button" class="btn btn-dark" onclick="formReset()">Reset</button>
					<button type="button" class="btn btn-success btnSave" onclick="store()"><i></i>Insert</button>
					<button type="button" class="btn btn-info btnUpdate" onclick="update()">Update</button>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection





@section('scripts')
<script>
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    	function getRecords(){
	    	$.ajax({
			    type: "GET",
			    url: "{{route('user.getusers')}}",
			    success: function (data) {
                    $("#dataTable").DataTable().destroy();
			        $('#dataTable').dataTable({
			        	data: data,
			        	columns: [
                            {data: 'name'},
                            {data: 'email'},
                            {data: 'is_active' , render : function (data) {
                                if(data == 1){
                                    var span = '<span class="badge badge-pill badge-success">Active</span>';
                                } else var span = '<span class="badge badge-pill badge-danger">Inactive</span>';
                                return span;
                            }},
                            {render : function (data, type, row, meta) {
                                return '<button class="btn btn-info btnEdit" data-id="'+ row.id +'" data-name="'+row.name+'" data-email="'+row.email+'" data-toggle="modal" data-target="#exampleModalLong"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btnDelete" data-id="'+ row.id +'"><i class="fa fa-trash"></i></button>';
                            }},
                            
			        	]
			        })
			    }
			});
    	};
    	//Load Table Data from Database
    	getRecords()


    	function formReset() {
		  $("#saveForm input").each(function(){
		  	$(this).val(null)
		  })
		  $("#updateForm input").each(function(){
		  	$(this).val(null)
		  })
		}

		function addUser(){
			formReset();
			$('input').removeClass('is-invalid'); //Removes previous error class
			$('.modal-title').text('Add New User');
			$('.btnSave').show();
			$('.btnUpdate').hide();
			$('#saveForm').show();
			$('#updateForm').hide();
		}

		function store(){
			$(".btnSave").prop('disabled', true); //Disable button to resist more than 1 time submitting same data
			$(".btnSave").html('<i class="fas fa-spinner fa-spin"></i> Inserting');
			$.ajax({
				type: "POST",
				url: "{{ route('user.store') }}",
				data: $("#saveForm").serialize(),
				success: function(data){
					$('input').removeClass('is-invalid');
					formReset();
					$(".btnSave").prop('disabled', false); //remove disable tag after successfully inserting data
					$(".btnSave").html('Insert');
					$('#modalClose').click();
					getRecords();
					$.bootstrapGrowl(data.message , {
						ele: "body", //On which Element to Append
						type: "success", //This is for color
						offset: {from: "top", amount:20}, //Top or Bottom
						align: "right",
						width: 250, 
						delay: 800,
						allow_dismiss: true,
					});
				},
				error: function(response){
					console.log(response);
					$('input').removeClass('is-invalid');
					if (response.responseJSON.hasOwnProperty('errors')) {
						$(".btnSave").prop('disabled', false); //remove disable tag if has error
						$(".btnSave").html('Insert');
						$.each(response.responseJSON.errors, function(key, value){
							//console.log(key+value)
							$('input[name="'+key+'"]').addClass('is-invalid');
							$('#'+key+'Error').html('<strong>'+value+'</strong>');
						})
						$.bootstrapGrowl("Error !" , {
							ele: "body", //On which Element to Append
							type: "danger", //This is for color
							offset: {from: "top", amount:20}, //Top or Bottom
							align: "right",
							width: 250, 
							delay: 800,
							allow_dismiss: true,
						});
					}
				}
			})
		}

		$('#dataTable').on('click', '.btnEdit', function(){
			$('input').removeClass('is-invalid'); //Removes previous error class
			$('#updateForm select[name="is_active"] option:first').prop('selected',true); //Remove previous user status option
			$('#updateForm input[name="newpassword"]').val(null);  //Remove previous password filed inputs
			$('.modal-title').text('Edit User Details');
			$('.btnSave').hide();
			$('.btnUpdate').show();
			$('#updateForm').show();
			$('#saveForm').hide();

			//Get Values and Id
			var id = $(this).attr('data-id');
			var name = $(this).attr('data-name');
			var email = $(this).attr('data-email');
			  
			    //Create URL for update and make it global variable
				window.updateURL = "{{route('user.update',':id')}}";
			    updateURL = updateURL.replace(':id', id); 

			//Put the value in input fileds
			$('input[name="name"]').val(name);
			$('input[name="email"]').val(email);			
		})


		function update(){
			$.ajax({
				type: "PUT",
				url: window.updateURL,
				data: $("#updateForm").serialize(),
				success: function(data){
					$('input').removeClass('is-invalid');
					$('#modalClose').click();
					getRecords();
					$.bootstrapGrowl(data.message , {
						ele: "body", //On which Element to Append
						type: "success", //This is for color
						offset: {from: "top", amount:20}, //Top or Bottom
						align: "right",
						width: 250, 
						delay: 800,
						allow_dismiss: true,
					});
				},
				error: function(response){
					$('input').removeClass('is-invalid');
					if (response.responseJSON.hasOwnProperty('errors')) {
						$.each(response.responseJSON.errors, function(key, value){
							//console.log(key+value)
							$('#updateForm input[name="'+key+'"]').addClass('is-invalid');
							$('#updateForm #'+key+'Error').html('<strong>'+value+'</strong>');
						})
						$.bootstrapGrowl("Error !" , {
							ele: "body", //On which Element to Append
							type: "danger", //This is for color
							offset: {from: "top", amount:20}, //Top or Bottom
							align: "right",
							width: 250, 
							delay: 800,
							allow_dismiss: true,
						});
					}
				}
			})
		}

		$('#dataTable').on('click', '.btnDelete', function(){
			if(!confirm('Are you sure that you really want to delete it?')) return;
			//Get the Id
			var id = $(this).attr('data-id');
			// Craete Delete URL 
			var deleteURL = "{{route('user.delete',':id')}}";
			deleteURL = deleteURL.replace(':id', id);

			    $.ajax({
					type: "DELETE",
					url: deleteURL,
					success: function(data){
						getRecords();
						$.bootstrapGrowl(data.message , {
							ele: "body", //On which Element to Append
							type: "info", //This is for color
							offset: {from: "top", amount:20}, //Top or Bottom
							align: "right",
							width: 250, 
							delay: 800,
							allow_dismiss: true,
						});
					}
				})        
		});
</script>


@endsection