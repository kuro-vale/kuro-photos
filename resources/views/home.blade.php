@extends('layouts.app')

@section('content')
<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ Storage::disk('google')->url('photos/stones.jpg') }}" class="img-fluid" style="object-fit: cover; object-position: right;">

            <div class="container">
                <div class="carousel-caption text-start">
                    @guest
                    <h1>Join now.</h1>
                    <p>Is free.</p>
                    <p><a class="btn btn-lg btn-primary" href="{{ route('register') }}">Sign up today</a></p>
                    @else
                    <h1>Welcome {{ Auth::user()->username }}.</h1>
                    <p>You are the best!.</p>
                    <p><a class="btn btn-lg btn-primary" href="{{ route('users.dashboard') }}">Your Dashboard</a></p>
                    @endguest
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ Storage::disk('google')->url('photos/cat.jpg') }}" class="img-fluid" style="object-fit: cover; object-position: top;">

            <div class="container">
                <div class="carousel-caption">
                    <h1>See what others are sharing.</h1>
                    <p>Inspire yourself.</p>
                    <p><a class="btn btn-lg btn-primary" href="{{ route('photos.index') }}">View Photos</a></p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ Storage::disk('google')->url('photos/women.jpg') }}" class="img-fluid" style="object-fit: cover; object-position: top;">

            <div class="container">
                <div class="carousel-caption text-end">
                    <h1>People around the world.</h1>
                    <p>Sharing their art.</p>
                    <p><a class="btn btn-lg btn-primary" href="{{ route('users.index') }}">View Users</a></p>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<footer class="container">
    <p>2022 &middot; kurovale &middot; <a href="https://github.com/kuro-vale" target="_blank">Github</a></p>
</footer>
@endsection