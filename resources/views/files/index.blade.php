@extends('layouts.layout')

@section('content')
    <div class = "row">
        <div class = "col-10">
            <h1>Files</h1>
        </div>
        @if(!Auth::guest() && Auth::user()->authentication >= 1)
            <div class = "col-2">
                <a class="btn btn-primary" href="/files/create">Upload Files</a>
            </div>
        @endif
    </div>
    <br>
    @if(count($files) > 0)
        <li class = "list-group-item">
            <div class = "row">
                <div class = "col-md-2 col-sm-2">
                    <h5>Files</h5>
                </div>
                <div class = "col-md-3 col-sm-3">
                    <h5>Name</h5>
                </div>
                <div class = "col-md-4 col-sm-4">
                    <h5>Path</h5>
                </div>
                <div class = "col-md-2 col-sm-2">
                    <h5>Time Uploaded</h5>
                </div>
                <div class = "col-md-1 col-sm-1">
                </div>
            </div>
        </li>
        @foreach($files as $file)
            <li class = "list-group-item">
                <div class = "row">
                    <div class = "col-md-2 col-sm-2">
                        <img style = "max-height: 15vh; max-width: 100%" src = "/storage/materials/{{$file->filename}}" alt="No Image Available">
                    </div>
                    <div class = "col-md-3 col-sm-3">
                        {{$file->name}}
                    </div>
                    <div class = "col-md-4 col-sm-4">
                        /storage/materials/{{$file->filename}}
                    </div>
                    <div class = "col-md-2 col-sm-2">
                        {{$file->updated_at}}
                    </div>
                    <div class = "col-md-1 col-sm-1">
                        {!!Form::open(['action' => ['FileController@destroy',$file->id], 'method' => 'POST', 'class' => 'pull-right','enctype' => 'multipart/form-data', 'files'=>true])!!}
                            {!!Form::hidden('_method','DELETE')!!}
                            {!!Form::submit('Delete',['class' => 'btn btn-danger'])!!}
                        {!!Form::close()!!}
                    </div>
                </div>
            </li>
        @endforeach
        {{$files->links()}}
    @endif
@endsection