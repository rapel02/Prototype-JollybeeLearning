@extends('layouts.layout')

@section('content')
    <h1>Edit Topic</h1>
    {!! Form::open(['action' => ['TopicController@update',$topics->id],'method' => 'POST']) !!}
        <div class = "form-group">
            {!! Form::label('title', 'Title') !!}
            {!!Form::text('title',$topics->title,['class' => 'form-control','placeholder' => 'Title'])!!}  
        </div>
        {!!Form::hidden('_method','PUT')!!}
        {!! Form::submit('Edit', ['class' => 'btn btn-primary']); !!}
    {!! Form::close() !!}
@endsection