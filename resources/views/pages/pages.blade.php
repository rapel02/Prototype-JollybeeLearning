@extends('layouts.layout')

@section('content')
    <h1>Recently Updated Material</h1>
        @if(count($materials) > 0)
            <li class = "list-group-item">
                <div  class = "row">
                    <div class = "col-7">
                        <h5><b>Material</b></h5>
                    </div>
                    <div class = "col-5">
                        <h5><b>Tags</b></h5>
                    </div>
                </div>
            </li>
            @foreach($materials as $material)
                <li class = "list-group-item">
                    <div  class = "row">
                        <div class = "col-7">
                            <h5><a href="/materials/{{$material->id}}">{{$material->title}}</a></h5>
                        </div>
                        <div class = "col-5">
                            @if(count($material->material_topic_relation()->get()) > 0)
                                @foreach($material->material_topic_relation()->get() as $relation)
                                    <span class = "badge badge-secondary">{{$relation->topics()->first()->title}}</span>
                                @endforeach
                            @endif
                            <div class = "small">Expected Difficulty {{$material->difficulty}}</div>
                        </div>
                    </div>
                </li>
            @endforeach
        @endif
    <hr>
    <h1>Recently Added Problems</h1>
        @if(count($problems) > 0)
            <li class = "list-group-item">
                <div  class = "row">
                    <div class = "col-3">
                        <h5><b>Problem Code</b></h5>
                    </div>
                    <div class = "col-4">
                        <h5><b>Problem Title</b></h5>
                    </div>
                    <div class = "col-5">
                        <h5><b>Tags</b></h5>
                    </div>
                </div>
            </li>
            @foreach($problems as $problem)
                <li class = "list-group-item">
                    <div  class = "row">
                        <div class = "col-3">
                            <a href = {{$problem->link}}><h6>{{$problem->onlinejudge}}-{{$problem->problemid}}</h6></a>
                        </div>
                        <div class = "col-4">
                            <h5>
                                <a href = {{$problem->link}}>
                                    {{$problem->title}}
                                </a>
                            </h5>
                        </div>
                        <div class = "col-5">
                            @if(count($problem->problem_topic_relation()->get()) > 0)
                                @foreach($problem->problem_topic_relation()->get() as $relation)
                                    <span class = "badge badge-secondary">{{$relation->topics()->first()->title}}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        @endif
    <hr>
    <h1>Recently Added Solutions</h1>
        @if(count($solutions) > 0)
            <li class = "list-group-item">
                <div  class = "row">
                    <div class = "col-3">
                        <h5><b>Username</b></h5>
                    </div>
                    <div class = "col-4">
                        <h5><b>Problem Solution</b></h5>
                    </div>
                    <div class = "col-5">
                        <h5><b>Tags</b></h5>
                    </div>
                </div>
            </li>
            @foreach($solutions as $solution)
                <li class = "list-group-item">
                    <div  class = "row">
                        <div class = "col-3">
                            <h5>{{($solution->user()->get())[0]->username}}</h5>
                        </div>
                        <div class = "col-4">
                            <h5>
                                <a href = /problems/{{($solution->problems()->get())[0]->slug}}/solutions><h5>{{($solution->problems()->get())[0]->onlinejudge}}-{{($solution->problems()->get())[0]->problemid}} ({{($solution->problems()->get())[0]->title}})</h5></a>
                            </h5>
                        </div>
                        <div class = "col-5">
                            @php
                                $problem = ($solution->problems()->get())[0];
                            @endphp
                            @if(count($problem->problem_topic_relation()->get()) > 0)
                                @foreach($problem->problem_topic_relation()->get() as $relation)
                                    <span class = "badge badge-secondary">{{$relation->topics()->first()->title}}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
            @endforeach
        @endif
        </li>    
    <hr>
@endsection