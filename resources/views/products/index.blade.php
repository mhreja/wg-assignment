@extends('layouts.app')

@section('title','Products')

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

    .my-invalid-feedback {
        color: #e74a3b;
        font-size: 80%;
    }
</style>
@endsection


@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addProduct"
                onclick="resetForm()">
                <i class="fa fa-plus"></i> Add New Product
            </button>
            <div class="float-right">
                <form id="filterForm" method="POST">
                    @csrf
                    <label for="">Start Date: </label>
                    <input type="date" name="start_date">
                    <label for="">End Date: </label>
                    <input type="date" name="end_date">
                    <button type="submit">Filter</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Added By</th>
                            <th>Description</th>
                            <th>Added On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Added By</th>
                            <th>Description</th>
                            <th>Added On</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fixed-left fade" data-key="look" id="addProduct" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-aside" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="saveForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" class="form-control" name="product_name" placeholder="Product Name">
                            <span class="my-invalid-feedback" id="product_nameError"></span>
                        </div>
                        <div class="form-group">
                            <label>Product Description</label>
                            <textarea name="product_desc" class="form-control" cols="30" rows="10"></textarea>
                            <span class="my-invalid-feedback" id="product_descError"></span>
                        </div>
                        <div class="form-group">
                            <label>Select User</label>
                            <select name="user_id" class="form-control">
                                <option selected disabled>Select</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                            <span class="my-invalid-feedback" id="user_idError"></span>
                        </div>
                        <div class="form-group">
                            <label>Product Image</label>
                            <input type="file" class="form-control" name="image" accept=".jpg, .png, .jpeg">
                            <span class="my-invalid-feedback" id="imageError"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal"
                            id="addmodalClose">Close</button>
                        <button type="reset" class="btn btn-dark" id="addformreset">Reset</button>
                        <button type="submit" class="btn btn-success btnSave">Insert</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Edit Product Modal -->
    <div class="modal fixed-left fade" data-key="look" id="editProduct" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-aside" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" class="form-control" name="product_name" placeholder="Product Name">
                            <span class="my-invalid-feedback" id="product_nameError"></span>
                        </div>
                        <div class="form-group">
                            <label>Product Description</label>
                            <textarea name="product_desc" class="form-control" cols="30" rows="10"></textarea>
                            <span class="my-invalid-feedback" id="product_descError"></span>
                        </div>
                        <div class="form-group">
                            <label>Change Product Image</label>
                            <input type="file" class="form-control" name="image" accept=".jpg, .png, .jpeg">
                            <span class="my-invalid-feedback" id="imageError"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal"
                            id="editmodalClose">Close</button>
                        <button type="reset" class="btn btn-dark" id="editformreset">Reset</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection





@section('scripts')
<script>
    function getRecords(){
        $.ajax({
            type: "GET",
            url: "{{route('product.getproducts')}}",
            success: function (data) {
                $("#dataTable").DataTable().destroy();
                $('#dataTable').dataTable({
                    data: data,
                    columns: [
                        {render: function(data, type, row, meta){
                            return '<img class="img-thumbnail" width="75px" src="storage/products/'+row.product_image+'">';
                        }},
                        {data: 'product_name'},
                        {data: 'name'},
                        {data: 'product_desc'},
                        {render: function(data, type, row, meta) {
                            var date = new Date(row.created_at);
                            

                            if(date.getHours().toString().length > 1){
                                var hour = date.getHours();
                            } else {
                                var hour = '0' + date.getHours();
                            }
                            
                            if(date.getMinutes().toString().length > 1){
                                var min =  date.getMinutes();
                            } else {
                                var min =  '0' + date.getMinutes();
                            }

                            if(date.getSeconds().toString().length > 1){
                                var sec = date.getSeconds();
                            } else {
                                var sec = '0' + date.getSeconds();
                            }
                            
                            var time = hour +':'+ min +':'+ sec ;
                            //console.log(time);

                            var month = date.getMonth() + 1;
                            return (date.getDate().toString().length > 1 ? date.getDate() :
                                "0" + date.getDate()) + '-' + (month.toString().length >
                                1 ? month : "0" + month) + "-" + date.getFullYear() +' '+ time ;

                            }
                        },
                        {render : function (data, type, row, meta) {
                            return '<button class="btn btn-info btnEdit" data-id="'+ row.id +'" data-productname="'+row.product_name+'" data-desc="'+row.product_desc+'" data-toggle="modal" data-target="#editProduct" onclick="resetForm()"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btnDelete" data-id="'+ row.id +'"><i class="fa fa-trash"></i></button>';
                        }},
                        
                    ]
                })
            }
        });
    };
    //Load Table Data from Database
    getRecords()


    function resetForm() {
        $('#addformreset').click();
        $('#editformreset').click();
    }

        
    $('#saveForm').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: '{{route("product.store")}}',
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                $('#addmodalClose').click();
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
                if (response.responseJSON.hasOwnProperty('errors')) {
                    $.each(response.responseJSON.errors, function(key, value){
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
        });
    })


    //Editing
    $('#dataTable').on('click', '.btnEdit', function(){
        //Get Values and Id
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-productname');
        var desc = $(this).attr('data-desc');
            
            //Create URL for update and make it global variable
            window.updateURL = "{{route('product.update',':id')}}";
            updateURL = updateURL.replace(':id', id); 

        //Put the value in input fileds
        $('input[name="product_name"]').val(name);
        $('textarea[name="product_desc"]').text(desc);			
    })

    $('#editForm').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: updateURL,
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                $('#editmodalClose').click();
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
                if (response.responseJSON.hasOwnProperty('errors')) {
                    $.each(response.responseJSON.errors, function(key, value){
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
        });
    })

    //Deleting
    $('#dataTable').on('click', '.btnDelete', function(){
        if(!confirm('Are you sure that you really want to delete it?')) return;
        var id = $(this).attr('data-id');
        var deleteURL = "{{route('product.delete',':id')}}";
        deleteURL = deleteURL.replace(':id', id);

        $.ajax({
            method: "GET",
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



    //filtering
    $('#filterForm').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: '{{route("product.filterbydate")}}',
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
                $("#dataTable").DataTable().destroy();
                $('#dataTable').dataTable({
                    data: data,
                    columns: [
                        {render: function(data, type, row, meta){
                            return '<img class="img-thumbnail" width="75px" src="storage/products/'+row.product_image+'">';
                        }},
                        {data: 'product_name'},
                        {data: 'name'},
                        {data: 'product_desc'},
                        {render: function(data, type, row, meta) {
                            var date = new Date(row.created_at);
                            

                            if(date.getHours().toString().length > 1){
                                var hour = date.getHours();
                            } else {
                                var hour = '0' + date.getHours();
                            }
                            
                            if(date.getMinutes().toString().length > 1){
                                var min =  date.getMinutes();
                            } else {
                                var min =  '0' + date.getMinutes();
                            }

                            if(date.getSeconds().toString().length > 1){
                                var sec = date.getSeconds();
                            } else {
                                var sec = '0' + date.getSeconds();
                            }
                            
                            var time = hour +':'+ min +':'+ sec ;
                            //console.log(time);

                            var month = date.getMonth() + 1;
                            return (date.getDate().toString().length > 1 ? date.getDate() :
                                "0" + date.getDate()) + '-' + (month.toString().length >
                                1 ? month : "0" + month) + "-" + date.getFullYear() +' '+ time ;

                            }
                        },
                        {render : function (data, type, row, meta) {
                            return '<button class="btn btn-info btnEdit" data-id="'+ row.id +'" data-productname="'+row.product_name+'" data-desc="'+row.product_desc+'" data-toggle="modal" data-target="#editProduct" onclick="resetForm()"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btnDelete" data-id="'+ row.id +'"><i class="fa fa-trash"></i></button>';
                        }},
                        
                    ]
                })
            },
            error: function(response){
                if (response.responseJSON.hasOwnProperty('errors')) {
                    $.each(response.responseJSON.errors, function(key, value){
                        $.bootstrapGrowl(value , {
                        ele: "body", //On which Element to Append
                        type: "danger", //This is for color
                        offset: {from: "top", amount:20}, //Top or Bottom
                        align: "right",
                        width: 250, 
                        delay: 800,
                        allow_dismiss: true,
                    });
                    })
                    
                }
            }
        });
    })
</script>
@endsection