@extends('layouts.app')
@section('content')
    <div class="login-right">
        <div class="login-right-wrap">
        
            <h1>Selamat Datang di</h1>
            <h2>Sistem Informasi Dosen TE</h2>
            <form action="{{ route('login') }}" method="POST">
				@csrf
                @include('layouts.alert-flash-message')
                <div class="form-group">
                    <label>Email<span class="login-danger">*</span></label>
                    <input type="email" class="form-control email" name="email">
                    <span class="profile-views"><i class="fas fa-envelope"></i></span>
                </div>
                <div class="form-group">
                    <label>Password <span class="login-danger">*</span></label>
                    <input type="password" class="form-control pass-input password" name="password">
                    <span class="profile-views feather-eye toggle-password"></span>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection
