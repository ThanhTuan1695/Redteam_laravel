@extends('frontend.layouts.app')

@section('content')
    <div class="content">
        <div class="container">
            <form id="contact" action="{{ route('register_user') }}" method="post" enctype="multipart/form-data">
                @include('flash::message')
                @include('adminlte-templates::common.errors')
                <h3 style="text-align:center">Sign up</h3>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <fieldset>
                    <input name="username" placeholder="Your name" type="text" autofocus>
                </fieldset>
                <fieldset>
                    <input name="email" placeholder="Your Email Address" type="email">
                </fieldset>
                <fieldset>
                    <input name="password" placeholder="Your Password" type="password">
                </fieldset>
                <fieldset>
                    <input name="password_confirmation" placeholder="Password confirmation" type="password">
                </fieldset>
                <fieldset>
                    <input name="avatar" type="file">
                </fieldset>
                <fieldset>
                    <button type="submit" class="btn btn-success my_btn">Submit</button>
                </fieldset>
                <fieldset>
                    <a href="{{ route('loginChat') }}"><button type="button" class="btn btn-success my_btn">Login</button></a>
                </fieldset>
            </form>
        </div>
        </form>
    </div>
    </div>
@endsection