@extends('layouts.app')

@section('content')
<div class="container marketing">
    <div class="container-fluid mt-5">
        <form class="d-flex w-85">
            <input class="form-control me-2" type="search" placeholder="Search User" name="username" value="{{request()->get('username','')}}">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>

    @if(session('status'))
    <div class="alert alert-{{ session('alert-class') }} alert-dismissible fade show mt-2" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <hr class="featurette-divider mt-5">
    <div class="row">
        @foreach($users as $user)
        <div class="col-lg-4">
            <img src="{{ Storage::disk('google')->url($user->avatar) }}" width="140px" style="border-radius: 50%;object-fit: cover;" height="140px" alt="Avatar of {{ $user->username }}">

            <h2>{{ $user->username }}</h2>
            <p><a class="btn btn-secondary" href="{{ route('users.photos', $user) }}">View Photos &raquo;</a></p>
        </div>
        @endforeach
    </div>
    <hr class="featurette-divider">

    {{ $users->appends(['username' => request()->get('username') ])->links('pagination::bootstrap-5') }}
</div>
@endsection