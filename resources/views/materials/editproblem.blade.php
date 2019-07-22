@extends('layouts.layout')

@section('content')
    <h1>Edit Problem to try</h1>
    <br>
    @php
        $arraymap = array();
        foreach($relation as $relate){
            $arraymap[] = $relate->problem_id;
        }
    @endphp
    {!! Form::open(['action' => ['MaterialController@updateproblem',$id],'method' => 'POST']) !!}
        <table class="table table-hover">
            <thead>
                <th scope = "col-1"></th>
                <th scope = "col-1">OJ</th>
                <th scope = "col-2">ID</th>
                <th scope = "col-3">Name</th>
                <th scope = "col-4">Tags</th>
            </thead>
            <tbody>
            @foreach($problems as $problem)
                <tr>
                    @if(in_array($problem->id,$arraymap))
                    <td scope = "col-1">
                        {{ Form::checkbox('prob[]',$problem->id,true) }}
                    </td>
                    @else
                    <td scope = "col-1">
                        {{ Form::checkbox('prob[]',$problem->id) }}
                    </td>
                    @endif
                    <td scope = "col-1">
                        {{$problem->onlinejudge}}
                    </td>
                    <td scope = "col-2">
                        {{$problem->problemid}}
                    </td>
                    <td scope = "col-3">
                        {{$problem->title}}
                    </td>
                    <td scope = "col-4">
                        @foreach($problem->problem_topic_relation()->get() as $relation)
                            <span class = "badge badge-secondary">{{$relation->topics()->first()->title}}</span>
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! Form::submit('Store', ['class' => 'btn btn-secondary']); !!}
    {!! Form::close() !!}
@endsection