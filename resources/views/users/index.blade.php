@extends('layouts.layout')

@section('content')
    <h1>Users</h1>
    @if(count($users) > 0)
        <br>
        <li class = "list-group-item">
            <div class = "row">
                <div class = "col-2">
                    <h5>Username</h5>
                </div>
                <div class = "col-2">
                    <h5>Name</h5>
                </div>
                <div class = "col-3">
                    <h5>Email</h5>
                </div>
                <div class = "col-2">
                    <h5>Level</h5>
                </div>
                <div class = "col-1">
                    <h5>Role</h5>
                </div>
                <div class = "col-2">
                    <h5></h5>
                </div>
            </div>
        </li>
        <ul class = "list-group">
            @foreach($users as $user)
                <li class = "list-group-item">
                    <div  class = "row align-items-center">
                        <div class = "col-2">
                            <h6>{{$user->username}}</h6>
                        </div>
                        <div class = "col-2">
                            <h6>{{$user->name}}</h6>
                        </div>
                        <div class = "col-3">
                            <h6>{{$user->email}}</h6>
                        </div>
                        <div class = "col-2">
                            @if($user->level < 10) <h6>Basic-{!!$user->level!!}</h6>
                            @elseif($user->level < 20) <h6>Intermediate-{!!$user->level!!}</h6>
                            @else <h6>Advanced-{!!$user->level!!}</h6>
                            @endif
                        </div>
                        <div class = "col-1">
                            @if($user->authentication == -1) <h6>Unverified Member</h6>
                            @elseif($user->authentication == 0) <h6>Member</h6>
                            @elseif($user->authentication == 1) <h6>Lecturer</h6>
                            @else <h6>Admin</h6>
                            @endif
                        </div>
                        <div class = "col-2">
                            @if(Auth::user()->authentication > 1 || $user->authentication <= Auth::user()->authentication)
                            <div class = "row">
                                <div class = "col">
                                    <a href = "/users/{!!$user->id!!}/edit" class = "btn btn-primary">Edit</a>
                                </div>
                                @if(Auth::user()->id != $user->id)
                                    <div class = "col">
                                        {!!Form::open(['action' => ['UserController@destroy',$user->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                            {!!Form::hidden('_method','DELETE')!!}
                                            {!!Form::submit('Delete',['class' => 'btn btn-danger'])!!}
                                        {!!Form::close()!!}
                                    </div>
                                @endif
                            </div>
                            @endif

                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <br>
        <h2>There's Something Error :(</h2>
    @endif
@endsection