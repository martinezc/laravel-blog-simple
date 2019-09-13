@extends('main')

@section('title', '| Edit Tag')

@section('content')

{!! Form::model($tag, ['route' => ['tags.update', $tag->id], 'method' => 'PATCH']) !!}
<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
{!! Form::submit('Save Changes', ['class' => 'btn btn-success']) !!}   
{!! Form::close() !!}

@endsection
