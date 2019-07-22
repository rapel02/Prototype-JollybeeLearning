@extends('layouts.layout')

@section('content')
    <h1>Edit Users</h1>
    {!! Form::open(['action' => ['UserController@update',$users->id],'method' => 'POST']) !!}
        <div class = "form-group">
            {!! Form::label('username', 'Username') !!}
            {!!Form::text('username',$users->username,['class' => 'form-control','placeholder' => 'Name'])!!}  
        </div>
        <div class = "form-group">
            {!! Form::label('name', 'Name') !!}
            {!!Form::text('name',$users->name,['class' => 'form-control','placeholder' => 'Username'])!!}  
        </div>
        <div class = "form-group">
            {!! Form::label('email', 'Email') !!}
            {!!Form::text('email',$users->email,['class' => 'form-control','placeholder' => 'Email'])!!}  
        </div>
        <div class = "form-group">
            {!! Form::label('level', 'Level') !!}
            {!!Form::number('level',$users->level,['class' => 'form-control','placeholder' => 'Level'])!!}  
        </div>
        <div class = "form-group">
            {!! Form::label('authentication', 'Role') !!}
            @if(Auth::user()->authentication >= -1)
                <br>
                @if($users->authentication == -1)
                    {{ Form::radio('authentication',-1,true) }}Unverified Member
                @else
                    {{ Form::radio('authentication',-1) }}Unverified Member
                @endif
            @endif
            @if(Auth::user()->authentication >= 0)
                <br>
                @if($users->authentication == 0)
                    {{ Form::radio('authentication',0,true) }}Member
                @else
                    {{ Form::radio('authentication',0) }}Member
                @endif
            @endif
            @if(Auth::user()->authentication >= 1)
                <br>
                @if($users->authentication == 1)
                    {{ Form::radio('authentication',1,true) }}Lecturer
                @else
                    {{ Form::radio('authentication',1) }}Lecturer
                @endif
            @endif
            @if(Auth::user()->authentication >= 2)
                <br>
                @if($users->authentication >= 2)
                    {{ Form::radio('authentication',2,true) }}Admin
                @else
                    {{ Form::radio('authentication',2) }}Admin
                @endif
            @endif
        </div>
        {!!Form::hidden('_method','PUT')!!}
        {!! Form::submit('Edit', ['class' => 'btn btn-primary']); !!}
    {!! Form::close() !!}
@endsection