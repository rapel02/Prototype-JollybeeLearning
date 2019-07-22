@extends('layouts.layout')

@section('content')
    <div class = "row">
        <div class = "col-10">
            <h1>{!!$problems->title!!}</h1>
        </div>
        @if(!Auth::guest())
            <div class = "col-2">
                <a class="btn btn-primary" href="/problems/{{$problems->slug}}/solutions/create">Create Solution</a>
            </div>
        @endif
    </div>
    <br>
    @if(count($solutions) > 0)
        @foreach($solutions as $solution)
            <div class = "card border-dark">
                <div class = "card-header">
                    <div class = "row">
                        <div class = "col-10">
                            Solution by: {{($solution->user()->get())[0]->username}}-{{($solution->user()->get())[0]->name}}
                            <br>
                            {{$solution->created_at}}
                        </div>
                        @if(!Auth::guest() && Auth::user()->authentication > 1 || ($solution->user()->get())[0]->id = Auth::user()->id)
                            <div class = "col-1">
                                <a href = "/problems/{!!$problems->slug!!}/solutions/{!!$solution->id!!}/edit/" class = "btn btn-secondary">Edit</a>
                            </div>
                            <div class = "col-1">
                                {!!Form::open(['action' => ['SolutionController@destroy',$problems->slug,$solution->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                    {!!Form::hidden('_method','DELETE')!!}
                                    {!!Form::submit('Delete',['class' => 'btn btn-danger'])!!}
                                {!!Form::close()!!}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body text-dark">
                    <p class="card-text">{!!$solution->content!!}</p>
                </div>
            </div>
            <br>
        @endforeach
    @else
        <h2>No solution added</h2>
    @endif
@endsection