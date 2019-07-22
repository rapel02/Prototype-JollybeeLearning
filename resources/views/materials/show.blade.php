@extends('layouts.layout')

@section('content')
    <div class = "row">
        <div class = "col-10">
            <h1>{!!$materials->title!!}</h1>
            <h5>Expected difficulty: {!!$materials->difficulty!!}</h5>
            @if(count($materials->material_topic_relation()->get()) > 0)
                @foreach($materials->material_topic_relation()->get() as $relation)
                    <span class = "badge badge-secondary">{{$relation->topics()->first()->title}}</span>
                @endforeach
            @endif
        </div>
        @if(!Auth::guest() && Auth::user()->authentication > 0)
            <div class = "col-1">
                <a href = "/materials/{!!$materials->slug!!}/edit" class = "btn btn-secondary">Edit</a>
            </div>
            <div class = "col-1">        
                {!!Form::open(['action' => ['MaterialController@destroy',$materials->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                    {!!Form::hidden('_method','DELETE')!!}
                    {!!Form::submit('Delete',['class' => 'btn btn-danger'])!!}
                {!!Form::close()!!}
            </div>
        @endif
    </div>
    <br>
    <div class = "card border-dark">
        <div class = "card-body text-dark">
            {!!$materials->content!!}
            @if(count($materials->material_problem_relation()->get()) > 0)
            <br>
            <h2>Problems to try</h2>
            <ol>
                @foreach($materials->material_problem_relation()->get() as $relation)
                    <li>
                        <a href="{{$relation->problems()->first()->link}}">{{$relation->problems()->first()->title}} --  ({{$relation->problems()->first()->onlinejudge}}-{{$relation->problems()->first()->problemid}})
                        </a>
                        <br>
                        Expected difficulty: {{$relation->problems()->first()->difficulty}}
                    </li>
                @endforeach
            </ol>
            @endif
        </div>
    </div>
    <br>
@endsection