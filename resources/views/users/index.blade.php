@extends('layouts.app')

@section('content')
<div class="container marketing">
    <hr class="featurette-divider">
    <div class="row">
        @foreach($users as $user)
        <div class="col-lg-4">
            <img src="{{ Storage::url($user->avatar) }}" width="140px" style="border-radius: 50%;" height="140px" alt="Avatar of {{ $user->username }}">

            <h2>{{ $user->username }}</h2>
            <p><a class="btn btn-secondary" href="#">View Photos &raquo;</a></p>
        </div>
        @endforeach
    </div>
    <hr class="featurette-divider">
</div>
@endsection