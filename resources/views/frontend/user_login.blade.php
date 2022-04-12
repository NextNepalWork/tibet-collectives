@extends('frontend.layouts.app')
@section('content')
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a>
                    <a href="{{route('user.login')}}"><span>Login</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="register-login-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="login-form">
                    <h2>Login</h2>
                    <form action="{{ route('login') }}" method="POST" role="form">
                        @csrf
                        <div class="group-input">
                            <label for="username">Email address *</label>
                            <input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Enter Email" value="{{ old('email') }}" name="email" id="email">

                        </div>
                        <div class="group-input">
                            <label for="pass">Password *</label>
                            <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter Password" name="password" id="password">

                        </div>
                        <div class="group-input gi-check">
                            <div class="gi-more">
                                <a class="forget-pass" href="{{ route('password.request') }}">Forget password?</a>

                            </div>
                        </div>
                        <button type="submit" class="site-btn login-btn">Login</button>

                    </form>
                    <div class="switch-login">
                        <a href="{{ route('user.registration') }}" class="or-login">Or Create An Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">
        function autoFillSeller(){
            $('#email').val('seller@example.com');
            $('#password').val('123456');
        }
        function autoFillCustomer(){
            $('#email').val('customer@example.com');
            $('#password').val('123456');
        }
    </script>
@endsection