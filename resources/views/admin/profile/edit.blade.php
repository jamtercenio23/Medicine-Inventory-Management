@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Profile</h3>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="{{ $user->name }}"
                                    class="form-control" placeholder="Enter the Name">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="{{ $user->email }}"
                                    class="form-control" placeholder="Enter the Email">
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control">
                                    @if (auth()->user()->hasRole('admin'))
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="{{ auth()->user()->getRoleNames()->first() }}" selected>
                                            {{ auth()->user()->getRoleNames()->first() }}
                                        </option>
                                    @endif
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
                        </form>

                        <hr>

                        <form action="{{ route('profile.updatePassword') }}" method="POST" id="update-password-form">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Leave empty to keep the current password">
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Leave empty to keep the current password">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i id="password-toggle-icon" class="fas fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="Leave empty to keep the current password">
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to toggle password visibility
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text'; // Show the password
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password'; // Hide the password
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility when the eye icon is clicked
            const passwordToggleIcon = document.getElementById('password-toggle-icon');
            passwordToggleIcon.addEventListener('click', function() {
                togglePasswordVisibility('password', 'password-toggle-icon');
            });

            // Check for password matching errors
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const updatePasswordForm = document.getElementById('update-password-form');
            updatePasswordForm.addEventListener('submit', function(event) {
                if (passwordInput.value !== confirmPasswordInput.value) {
                    event.preventDefault(); // Prevent form submission
                    alert('New Password and Confirm New Password must match.');
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .card {
        border: 1px solid #ccc;
        border-radius: 10px;
    }
    </style>
@endsection
