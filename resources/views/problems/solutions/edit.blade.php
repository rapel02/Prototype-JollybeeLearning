@extends('layouts.layout')

@section('content')
    <h1>Edit Solution</h1>
    <br><br>
    {!! Form::open(['action' => ['SolutionController@update',$problems->slug,$solutions->id],'method' => 'POST']) !!}
        <div class = "form-group">
            {!! Form::textarea('content',$solutions->content,['id' => 'article-ckeditor','class' => 'form-control','placeholder' => 'Content'])!!}  
        </div>
        {!!Form::hidden('_method','PUT')!!}
        {!! Form::submit('Edit', ['class' => 'btn btn-secondary']); !!}
    {!! Form::close() !!}
@endsection