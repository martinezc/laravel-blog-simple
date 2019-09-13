@extends('main')

@section('title', '| Contact Me')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Contact Me</h1>
        <hr>
        <form action="{{ url('contact') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Subject:</label>
                <input type="text" name="subject" class="form-control">
            </div>
            <div class="form-group">
                <label>Message:</label>
                <textarea name="message" id="message" class="form-control">Type your message here...</textarea>
            </div>
            <input type="submit" value="Send Message" class="btn btn-success">
        </form>
    </div>
</div>
@endsection
        