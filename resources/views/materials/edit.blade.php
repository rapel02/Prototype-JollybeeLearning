@extends('layouts.layout')

@section('content')
    <h1>Edit Material</h1>
    {!! Form::open(['action' => ['MaterialController@update',$materials->id],'method' => 'POST']) !!}
        <div class = "form-group">
            {!! Form::label('title', 'Title') !!}
            {!!Form::text('title',$materials->title,['class' => 'form-control','placeholder' => 'Title'])!!}  
        </div>
        <div class = "form-group">
            {!! Form::label('topics', 'Topics') !!}
            @php
                $arraymap = array();
                foreach($relation as $relate){
                    $arraymap[] = $relate->topic_id;
                }
            @endphp
            @foreach($topics as $topic)
            <br>
                @if(in_array($topic->id,$arraymap))
                    {{ Form::checkbox('topics[]',$topic->id,true) }}{{$topic->title}}
                @else
                    {{ Form::checkbox('topics[]',$topic->id) }}{{$topic->title}}
                @endif
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
            {!!Form::number('difficulty',$materials->difficulty,['class' => 'form-control','placeholder' => 'Difficulty'])!!}  
        </div>
        <div class = "form-group">
            {!! Form::label('content', 'Content') !!}
            {!! Form::textarea('content',$materials->content,['id' => 'article-ckeditor','class' => 'form-control','placeholder' => 'Content'])!!}  
        </div>
        {!!Form::hidden('_method','PUT')!!}
        {!! Form::submit('Edit', ['class' => 'btn btn-secondary']); !!}
    {!! Form::close() !!}
@endsection

