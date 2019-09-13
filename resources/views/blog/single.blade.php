@extends('main')

@section('title', "| $post->title")

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2"> 
            
            <img src="{{ asset('images/' . $post->image) }}">
            
            <h1>{{ $post->title }}</h1>
            <p>{!! $post->body !!}</p>
            <hr>
            <p>Posted In: {{ $post->category->name }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3 class="comments-title"><span class="glyphicon glyphicon-comment"></span> {{ $post->comments->count() }} Comments</h3>
            @foreach ($post->comments as $comment)
                <div class="comment">
                    <div class="author-info">
                        <img src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($comment->email))) . "?d=wavatar&r=g" }}" class="author-image">
                        <div class="author-name">
                            <h4>{{ $comment->name }}</h4>
                            <p class="author-time">
                                @if ($comment->created_at->diffInWeeks($date) >= 1)
                                    {{ date('F nS, Y g:ia', strtotime($comment->created_at)) }}
                                @else 
                                    {{ $comment->created_at->diffForHumans() }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="comment-content">
                        {{ $comment->comment }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div id="comment-form" class="col-md-8 col-md-offset-2">
            
            {!! Form::open(['route' => ['comments.store', $post->id]]) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('name', 'Name') }}
                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('email', 'Email') }}
                        {{ Form::text('email', null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::label('comment', 'Comment') }}
                        {{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5']) }}
                    </div>
                    {!! Form::submit('Add Comment', ['class' => 'btn btn-success btn-block']) !!}
                </div>
            </div>
            {!! Form::close() !!}
    
        </div>
    </div>

@endsection