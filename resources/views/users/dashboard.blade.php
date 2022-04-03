@extends('layouts.app')

@section('content')
<div class="container marketing">
    <div class="d-flex justify-content-between align-items-end">
        <h2 class="featurette-heading">{{ $user->username }}'s Dashboard</h2>
        <img src="{{ Storage::url($user->avatar) }}" width="120px" style="border-radius: 50%;object-fit: cover;" height="120px" alt="Avatar of {{ $user->username }}" class="mt-4">
    </div>
    <div class="container-fluid mt-5 mb-3 d-flex justify-content-between">
        <form class="d-flex w-75">
            <input class="form-control me-2" type="search" placeholder="Search" name="title" value="{{request()->get('title','')}}">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <a href="{{ route('photos.create') }}" class="btn btn-outline-success">Add New Photo</a>
    </div>
    @if(count($photos) == 0)
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 85vh;">
        <h2>Nothing to see here.</h2>
    </div>
    @else
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Comments</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach($photos as $photo)
            <tr>
                <td onclick="window.location='{{ route('photos.show', $photo) }}';">{{ $photo->title }}</td>
                <td onclick="window.location='{{ route('photos.show', $photo) }}';" class="text-break">{{ $photo->description }}</td>
                <td onclick="window.location='{{ route('photos.show', $photo) }}';">{{ count($photo->comments) }}</td>
                <td><a class="btn btn-outline-primary btn-sm" href="{{ route('photos.edit', $photo) }}">Edit</a></td>
                <td>
                    <form action="{{ route('photos.destroy', $photo) }}" method="POST">
                        @csrf
                        @method('Delete')
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#destroyPhoto{{ $photo->id }}Modal">Delete</button>
                        <!-- Modal -->
                        <div class="modal fade" id="destroyPhoto{{ $photo->id }}Modal" tabindex="-1" aria-labelledby="destroyPhoto{{ $photo->id }}ModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="destroyPhoto{{ $photo->id }}ModalLabel">Are you sure?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Do you want to delete your photo? 🥺
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-outline-danger">Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection