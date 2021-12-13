@extends('layouts.app')



@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>{{$user->email}}</h2>
            <h3>{{$user->name}}</h3>
            @if ($user->getPendingFriendships())
            <form method="post" action="{{route('user.acceptrequest')}}">
                @csrf
                         <button class="btn btn-primary my-4">Accept request</button>
                </form>
            @endif
        </div>
    </div>
</div>

@endsection
