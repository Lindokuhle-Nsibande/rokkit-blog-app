@extends('components.layout')
@section('page-title')
    <title>Rokkit Blogs | Login</title>
@endsection
@section('content')
    <section class="register-section">
        <div class="container">
            <div class="register-container">
                <div class="register-wrap">
                    <div class="company-logo-container">
                        <a href="/"><img src="{{ url('assets/img/icons-logos/rokkit-white.png') }}" class="img-fluid" alt=""></a>
                    </div>
                    <div class="login-register-form-container col-lg-8">
                        <form action="" name="registerUserForm" id="registerUserForm">
                            <div class="row m-0">
                                <div class="input-container col-lg-6">
                                    <input type="text"  name="name" id="name" placeholder="Name" required>
                                </div>
                                <div class="input-container col-lg-6">
                                    <input type="text"  name="surname" id="surname" placeholder="Surname" required>
                                </div>
                                <div class="input-container col-lg-6">
                                    <input type="email"  name="email" id="email" placeholder="Email" required>
                                </div>
                                <div class="input-container col-lg-6">
                                    <input type="text"  name="phone" id="phone" placeholder="Phone" required>
                                </div>
                                <div class="input-container col-lg-6">
                                    <input type="password"  name="password" id="password" placeholder="Password" required>
                                </div>
                                <div class="input-container col-lg-6">
                                    <input type="password"  name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                                </div>
                            </div>
                            <button class="theme-btn w-100">Register</button>
                            <span>Already have an account? <a href="/login">Login</a></span>
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
            $('#registerUserForm').on('submit', function(e){
                e.preventDefault();
                var form = document.forms.registerUserForm;
                registerUser(token, form);
            });
        });
    </script>
@endsection