@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
            <div class="card-header">{{ $photo->title }}</div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <img src="{{ Storage::url($photo->image) }}" class="img-fluid" alt="Photo of {{ $photo->user->name }}">
                    </div>
                    <h4 class="my-2">{{ $photo->description }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection