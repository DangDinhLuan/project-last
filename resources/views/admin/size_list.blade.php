@extends('layouts.app2')

@section('page-title')
    <li><a href="{{route('admin.index')}}">{{ __('message.title.dashboard') }}</a></li>
    <li class="active">{{ __('message.size') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">{{ __('message.category') }}</strong>
                <div class="float-right">
                    <a href="#" class="btn btn-outline-info" id="create-size"
                       title="show" data-toggle="modal" data-target="#modal-size">{{ __('message.create') }}</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="admin_size_list">
                    <thead>
                    <tr>
                        <th>{{ __('message.id') }}</th>
                        <th>{{ __('message.size') }}</th>
                        <th>{{ __('message.percent') }}</th>
                        <th>{{ __('message.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modal-size" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['id' => 'form-size']) !!}
                <div class="modal-header">
                    <h5>{{ __('message.size') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="form-group-id">
                        {!! Form::label('id', __('message.id'), ['class' => 'form-control-label']) !!}
                        {!! Form::text('id', null, ['class' => 'form-control', 'id' => 'id', 'readonly']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('size', __('message.size'), ['class' => 'form-control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'size', 'autocomplete' => 'off']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('percent', __('message.percent'), ['class' => 'form-control-label']) !!}
                        {!! Form::number('percent', null, ['class' => 'form-control', 'id' => 'percent', 'autocomplete' => 'off']) !!}
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
            var size_table = $('#admin_size_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: route('admin.size.json'),
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'percent',
                        name: 'percent',
                    },
                    {
                        data: null,
                        name: null,
                        defaultContent: [
                            '<button class="btn btn-outline-primary" title="Update" data-toggle="modal" data-target="#modal-size" id="btnUpdateSize"><i class="fa fa-edit"></i></button> ' +
                            '<button class="btn btn-outline-danger" title="Delete" id="btnDeleteSize"><i class="fa fa-trash"></i></button> '
                        ],
                    },
                ],
            });

            $('#create-size').click(function (event) {
                event.preventDefault();
                $('#form-group-id').hide();
                $('#form-size')[0].reset();
                $('#action').val('Create');
            });

            $('#admin_size_list tbody').on('click', '#btnUpdateSize', function (event) {
                event.preventDefault();
                var row = $(this).closest('tr');
                $('#form-group-id').show();
                $('#id').val(row.find('td:eq(0)').text());
                $('#size').val(row.find('td:eq(1)').text());
                $('#percent').val(row.find('td:eq(2)').text());
                $('#action').val('Update');
            });

            $('#admin_size_list tbody').on('click', '#btnDeleteSize', function (event) {
                event.preventDefault();
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
                            url: route('admin.size.destroy', {id: id}),
                            success: function (data, res) {
                                swal({
                                    title: "Success",
                                    icon: "success",
                                    timer: 2000,
                                });
                                size_table.ajax.reload(null, false);
                            },
                            error: function(xhr, status, error) {
                                toastr.error(JSON.parse(xhr.responseText), 'Error!');
                            }
                        });
                    }
                })
            });

            $('#action').click(function (event) {
                event.preventDefault();
                var id = $('#id').val();
                var url = route('admin.size.store');
                if (id != '') {
                    url = route('admin.size.update', id);
                }
                $.ajax({
                    type: 'post',
                    url: url,
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: new FormData($('form#form-size')[0]),
                    success: function (res) {
                        size_table.ajax.reload(null, false);
                        $('#modal-size').modal('hide');
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
        });
    </script>
@endsection
