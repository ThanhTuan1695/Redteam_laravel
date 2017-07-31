@extends('frontend.layouts.app')

@section('content')
    <div class="container1" style="margin-left:220px" >
        <form id="contact" action="{{ route('submitLogin') }}" method="post">
            <h3 style="text-align:center">Sign in</h3>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <fieldset>
                <input name="email" placeholder="Your Email Address" type="email">
            </fieldset>
            <fieldset>
                <input name="password" placeholder="Your Password" type="password">
            </fieldset>
            <fieldset>
                <button type="submit" class="btn btn-success my_btn">Login</button>
            </fieldset>
            <fieldset>
                <button type="button" class="btn btn-success my_btn" style="width:350px;">
                    <a href="{{ route('register_public') }}" style="color:white">Register</a>
                </button>
            <fieldset>
        </form>
    </div>
@endsection