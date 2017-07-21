@extends('frontend.layouts.app')

@section('content')
    <div class="content">
        <div class="container">
            <form id="contact" action="{{ route('submitLogin') }}" method="post">
                @include('flash::message')
                @include('adminlte-templates::common.errors')
                <h3 style="text-align:center">Sign in</h3>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <fieldset>
                    <input name="email" placeholder="Your Email Address" type="email">
                </fieldset>
                <fieldset>
                    <input name="password" placeholder="Your Password" type="password">
                </fieldset>
                <fieldset>
                    <button type="submit" class="btn btn-success my_btn">Submit</button>
                </fieldset>
            </form>
        </div>
        </form>
    </div>
    </div>
@endsection