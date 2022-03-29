@extends('layouts.app')

@section('content')
<div class="container marketing">
    <div class="container-fluid mt-5 d-flex justify-content-between">
        <!-- <form class="d-flex w-75">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form> -->
        <a href="{{ route('photos.create') }}" class="btn btn-outline-success">Add New Photo</a>
    </div>
    @foreach($photos as $key=>$photo)
    @if($key % 2 == 0)
    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading">{{ $photo->title }}</h2>
            <p class="lead">{{ $photo->description }}</p>
        </div>
        <div class="col-md-5">
            <img src="{{ Storage::url($photo->image) }}" class="img-fluid" alt="Photo of {{ $photo->user->name }}">
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
            <img src="{{ Storage::url($photo->image) }}" class="img-fluid" alt="Photo of {{ $photo->user->name }}">
        </div>
    </div>
    @endif
    @endforeach
    @if(count($photos) == 0)
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 85vh;">
        <h2>Nothing to see here.</h2>
    </div>
    @endif
</div>
@endsection