@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User Settings') }}</div>

                <div class="card-body">
                    @if(session('status'))
                    <div class="alert alert-{{ session('alert-class') }} alert-dismissible fade show mt-2" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('users.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="avatar" class="col-md-4 col-form-label text-md-end">{{ __('Avatar') }}</label>

                            <div class="col-md-6">
                                <img src="{{ Storage::disk('google')->url($user->avatar) }}" width="140px" style="border-radius: 50%;object-fit: cover;" height="140px" class="my-2" alt="Avatar of {{ $user->username }}">
                                <div class="input-group">
                                    <label class="input-group-text">Change Avatar</label>
                                    <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar" accept="image/*">
                                </div>

                                @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="@error('name'){{ old('name') }}@else{{ $user->name }}@enderror" required autocomplete="name">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="@error('username'){{ old('username') }}@else{{ $user->username }}@enderror" required autocomplete="username">

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-outline-primary">
                                    {{ __('Update Settings') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-end">
                        <form method="POST" action="{{ route('users.destroy') }}">
                            @csrf
                            @method('delete')

                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#destroyUserModal">Delete user</button>
                            <!-- Modal -->
                            <div class="modal fade" id="destroyUserModal" tabindex="-1" aria-labelledby="destroyUserModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="destroyUserModalLabel">Are you sure?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            If you delete your user all your photos will be lost.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-outline-danger">Delete user</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection