@extends('frontend.layouts.master')
@section('header')
@include('frontend.includes.header')
@endsection
@section('content')
<main>
    @include('frontend.includes.nav')
    <section class="intro">
        <div class="container">
            <div class="intro_box">
                <div class="intro_left">
                    <img class="intro_img" src="{{asset('frontend/assets/images/user.svg')}}" alt="help" />
                </div>
                <p class="intro_right">@lang('frontend.registration')</p>
            </div>
        </div>
    </section>
    <section class="register_page">
        <div class="container">
            <div class="register_page_box">
                <div class="register_page_left">
                    <h2 class="register_page_title">@lang('frontend.registration_with_key')</h2>
                    <p class="register_text">
                        @lang('frontend.registration_text')
                    </p>
                    <form class="register_form">
                        <div class="register_form_input_box register_form_input_box_100_basis">
                            <input class="register_form_input full_name" type="text" name="full_name" placeholder="@lang('frontend.reg_name')" />
                            <span class="input-error error-full_name"></span>
                        </div>
                        <div class="register_form_input_box ">
                            <input class="register_form_input email" type="email" name="email" placeholder="@lang('frontend.reg_email')" />
                            <span class="input-error error-email"></span>
                        </div>
                        <div class="register_form_input_box">
                            <input class="register_form_input number" type="number" name="number" placeholder="@lang('frontend.reg_phone')" />
                            <span class="input-error error-number"></span>
                        </div>
                        <div class="register_form_input_box register_form_input_box_100_basis flex-direction-row">
                            <div class="password_container">
                                <input class="register_form_input password" type="password" name="password" placeholder="@lang('frontend.reg_password')" />
                                <span class="input-error error-password"></span>
                            </div>
                            <div class="repeat_password_container">
                                <input class="register_form_input password_confirmation" type="password" name="password_confirmation" placeholder="@lang('frontend.reg_paw_confirm')" />
                                <span class="input-error error-password_confirmation"></span>
                            </div>
                        </div>
                        <div class="loans">
                            @foreach($packages as $package)
                            <p class="loans-item package_i" data-package="{{$package->id}}">
                                <span> {{translation($package)->condition}}</span> <span class="subs_span">@lang('frontend.subscription')</span> <span>{{$package->price}} ₼</span>
                            </p>
                            @endforeach

                        </div>
                        <input class="register_submit" type="submit" data-url="{{route('frontend.register')}}" id="register_bnt" value="@lang('frontend.registration')" />
                    </form>
                </div>
                <div class="register_page_right">
                    <img src="{{asset('frontend/assets/images/register_bg.svg')}}" alt="register" />
                </div>
            </div>
        </div>
    </section>
    <section class="help_page" style="display: none">
        <div class="container">
            <div class="help_page_box">
                <h2 class="help_page_title">Uğurla <span>tamamlandı</span></h2>
                <div class="success_icon_box">
                    <div class="layer_first">
                        <div class="layer_second">
                            <div class="layer_third">
                                <div class="layer_fourth">
                                    <img
                                        src="{{asset('frontend/assets/images/confirm_icon.svg')}}"
                                        alt="confirm"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{route('frontend.dashboard')}}" class="help_page_link">Əsas səhifəyə qayıt</a>
            </div>
        </div>
    </section>
</main>
@endsection
@section('scripts')
<script src="{{asset('main/auth/register.js')}}"></script>
@endsection
