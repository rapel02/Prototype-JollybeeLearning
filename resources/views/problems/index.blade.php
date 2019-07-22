@extends('layouts.layout')

@section('content')
    <div class = "row">
        <div class = "col-10">
            <h1>Problems</h1>
        </div>
        @if(!Auth::guest() && Auth::user()->authentication >= 1)
            <div class = "col-2">
                <a class="btn btn-primary" href="/problems/create">Add Problems</a>
            </div>
        @endif
    </div>
    <br>
    @if(count($topics) > 0)
        @foreach($topics as $topic)
            <a href = "/problems/tags/{!!$topic->slug!!}"> <span class = "badge badge-secondary">{{$topic->title}}</span></a>
        @endforeach
    @endif
    <br><br>
    {{$problems->appends(request()->input())->links()}}
    <div class = "table-responsive">
        <table class="table table-hover">
            <thead>
                {!! Form::open(['action' => 'ProblemController@index','method' => 'GET']) !!}
                <th scope = "col">
                    @sortablelink('onlinejudge','OJ')
                    <br>
                    {!! Form::select('onlinejudge', [''=>'', 'UVA' => 'UVA', 'Codeforces' => 'Codeforces', 'SPOJ' => 'SPOJ', 'Kattis' => 'Kattis']) !!}
                </th>
                <th scope = "col">
                    @sortablelink('problemid','ID')<br>
                    {!!Form::text('problemid','',['class' => 'form-control col-8','placeholder' => 'ID'])!!}
                </th>
                <th scope = "col">
                    @sortablelink('title','Name')<br>
                    {!!Form::text('title','',['class' => 'form-control col-8','placeholder' => 'title'])!!}
                </th>
                <th scope = "col">Tags</th>
                <th scope = "col" colspan = "2">{!! Form::submit('Filter', ['class' => 'btn btn-outline-secondary']); !!}</th>
                {!! Form::close() !!}
            </thead>
            <tbody>
                @if(count($problems) > 0)
                    @foreach($problems as $problem)
                        <tr>
                            <td scope = "col">{{$problem->onlinejudge}}</td>
                            <td scope = "col">
                                <a href = {{$problem->link}}>
                                    {{$problem->problemid}}
                                </a>
                            </td>
                            <td scope = "col">
                                <a href = "/problems/{!!$problem->slug!!}/solutions">
                                    {{$problem->title}}
                                </a>
                            </td>
                            <td scope = "col">
                                @if(count($problem->problem_topic_relation()->get()) > 0)
                                    @foreach($problem->problem_topic_relation()->get() as $relation)
                                        <a href = "/problems/tags/{!!$relation->topics()->first()->slug!!}"><span class = "badge badge-secondary">{{$relation->topics()->first()->title}}</span></a>
                                    @endforeach
                                @endif
                            </td>
                            @if(Auth::guest() || Auth::user()->authentication < 1)
                            @else
                                <td scope = "col" class = "text-center" style="margin-left:0;margin-right: 0; padding-left:0;padding-right:0;">
                                    <a href = "/problems/{!!$problem->slug!!}/edit" class = "btn btn-secondary">Edit</a>
                                </td>
                                <td scope = "col" class = "text-center" style="margin-left:0;margin-right: 0; padding-left:0;padding-right:0;">
                                    {!!Form::open(['action' => ['ProblemController@destroy',$problem->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                        {!!Form::hidden('_method','DELETE')!!}
                                        {!!Form::submit('Delete',['class' => 'btn btn-danger'])!!}
                                    {!!Form::close()!!}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection