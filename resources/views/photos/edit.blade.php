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
                            <input type="text" name="title" class="form-control" value="{{ $photo->title }}" required>
                        </div>

                        <div class="form-group">
                            <label>Description *</label>
                            <textarea name="description" rows="6" class="form-control" required>{{ $photo->description }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-outline-primary my-2">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection