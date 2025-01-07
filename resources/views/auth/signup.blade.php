@extends('layouts.app')

@section('content')
 @auth
<script>window.location = "{{ url('/dashboard') }}";</script>
@else
<h1>Signup</h1>
<form method="POST" action="{{ route('signup') }}">
    @csrf
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
    <button type="submit" class="btn btn-primary"><i class="fa fa-user-plus"></i> Signup</button>
</form>
<p>Has existing account? <a href="{{ route('login') }}">Login</a></p>

@endauth
@endsection
