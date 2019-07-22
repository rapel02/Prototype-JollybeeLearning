@extends('layouts.layout')

@section('content')
    <h1>Add Problem</h1>
    {!! Form::open(['action' => 'ProblemController@store','method' => 'POST']) !!}
        <div class = "form-group">
            {!! Form::label('onlinejudge', 'Online Judge: ') !!}
            {!! Form::select('onlinejudge', ['UVA' => 'UVA', 'Codeforces' => 'Codeforces', 'SPOJ' => 'SPOJ', 'Kattis' => 'Kattis']) !!}
        </div>
        <div class = "form-group">
            {!! Form::label('problemid', 'Problem ID: ') !!}
            {!!Form::text('problemid','',['class' => 'form-control','placeholder' => 'ID'])!!}  
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
            {!! Form::label('tags', 'Tags') !!}
            @foreach($topics as $topic)
            <br>
                {{ Form::checkbox('tags[]',$topic->id) }}{{$topic->title}}
            @endforeach
        </div>
        {!! Form::submit('Create', ['class' => 'btn btn-primary']); !!}
    {!! Form::close() !!}
@endsection