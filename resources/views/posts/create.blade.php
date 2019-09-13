@extends('main')

@section('title', '| Create New Post')

@section('stylesheets')
{!! Html::style('css/parsley.css') !!}
{!! Html::style('css/select2.min.css') !!}

@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Create New Post</h1>
            <hr>
            {!! Form::open(['route' => 'posts.store', 'data-parsley-validate' => '', 'files' => true]) !!}
                <div class="form-group">
                    {{ Form::label('title', 'Title') }}
                    {{ Form::text('title', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '255')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('slug', 'Slug') }}
                    {{ Form::text('slug', null, array('class' => 'form-control', 'required' => '', 'minlength' => '5', 'maxlength' => '250')) }}
                </div>

                <div class="form-group">
                    {!! Form::label('category_id', 'Category') !!}
                    {!! Form::select('category_id', $cats, null, ['class' => 'form-control']) !!}   
                </div>

                <div class="form-group">
                    {!! Form::label('tags', 'Tags') !!}
                    {!! Form::select('tags[]', $tgs, null, ['class' => 'form-control select2-multi', 'multiple' => 'multiple']) !!}   
                </div>

                <div class="form-group">
                    {{ Form::label('featured_image', 'Upload Featured Image') }}
                    {!! Form::file('featured_image', ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {{ Form::label('body', 'Post Body') }}
                    {{ Form::textarea('body', null, array('class' => 'form-control', 'id' => 'editor1')) }}
                </div>

                {{ Form::submit('Create Post', array('class' => 'btn btn-success btn-lg btn-block')) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('scripts')

{!! Html::script('js/parsley.min.js') !!}
{!! Html::script('js/select2.min.js') !!}
<script src="//cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace( 'editor1' );
</script>

<script>
    $(document).ready(function() {
        $('.select2-multi').select2();
    });
</script>

@endsection