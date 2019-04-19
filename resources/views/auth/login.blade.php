@extends('layouts.app')

@section('content')
<style type="text/css" media="screen">
    .invalid-feedback {
        color: red;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('message.login') }}</div>

                <div class="card-body">
                    {{ Form::open(['method' => 'POST', 'route' => 'postLogin' ]) }}
                        @csrf

                        <div class="form-group row">
                            {{ Form::label('email', __('message.email'), ['class' => 'col-sm-4 col-form-label text-md-right']) }}
                            <div class="col-md-6">
                                {{ Form::email('email', old('email'), ['required', 'autofocus', 'class' => 'form-control' . $errors->has('email') ? ' is-invalid' : '']) }}

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('password', __('message.password'), ['class' => 'col-sm-4 col-form-label text-md-right']) }}
                            <div class="col-md-6">
                                {{ Form::password('password', old('password'), ['required', 'class' => 'form-control' . $errors->has('email') ? ' is-invalid' : '']) }}

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                                @if (session('fail'))
                                    <br>
                                    <span class="text-danger">
                                        <strong>{{ session('fail') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    {{ Form::checkbox('remember', 'value', false, ['class' => 'form-check-input']) }}

                                    {{ Form::label('remember', __('message.remember'), ['class' => 'form-check-label']) }}

                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                {{ Form::submit(__('message.login'), ['class' => 'btn btn-primary']) }}

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('message.password.forgot') }}
                                </a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
