@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-11">
            @if(session('status'))
            <div class="alert alert-{{ session('alert-class') }} alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card">
                <div class="card-header">{{ $photo->title }}</div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <img src="{{ Storage::disk('google')->url($photo->image) }}" class="img-fluid" alt="Photo by {{ $photo->user->name }}">
                    </div>
                    <h4 class="mb-2 mt-4">{{ $photo->description }}</h4>
                </div>
            </div>
            <div class="card mt-4" id="comments">
                <div class="card-header">Comments</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('comments.store', $photo) }}#bottom">
                        @csrf

                        <div class="input-group">
                            <span class="input-group-text">Add comment</span>
                            <textarea class="form-control @error('body') is-invalid @enderror" @guest placeholder="You need to login to comment" disabled @endguest aria-label="With textarea" name="body" style="height: 10px;">{{ old('body') }}</textarea>
                            @error('body')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <button type="submit" class="btn btn-outline-info btn-sm">Submit</button>
                        </div>
                    </form>

                    @foreach($photo->comments as $comment)
                    <div class="card mt-3" id="comment{{ $comment->id }}">
                        <div class="card-body">
                            <div class="d-flex mb-0">
                                <img src="{{ Storage::disk('google')->url($comment->user->avatar) }}" width="40px" style="border-radius: 50%;object-fit: cover;" height="40px" alt="Avatar of {{ $photo->user->username }}">
                                <div class="row my-0 mx-2">
                                    <p class="my-0"><a href="{{ route('users.photos', $comment->user) }}" class="link-dark">{{ $comment->user->username }}</a> says:</p>
                                    <p class="my-0">{{ $comment->body }}</p>
                                </div>
                                @if($comment->user == Auth::user())
                                <div class="btn-group ms-auto">
                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" data-bs-toggle="collapse" href="#collapse{{ $comment->id }}" role="button" aria-expanded="false" aria-controls="collapse{{ $comment->id }}">Edit</a></li>
                                        <li>
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#destroyComment{{ $comment->id }}Modal">Delete</button>
                                        </li>
                                    </ul>
                                </div>
                                <form action="{{ route('comments.destroy', [$photo, $comment]) }}" method="POST">
                                    @csrf
                                    @method('Delete')
                                    <!-- Modal -->
                                    <div class="modal fade" id="destroyComment{{ $comment->id }}Modal" tabindex="-1" aria-labelledby="destroyComment{{ $comment->id }}ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="destroyComment{{ $comment->id }}ModalLabel">Are you sure?</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Do you want to delete your comment?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-outline-danger">Yes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endif
                            </div>
                            @if($comment->user == Auth::user())
                            <!-- Collapse -->
                            <div class="collapse" id="collapse{{ $comment->id }}">
                                <div class="card card-body">
                                    <form method="POST" action="{{ route('comments.update', [$photo, $comment]) }}#comment{{ $comment->id }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="input-group input-group-sm">
                                            <textarea class="form-control @error('body') is-invalid @enderror" aria-label="With textarea" name="body" style="height: 10px;">{{ $comment->body }}</textarea>
                                            @error('body')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror

                                            <button type="submit" class="btn btn-outline-info btn-sm">Submit</button>
                                            <button type="button" class="btn-close ms-3" data-bs-toggle="collapse" href="#collapse{{ $comment->id }}" role="button" aria-expanded="false" aria-controls="collapse{{ $comment->id }}"></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div id="bottom"></div>
@endsection