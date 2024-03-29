@extends('layouts.origin')
@section('title', "Login")
@section('content')
<h1>Login Form</h1>
<form name="loginform" action="/auth/login" method="POST">
    {{ csrf_field() }}
    MailAddress: <input type="text" name="email" size="30" value="{{old('email')}}"><br>
    Password: <input type="password" name="password" size="30"><br>
    <button type="submit" name="action" value="send">Login!</button>
</form>
<a href="/auth/github">GitHubでログイン</a>
@endsection