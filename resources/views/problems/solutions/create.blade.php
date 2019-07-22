@extends('layouts.layout')

@section('content')
    <h1>Create Solution</h1>
    <br><br>
    {!! Form::open(['action' => ['SolutionController@store',$problems->slug],'method' => 'POST']) !!}
        <div class = "form-group">
            {!! Form::textarea('content','',['id' => 'article-ckeditor','class' => 'form-control','placeholder' => 'Content'])!!}  
        </div>
        {!! Form::submit('Create', ['class' => 'btn btn-primary']); !!}
    {!! Form::close() !!}
@endsection