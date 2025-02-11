@extends('layouts.guest')
@section('title', 'Login|UMEME')
@section('content')

<section id="wrapper">
    <div class="login-register" >
        <div class="login-box card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                        <div class="social">
                            <img src="{{url('images/nsit-logo.png')}}" style="width: 160px" alt="homepage" class="light-logo" />
                           <h4 class="text-primary">UMEME</h4>
                        </div>
                    </div>
                    @include("layouts.messages")
                </div>
                <form class="form-horizontal form-material" id="loginform" method="POST" action="{{ route('user.login') }}">
                    @csrf
                    <h3 class="box-title m-b-20">Sign In</h3>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control border-2" type="email" id="emailaddress" value="{{old('email')}}" required="" placeholder="Enter your email" name="email" autofocus> </div>

                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" id="password" placeholder="Enter your password" name="password" required autocomplete="current-password"> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 font-14">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup"  name="remember" type="checkbox">
                                <label for="checkbox-signup"> Remember me </label>
                            </div>  
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button  class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>                 
                  
                </form>
                <form class="form-horizontal" id="recoverform" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" required="" placeholder="Email" name="email" :value="old('email')"> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Footer-->
{{-- <footer>
    <div class="col-md-12 text-center">
        <script>document.write(new Date().getFullYear())</script> © Makerere University Hospital (MUH)
    </div>
</footer> --}}
@endsection
