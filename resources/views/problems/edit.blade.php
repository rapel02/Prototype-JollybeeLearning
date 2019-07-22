@extends('layouts.layout')

@section('content')
    <h1>Edit Problem</h1>
    {!! Form::open(['action' => ['ProblemController@update',$problems->id],'method' => 'POST']) !!}
        <div class = "form-group">
            {!! Form::label('onlinejudge', 'Online Judge: ') !!}
            @if($problems->onlinejudge == 'UVA') 
                {!! Form::select('onlinejudge', ['UVA' => 'UVA', 'Codeforces' => 'Codeforces', 'SPOJ' => 'SPOJ', 'Kattis' => 'Kattis'], 'UVA') !!}
            @elseif($problems->onlinejudge == 'Codeforces') 
                {!! Form::select('onlinejudge',['UVA' => 'UVA', 'Codeforces' => 'Codeforces', 'SPOJ' => 'SPOJ', 'Kattis' => 'Kattis'], 'Codeforces') !!}
            @elseif($problems->onlinejudge == 'SPOJ')
                {!! Form::select('onlinejudge', ['UVA' => 'UVA', 'Codeforces' => 'Codeforces', 'SPOJ' => 'SPOJ', 'Kattis' => 'Kattis'], 'SPOJ') !!}
            @elseif($problems->onlinejudge == 'Kattis')
                {!! Form::select('onlinejudge', ['UVA' => 'UVA', 'Codeforces' => 'Codeforces', 'SPOJ' => 'SPOJ', 'Kattis' => 'Kattis'], 'Kattis') !!}
            @endif
        </div>
        <div class = "form-group">
            {!! Form::label('problemid', 'Problem ID: ') !!}
            {!!Form::text('problemid',$problems->problemid,['class' => 'form-control','placeholder' => 'ID'])!!}  
        </div>
        <div class = "form-group">
            {!! Form::label('difficulty', 'Difficulty') !!}
            <br>
            {!! Form::label('description','1 - 9 Basic') !!}
            <br>
            {!! Form::label('description','10 - 19 Intermediate') !!}
            <br>
            {!! Form::label('description','20 - 29 Advanced') !!}
            {!!Form::number('difficulty',$problems->difficulty,['class' => 'form-control','placeholder' => 'Difficulty'])!!}  
        </div>
        <div class = "form-group">
            {!! Form::label('tags', 'Tags') !!}
            @php
                $arraymap = array();
                foreach($relation as $relate){
                    $arraymap[] = $relate->topic_id;
                }
            @endphp
            @foreach($topics as $topic)
            <br>
                @if(in_array($topic->id,$arraymap))
                    {{ Form::checkbox('tags[]',$topic->id,true) }}{{$topic->title}}
                @else
                    {{ Form::checkbox('tags[]',$topic->id) }}{{$topic->title}}
                @endif
            @endforeach
        </div>
        {!!Form::hidden('_method','PUT')!!}
        {!! Form::submit('Edit', ['class' => 'btn btn-primary']); !!}
    {!! Form::close() !!}
@endsection