@extends('layouts.layout')

@section('content')
    <h1>Create Material</h1>
    {!! Form::open(['action' => 'MaterialController@store','method' => 'POST']) !!}
        <div class = "form-group">
            {!! Form::label('title', 'Title') !!}
            {!!Form::text('title','',['class' => 'form-control','placeholder' => 'Title'])!!}  
        </div>
        <div class = "form-group">
            {!! Form::label('topics', 'Topics') !!}
            @foreach($topics as $topic)
            <br>
                {{ Form::checkbox('topics[]',$topic->id) }}{{$topic->title}}
            @endforeach
        </div>
        <div class = "form-group">
            {!! Form::label('difficulty', 'Difficulty') !!}
            <br>
            {!! Form::label('description','1 - 9 Basic') !!}
            <br>
            {!! Form::label('description','10 - 19 Intermediate') !!}
            <br>
            {!! Form::label('description','20 - 29 Advanced') !!}
            {!!Form::number('difficulty','',['class' => 'form-control','placeholder' => 'Difficulty'])!!}  
        </div>
        <div class = "form-group">
            {!! Form::label('content', 'Content') !!}
            {!! Form::textarea('content','',['id' => 'article-ckeditor','class' => 'form-control','placeholder' => 'Content'])!!}  
        </div>
        {!! Form::submit('Create', ['class' => 'btn btn-primary']); !!}
    {!! Form::close() !!}
@endsection