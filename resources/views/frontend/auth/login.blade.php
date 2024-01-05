@extends('frontend.layouts.master_login')
@section('content')
    <div class="login_container">
        <div class="login_form">
            <h3>Giriş</h3>

            <div class="email_input">
                <input type="email" class="email" name="email" placeholder="Email və ya telefon"/>
            </div>
            <div class="password_input">
                <input type="password" class="password" name="password" placeholder="Şifrə"/>
            </div>

            <div class="login_btn login-btn"
                 data-url="{{route('frontend.login')}}">
                <button>Daxil Ol</button>
            </div>

            <div class="create_account">
                <p>Hesabın yoxdur?</p>
                <a href="{{route('frontend.register.form')}}">Qeydiyyatdan keç</a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{asset('main/auth/login.js')}}"></script>
@endsection

