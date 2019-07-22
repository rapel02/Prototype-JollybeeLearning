@extends('layouts.layout')

@section('content')
    <h1>Create Topic</h1>
    {!! Form::open(['action' => 'TopicController@store','method' => 'POST']) !!}
        <div class = "form-group">
            {!! Form::label('title', 'Title') !!}
            {!!Form::text('title','',['class' => 'form-control','placeholder' => 'Title'])!!}  
        </div>
        {!! Form::submit('Create', ['class' => 'btn btn-primary']); !!}
    {!! Form::close() !!}
@endsection