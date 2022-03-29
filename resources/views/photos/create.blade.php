@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload Photo</div>

                <div class="card-body">
                    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Photo</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label>Title *</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Description *</label>
                            <textarea name="description" rows="6" class="form-control" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-outline-primary my-2">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection