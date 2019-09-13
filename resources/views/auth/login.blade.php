@extends('main')

@section('title', '| Login')

@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        {!! Form::open() !!}
        <div class="form-group">
            {{ Form::label('email', 'Email') }}
            {{ Form::email('email', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('password', 'Password') }}
            {{ Form::password('password', ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::checkbox('remember') }}{{ Form::label('remember', 'Remember Me') }}
        </div>

        {{ Form::submit('Login', array('class' => 'btn btn-primary btn-block')) }}
        {!! Form::close() !!}

        <p><a href="{{ url('password/reset') }}">Forgot My Password</a></p>
    </div>
</div>

@endsection