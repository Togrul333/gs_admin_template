@extends('layouts.backend.master')
@section('title', trans('backend.titles.login'))
@section('styles')
    <link rel="stylesheet" href="{{asset('backend/css/sweetalert.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/login.css')}}">
@endsection
@section('content')
<div class="login login-5 login-signin-on d-flex flex-row-fluid" id="kt_login">
    <div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid">
        <div class="login-form text-center text-white p-7 position-relative overflow-hidden">
            <div class="d-flex flex-center mb-15">
                <img alt="logo" src="{{ asset('backend/img/gs.png') }}" class="max-h-100px">
            </div>
            <div class="login-signin">
                <div class="mb-20">
                    <h3 class="opacity-40"> {{ env('APP_NAME') }} </h3>
                    <p class="opacity-40">@lang('backend.login.desc')</p>
                </div>
                @include('backend.login.forms.login')
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{asset('backend/js/sweetalert.min.js')}}"></script>
@endsection
