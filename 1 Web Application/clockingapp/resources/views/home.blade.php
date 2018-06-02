@extends('layouts.app')

@section('content')
@section('content')
    <div class="cl-home">
        <div class="cl-home-container">
            <div class="cl-home-messages">
            @include('layouts.messages')
            </div>
            <h1>{{date('H:i', time())}} Hrs</h1>
            <h3>{{date('D j/M/y', time())}}</h3>
            <form method="POST" action="{{route('checkin')}}">
                @csrf
                @if(Auth::user()->last())
                    @if(Auth::user()->last()->status == 2)
                        <button type="submit">Time In</button>
                    @else
                        <button type="submit" class="cl-danger">Time Out</button>
                    @endif
                @else
                    <button type="submit">Time In</button>
                @endif
            </form>
        </div>
    </div>
@endsection
