@extends('layouts.app')

@section('content')
@auth
<script>window.location = "{{ url('/dashboard') }}";</script>
@else

<h1>Login</h1>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Login </button>
</form>
<p>No account? <a href="{{ route('signup') }}">Sign up</a></p>

@endauth

@endsection
