@extends('layouts.app')

@section('content')
<div class="container marketing">
    @foreach($photos as $key=>$photo)
    @if($key % 2 == 0)
    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading">{{ $photo->title }}</h2>
            <p class="lead">{{ $photo->description }}</p>
        </div>
        <div class="col-md-5">
            <img src="{{ $photo->image }}" class="img-fluid" alt="Photo of {{ $photo->user->name }}">
        </div>
    </div>
    @else
    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">{{ $photo->title }}</h2>
            <p class="lead">{{ $photo->description }}</p>
        </div>
        <div class="col-md-5 order-md-1">
            <img src="{{ $photo->image }}" class="img-fluid" alt="Photo of {{ $photo->user->name }}">
        </div>
    </div>
    @endif
    @endforeach
</div>
@endsection