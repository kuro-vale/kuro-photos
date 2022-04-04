@extends('layouts.app')

@section('content')
<div class="container marketing">
    <div class="container-fluid mt-5 d-flex justify-content-between">
        <form class="d-flex w-75">
            <input class="form-control me-2" type="search" placeholder="Search" name="title" value="{{request()->get('title','')}}">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <a href="{{ route('photos.create') }}" class="btn btn-outline-success">Add New Photo</a>
    </div>

    @if(session('status'))
    <div class="alert alert-{{ session('alert-class') }} alert-dismissible fade show mt-2" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @foreach($photos as $key=>$photo)
    @if($key % 2 == 0)
    <hr class="featurette-divider mt-5">

    <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading">{{ $photo->title }}</h2>
            <p class="lead text-break">{{ $photo->description }}</p>
            <a href="{{ route('photos.show', $photo) }}#comments" class="btn btn-outline-primary">View Comments</a>
            <p class="text-muted mt-3 mb-0">
                <img src="{{ Storage::disk('google')->url($photo->user->avatar) }}" width="40px" style="border-radius: 50%;object-fit: cover;" height="40px" alt="Avatar of {{ $photo->user->username }}">
                &ndash;
                <a href="{{ route('users.photos', $photo->user) }}" class="link-dark">{{ $photo->user->username }}</a>
                &nbsp;
                {{ $photo->created_at->format('M d Y') }}
            </p>
        </div>
        <div class="col-md-5" data-bs-toggle="modal" data-bs-target="#modal{{ $photo->id }}">
            <img src="{{ Storage::disk('google')->url($photo->image) }}" class="img-fluid" alt="Photo by {{ $photo->user->name }}">
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal{{ $photo->id }}" tabindex="-1" aria-labelledby="photoModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModal">{{ $photo->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <img src="{{ Storage::disk('google')->url($photo->image) }}" class="img-fluid" alt="Photo by {{ $photo->user->name }}">
                </div>
            </div>
        </div>
    </div>
    @else
    <hr class="featurette-divider mt-5">

    <div class="row featurette">
        <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">{{ $photo->title }}</h2>
            <p class="lead text-break">{{ $photo->description }}</p>
            <a href="{{ route('photos.show', $photo) }}#comments" class="btn btn-outline-primary">View Comments</a>
            <p class="text-muted mt-3 mb-0">
                <img src="{{ Storage::disk('google')->url($photo->user->avatar) }}" width="40px" style="border-radius: 50%;object-fit: cover;" height="40px" alt="Avatar of {{ $photo->user->username }}">
                &ndash;
                <a href="{{ route('users.photos', $photo->user) }}" class="link-dark">{{ $photo->user->username }}</a>
                &nbsp;
                {{ $photo->created_at->format('M d Y') }}
            </p>
        </div>
        <div class="col-md-5 order-md-1" data-bs-toggle="modal" data-bs-target="#modal{{ $photo->id }}">
            <img src="{{ Storage::disk('google')->url($photo->image) }}" class="img-fluid" alt="Photo by {{ $photo->user->name }}">
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal{{ $photo->id }}" tabindex="-1" aria-labelledby="photoModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModal">{{ $photo->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <img src="{{ Storage::disk('google')->url($photo->image) }}" class="img-fluid" alt="Photo by {{ $photo->user->name }}">
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
    @if(count($photos) == 0)
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 85vh;">
        <h2>Nothing to see here.</h2>
    </div>
    @endif
    <hr class="featurette-divider mt-5">

    {{ $photos->appends(['title' => request()->get('title') ])->links('pagination::bootstrap-5') }}
</div>
@endsection