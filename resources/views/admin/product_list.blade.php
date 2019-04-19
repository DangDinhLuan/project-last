@extends('layouts.app2')

@section('page-title')
    <li><a href="{{route('admin.index')}}">{{ __('message.title.dashboard') }}</a></li>
    <li class="active">{{ __('message.product') }}</li>
@endsection

@section('content')
    <div class="animated fadeIn">
        <div class="rows">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ __('message.product') }}</strong>
                        <div class="float-right">
                            <a href="#" id="create-product"
                               class="btn btn-outline-info" data-toggle="modal"
                               data-target="#modal-product">
                                {{ __('message.create') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive m-t-40">
                            <table class="table table-striped table-bordered" id="admin_product_list">
                                <thead>
                                <tr>
                                    <th>{{ __('message.id') }}</th>
                                    <th>{{ __('message.product') }}</th>
                                    <th>{{ __('message.category') }}</th>
                                    <th>{{ __('message.image') }}</th>
                                    <th>{{ __('message.brief') }}</th>
                                    <th>{{ __('message.order_detai_title.description') }}</th>
                                    <th>{{ __('message.discount') }}</th>
                                    <th>{{ __('message.price') }}</th>
                                    <th>{{ __('message.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-product" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open(['id' => 'form-product']) !!}
                <div class="modal-header">
                    <h5>{{ __('message.product') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group" id="form-group-id">
                                {!! Form::label('id', __('message.id'), ['class' => 'form-control-label']) !!}
                                {!! Form::text('id', null, ['class' => 'form-control col-md-10',
                                'required' => 'required', 'placeholder' => 'ID Product', 'readonly']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('name', __('message.name'), ['class' => 'form-control-label']) !!}
                                {!! Form::text('name', null, ['class' => 'form-control col-md-10',
                                 'required' => 'required', ' id' => 'name', 'placeholder' => 'Name',
                                  'autocomplete' => 'off']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('quantity', __('message.quantity'), ['class' => 'form-control-label']) !!}
                                {!! Form::number('quantity', null, ['class' => 'form-control col-md-10',
                                 'required' => 'required', ' id' => 'quantity', 'placeholder' => 'Quantity']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('price', __('message.price'), ['class' => 'form-control-label']) !!}
                                {!! Form::number('price', null, ['class' => 'form-control col-md-10',
                                 'required' => 'required', ' id' => 'price', 'placeholder' => 'Price']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('discount', __('message.discount'), ['class' => 'form-control-label']) !!}
                                {!! Form::number('discount', null, ['class' => 'form-control col-md-10',
                                 'required' => 'required', ' id' => 'discount', 'placeholder' => 'Discount']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('brief', __('message.brief'), ['class' => 'form-control-label']) !!}
                                {!! Form::text('brief', null, ['class' => 'form-control col-md-10',
                                 'required' => 'required', ' id' => 'name', 'placeholder' => 'Brief',
                                  'autocomplete' => 'off']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('image', __('message.image'), ['class' => 'form-control-label']) !!}
                                {!! Form::file('image', ['id' => 'image', 'class' => 'col-md-10',
                                 'required' => 'required', ' id' => 'image']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('category_id', __('message.category'), ['class' => 'form-control-label']) !!}
                                {!! Form::select('category_id', [], null, ['class' => 'form-control col-md-10', 'required' => 'required', ' id' => 'category_id']) !!}
                            </div>

                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('id', __('message.review'), ['class' => 'form-control-label']) !!}
                            <div id="" class="img-fluid">
                                <img id="image_review_create" style="max-height: 350px" class="card-img">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::label('description', __('message.description'), ['class' => 'form-control-label']) !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                        </div>
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
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var nf = new Intl.NumberFormat();
            CKEDITOR.replace('description')
            var product_table = $('#admin_product_list').DataTable({
                processing: true,
                serverSide: true,
                order: ['0', 'desc'],
                ajax: {
                    url: route('admin.product.json'),
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    }, {
                        data: 'name',
                        name: 'name'
                    }, {
                        data: 'category.name',
                        name: 'category.name'
                    }, {
                        data: 'images',
                        name: 'images',
                        render: function (data, type, row) {
                            var base_url_image = '{{ asset(config('asset.image_path.product')) }}/';
                            return `<img src="` + base_url_image + `${data[0]['name']}">`
                        }
                    }, {
                        data: 'brief',
                        name: 'brief',
                        render: function (data, type, row) {
                            return data.substr(0, 20) + "...";
                        }
                    }, {
                        data: 'description',
                        name: 'description',
                        render: function (data, type, row) {
                            return data.substr(0, 20) + "...";
                        }
                    }, {
                        data: 'discount',
                        name: 'discount',
                        render: function (data) {
                            return nf.format(data) + ' %';
                        }
                    }, {
                        data: 'price',
                        name: 'price',
                        render: function (data) {
                            return nf.format(data) + ' ₫';
                        }
                    }, {
                        data: null,
                        name: null,
                        defaultContent: [
                            '<button class="btn btn-outline-primary" title="Update" data-toggle="modal" data-target="#modal-product" id="btnUpdateProduct"><i class="fa fa-edit"></i></button> ' +
                            '<button class="btn btn-outline-danger" title="Delete" id="btnDeleteProduct"><i class="fa fa-trash-o"></i></button> '
                        ],
                    },
                ],
            });

            function loadSelectCategory() {
                $.ajax({
                    type: 'get',
                    url: route('admin.product.category_select'),
                    dataType: 'json',
                    success: function (data) {

                        var arr = Object.entries(data);
                        var option = '<option value="" hidden>Choose Category</option>';;
                        arr.forEach(function (element, index) {
                            option += '<option value="' + element[0] + '">' + element[1] + '</option>';
                        });
                        $('#category_id').html(option);
                    },
                });
            }

            $('#create-product').click(function (event) {
                event.preventDefault();
                $('#form-group-id').hide();
                loadSelectCategory();
                $('#image_review_create').hide();
                $('#form-product')[0].reset();
                $('#action').val('Create');
                CKEDITOR.instances['description'].setData('');
            });

            $('#admin_product_list tbody').on('click', '#btnUpdateProduct', function () {
                $('#form-group-id').show();
                $('#image_review_create').show();
                $('#action').val('Update');
                var row = $(this).closest('tr');
                var id = row.find('td:eq(0)').text();
                loadSelectCategory();
                $.ajax({
                    type: 'get',
                    url: route('admin.product.show', {id: id}),
                    success: function (data) {
                        $('#id').val(data.id);
                        $('#name').val(data.name);
                        $('#price').val(data.price);
                        $('#discount').val(data.discount);
                        $('#quantity').val(data.quantity);
                        $('#category_id').val(data.category_id);
                        CKEDITOR.instances['description'].setData(data.description);
                        var base_url_image = '{{ asset(config('asset.image_path.product')) }}';
                        $('#image_review_create').attr('src', base_url_image + data.images[0].name);
                    },
                });
            });

            $('#admin_product_list tbody').on('click', '#btnDeleteProduct', function () {
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
                            url: route('admin.product.destroy', {id: id}),
                            success: function (data) {
                                swal({
                                    title: "Success",
                                    icon: "success",
                                    timer: 2000,
                                });
                                product_table.ajax.reload();
                            },
                            error: function(xhr, status, error) {
                                toastr.error(JSON.parse(xhr.responseText), 'Error!');
                            }
                        });
                    }
                })
            });

            $('#image').change(function () {
                $('#image_review_create').show();
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#image_review_create').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            $('#action').click(function (event) {
                event.preventDefault();
                var id = $('#id').val();
                var url = route('admin.product.store');
                if (id != '') {
                    url = route('admin.product.update', id);
                }
                var form = new FormData($('form#form-product')[0]);
                form.append('description', CKEDITOR.instances['description'].document.getBody().getText());
                $.ajax({
                    method: 'post',
                    data: form,
                    url: url,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function (res) {
                        product_table.ajax.reload(null, false);
                        $('#modal-product').modal('hide');
                        swal({
                            title: "Success",
                            icon: "success",
                            timer: 2000,
                        });
                        CKEDITOR.instances['description'].setData('');
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
