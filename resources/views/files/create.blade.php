@extends('layouts.layout')

@section('content')
    <h1>Add File</h1>
    <h5>Maximum file size 20MB</h5>
    <br>
    {!! Form::open(['action' => 'FileController@store','method' => 'POST', 'enctype' => 'multipart/form-data', 'files'=>true]) !!}
        <div class = "form-group">
            {!! Form::label('filename', 'File Name') !!}
            {!!Form::text('filename','',['class' => 'form-control','placeholder' => 'If empty, it will use original name'])!!}  
        </div>
        <div class = "form-group">
            {!!Form::file('added_file')!!}  
        </div>
        {!! Form::submit('Submit', ['class' => 'btn btn-primary']); !!}
    {!! Form::close() !!}
@endsection