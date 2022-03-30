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
                            @if($errors->has('title'))
                            <input type="text" name="title" class="form-control is-invalid" value="{{ old('title') }}" required>
                            <div class="invalid-feedback">The title must be 1 to 80 characters.</div>
                            @else
                            <input type="text" name="title" class="form-control" value="{{ $photo->title }}" required>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Description *</label>
                            @if($errors->has('description'))
                            <textarea name="description" rows="6" class="form-control is-invalid" required>{{ old('description') }}</textarea>
                            <div class="invalid-feedback">The description must be 1 to 255 characters.</div>
                            @else
                            <textarea name="description" rows="6" class="form-control" required>{{ $photo->description }}</textarea>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-outline-primary my-2">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection