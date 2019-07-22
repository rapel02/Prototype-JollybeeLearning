@extends('layouts.layout')

@section('content')
    <div class = "row">
        <div class = "col-10">
            <h1>Topics</h1>
        </div>
        @if(!Auth::guest() && Auth::user()->authentication >= 1)
            <div class = "col-2">
                <a class="btn btn-primary" href="/topics/create">Create Topic</a>
            </div>
        @endif
    </div>
    <br>
    @if(count($topics) > 0)
        @foreach($topics as $topic)
            <div class = "row">
                <div class = "col-5">
                    <h4>{{$topic->title}}</h4>
                </div>
                @if(!Auth::guest() && Auth::user()->authentication > 0)
                    <div class = "col-1">
                        <a href = "/topics/{!!$topic->slug!!}/edit" class = "btn btn-secondary">Edit</a>
                    </div>
                    <div class = "col-1">        
                        {!!Form::open(['action' => ['TopicController@destroy',$topic->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                            {!!Form::hidden('_method','DELETE')!!}
                            {!!Form::submit('Delete',['class' => 'btn btn-danger'])!!}
                        {!!Form::close()!!}
                    </div>
                @endif
            </div>
            <div style="line-height: 60%">&nbsp;</div>
        @endforeach
    @else
        <h2>No topics added</h2>
    @endif
@endsection