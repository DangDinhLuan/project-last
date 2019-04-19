@extends('layouts.app2')

@section('page-title')
    <li><a href="{{route('admin.index')}}">{{ __('message.title.dashboard') }}</a></li>
    <li class="active">{{ __('message.category') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">{{ __('message.category') }}</strong>
                <div class="float-right">
                    <a href="#" class="btn btn-outline-info" id="create-category"
                       title="show" data-toggle="modal" data-target="#modal-category">
                        {{ __('message.create') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="admin_category_list">
                    <thead>
                    <tr>
                        <th>{{ __('message.id') }}</th>
                        <th>{{ __('message.category') }}</th>
                        <th>{{ __('message.number_product') }}</th>
                        <th>{{ __('message.action') }}</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modal-category" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['id' => 'form-category']) !!}
                <div class="modal-header">
                    <h5>{{ __('message.category') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="form-group-id">
                        {!! Form::label('id', __('message.id'), ['class' => 'form-control-label']) !!}
                        {!! Form::text('id', null, ['class' => 'form-control', 'id' => 'id', 'readonly']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('name', __('message.name'), ['class' => 'form-control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'autocomplete' => 'off']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::submit(__('message.create'), ['class' => 'btn btn-info', 'id' => 'action']) !!}
                    {!! Form::button('Close', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var category_table = $('#admin_category_list').DataTable({
                processing: true,
                serverSide: true,
                order: ['0', 'desc'],
                ajax: {
                    url: route('admin.category.json'),
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'products_count', name: 'products_count'},
                    {
                        data: null,
                        name: null,
                        defaultContent: [
                            '<button class="btn btn-outline-primary" title="Update" data-toggle="modal" data-target="#modal-category" id="btnUpdateCategory"><i class="fa fa-edit"></i></button> ' +
                            '<button class="btn btn-outline-danger" title="Delete" id="btnDeleteCategory"><i class="fa fa-trash-o"></i></button> '
                        ],
                    },
                ],
            });

            $('#create-category').click(function () {

                $('#form-category')[0].reset();

                $('#form-group-id').hide();

                $('#action').val('Create');
            });

            $('#admin_category_list tbody').on('click', '#btnUpdateCategory', function () {

                $('#form-group-id').show();

                $('#category_id').prop('readonly', true);

                var row = $(this).closest('tr');

                var id = row.find('td:eq(0)').text();

                var name = row.find('td:eq(1)').text();

                $('#id').val(id);

                $('#name').val(name);

                $('#action').val('Update');
            });

            $('#action').click(function (event) {

                event.preventDefault();

                var id = $('#id').val();

                var url = route('admin.category.store');

                if (id != '') {
                    url = route('admin.category.update', id);
                }

                $.ajax({
                    type: 'post',
                    url: url,
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: new FormData($('form#form-category')[0]),
                    success: function (res) {
                        category_table.ajax.reload(null, false);
                        $('#modal-category').modal('hide');
                        swal({
                            title: "Success",
                            icon: "success",
                            timer: 2000,
                        });
                    },
                    error: function (xhr, status, error) {
                        var err = JSON.parse(xhr.responseText);
                        if (xhr.status == 403) {
                            toastr.error(err, 'Error!');
                        }
                        else { 
                            var errors = Object.entries(err.errors);
                            errors.forEach(function (value, index) {
                                toastr.error(value[1][0], 'Error!');
                            });
                        }
                    },
                });
            });

            $('#admin_category_list tbody').on('click', '#btnDeleteCategory', function () {
                var row = $(this).closest('tr');
                var id = row.find('td:eq(0)').text();
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'get',
                            url: route('admin.category.destroy', {id: id}),
                            success: function (res) {
                                category_table.ajax.reload(null, false);
                                swal({
                                    title: "Success",
                                    icon: "success",
                                    timer: 2000,
                                });
                            },
                            error: function (xhr, status, error) {
                                var err = JSON.parse(xhr.responseText);
                                if (xhr.status == 403) {
                                    toastr.error(err, 'Error!');
                                }
                                else { 
                                    var errors = Object.entries(err.errors);
                                    errors.forEach(function (value, index) {
                                        toastr.error(value[1][0], 'Error!');
                                    });
                                }
                            },
                        });
                    }
                })
            });
        });
    </script>
@endsection
