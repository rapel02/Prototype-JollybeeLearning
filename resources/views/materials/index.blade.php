@extends('layouts.layout')

@section('content')
    <div class = "row">
        <div class = "col-10">
            <h1>Materials</h1>
        </div>
        @if(!Auth::guest() && Auth::user()->authentication >= 1)
            <div class = "col-2">
                <a class="btn btn-primary" href="/materials/create">Create Material</a>
            </div>
        @endif
    </div>
    <br>
    @if(count($topics) > 0)
        @foreach($topics as $topic)
            <a href = "/materials/tags/{!!$topic->slug!!}"> <span class = "badge badge-secondary">{{$topic->title}}</span></a>
        @endforeach
    @endif
    <br>
    @if(count($materials) > 0)
        <br><br>
        {!! Form::open(['action' => 'MaterialController@index','method' => 'GET']) !!}
        <div class = "row">
            <div class = "col-5">
                {!!Form::text('title','',['class' => 'form-control col-12','placeholder' => 'title'])!!}
            </div>
            <div class = "col-1">
                {!!Form::label('', '') !!}
                {!! Form::submit('Filter', ['class' => 'btn btn-outline-secondary']); !!}
            </div>
        </div>
        {!! Form::close() !!}
        <br>
        <h3>Basic</h3>
        <hr>
        <ul class = "list-group">
            @foreach($materials as $material)
                @if($material->difficulty < 10)
                    <li class = "list-group-item">
                        <div  class = "row row-hover">
                            <div class = "col-8">
                                <h5><a href="/materials/{{$material->slug}}">{{$material->title}}</a></h5>
                            </div>
                            <div class = "col-4">
                                <h6>
                                @if(count($material->material_topic_relation()->get()) > 0)
                                    @foreach($material->material_topic_relation()->get() as $relation)
                                        <a href="/materials/tags/{!!$relation->topics()->first()->slug!!}"><span class = "badge badge-secondary">{{$relation->topics()->first()->title}}</span></a>
                                    @endforeach
                                @endif
                                </h6>
                                <div class = "small">Expected Difficulty {{$material->difficulty}}</div>
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
        <br>
        <h3>Intermediate</h3>
        <hr>
        <ul class = "list-group">
            @if(!Auth::guest())
                @if(Auth::user()->level >= 10)
                    @foreach($materials as $material)
                        @if($material->difficulty < 20 && $material->difficulty >= 10)
                            <li class = "list-group-item">
                                <div  class = "row">
                                    <div class = "col-8">
                                        <h5><a href="/materials/{{$material->slug}}">{{$material->title}}</a></h5>
                                    </div>
                                    <div class = "col-4">
                                        <h6>
                                            @if(count($material->material_topic_relation()->get()) > 0)
                                                @foreach($material->material_topic_relation()->get() as $relation)
                                                    <a href="/materials/tags/{!!$relation->topics()->first()->slug!!}"><span class = "badge badge-secondary">{{$relation->topics()->first()->title}}</span></a>
                                                @endforeach
                                            @endif
                                        </h6>
                                        <div class = "small">Expected Difficulty {{$material->difficulty}}</div>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @else
                    <h4>You need to practice more to unlock this content</h4>
                @endif
            @else
                <h4>You need to login to unlock this content</h4>
            @endif
        </ul>
        <br>
        <h3>Advanced</h3>
        <hr>
        <ul class = "list-group">
            @if(!Auth::guest())
                @if(Auth::user()->level >= 20)
                    @foreach($materials as $material)
                        @if($material->difficulty >= 20)
                            <li class = "list-group-item">
                                <div  class = "row">
                                    <div class = "col-8">
                                        <h5><a href="/materials/{{$material->slug}}">{{$material->title}}</a></h5>
                                    </div>
                                    <div class = "col-4">
                                        <h6>
                                            @if(count($material->material_topic_relation()->get()) > 0)
                                                @foreach($material->material_topic_relation()->get() as $relation)
                                                    <a href="/materials/tags/{!!$relation->topics()->first()->slug!!}"><span class = "badge badge-secondary">{{$relation->topics()->first()->title}}</span></a>
                                                @endforeach
                                            @endif
                                        </h6>
                                        <div class = "small">Expected Difficulty {{$material->difficulty}}</div>
                                    </div>
                                </div>
                            </li>
                        @else
                        @endif
                    @endforeach
                @else
                    <h4>You need to practice more to unlock this content</h4>
                @endif
            @else
                <h4>You need to login to unlock this content</h4>
            @endif
        </ul>
    @else
        <br>
        <h2>No material added</h2>
    @endif
@endsection