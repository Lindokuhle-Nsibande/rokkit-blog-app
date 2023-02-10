@extends('components.layout')
@section('page-title')
    <title>Rokkit Blogs | Login</title>
@endsection
@section('content')
    <section class="login-section">
        <div class="container">
            <div class="login-container">
                <div class="login-wrap">
                    <div class="company-logo-container">
                        <a href="/"><img src="{{ url('assets/img/icons-logos/rokkit-white.png') }}" class="img-fluid" alt=""></a>
                    </div>
                    <div class="login-register-form-container col-lg-6">
                        <form action="" id="userLoginForm" name="userLoginForm">
                            <div class="input-container">
                                <input type="email"  name="email" id="email" placeholder="Email" required>
                            </div>
                            <div class="input-container">
                                <input type="password"  name="password" id="password" placeholder="Password" required>
                            </div>
                            <span class="forget-password"><a href="">Forget Password?</a></span>
                            <button class="theme-btn w-100">Login</button>
                            <span>Don't have an account? <a href="/register">Register</a></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(function () {
            var token = $('meta[name="csrf-token"]').attr('content');
            $('#userLoginForm').on('submit', function(e){
                e.preventDefault();
                var form = document.forms.userLoginForm;
                userLogin(token, form);
            });
        });
    </script>
@endsection