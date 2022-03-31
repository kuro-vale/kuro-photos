@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Photo Info</div>

                <div class="card-body">
                    <form action="{{ route('photos.update', $photo) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Title *</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="@error('title') {{ old('title') }} @else {{ $photo->title }}@enderror" required>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Description *</label>
                            <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror" required>@error('description') {{ old('description') }} @else {{ $photo->description }}@enderror</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-outline-primary my-2">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection