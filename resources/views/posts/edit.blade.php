@extends('main')

@section('title', '| Edit Blog Post')

@section('stylesheets')
{!! Html::style('css/select2.min.css') !!}
@endsection


@section('content')

    <div class="row"> 
        {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'PATCH', 'files' => true]) !!}
        <div class="col-md-8">
            <div class="form-group">
                {{ Form::label('title', 'Title') }}
                {{ Form::text('title', null, ['class' => 'form-control input-lg']) }}
            </div>

            <div class="form-group">
                {{ Form::label('slug', 'Slug') }}
                {{ Form::text('slug', null, ['class' => 'form-control']) }}
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
                {{ Form::label('featured_image', 'Update Featured Image') }}
                {!! Form::file('featured_image', ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {{ Form::label('body', 'Post Body') }}
                {{ Form::textarea('body', null, ['class' => 'form-control', 'id' => 'editor1']) }}
            </div>
        </div>

        <div class="col-md-4">
            <div class="well">
                <dl class="dl-horizontal">
                    <dt>Created At:</dt>
                    <dd>
                        @if ($post->created_at->diffInWeeks($date) >= 1)
                            {{ date('M. j, Y g:ia', strtotime($post->created_at)) }}
                        @else 
                            {{ $post->created_at->diffForHumans() }}
                        @endif
                    </dd>
                </dl>

                <dl class="dl-horizontal">
                    <dt>Last Updated:</dt>
                    <dd>{{ date('M. j, Y g:ia', strtotime($post->updated_at)) }}</dd>
                </dl>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        {!! Html::linkRoute('posts.show', 'Cancel', array($post->id), array('class' => 'btn btn-danger btn-block')) !!}
                    </div>

                    <div class="col-sm-6">
                        {!! Form::submit('Save Changes', ['class' => 'btn btn-success btn-block']) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div><!-- end of .row (form) -->

@endsection

@section('scripts')
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