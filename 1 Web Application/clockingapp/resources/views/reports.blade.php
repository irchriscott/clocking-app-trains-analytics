@extends('layouts.app')

@section('content')
<div class="cl-container-table">
    @include('layouts.messages')
    <div class="cl-report-users">
        <h2>Users</h2>
        @if(count($users) > 0)
            <ul class="list-group" id="cl-users-list">
                @foreach($users as $user)
                    <li class="list-group-item" data-url="{{route('user.reports', $user->id)}}">
                        <h3>{{$user->name}}</h3>
                        <p>{{$user->email}}</p>
                    </li>
                @endforeach
            </ul>
        @else
        @endif
    </div>
    <div class="cl-report-list" id="cl-reports-container">
        <span class="cl-loading-spinner" id="cl-loading-spinner">
            <img src="{{asset('img/loading.gif')}}" alt="Loading Spinner" />
        </span>
    </div>
</div>
@endsection