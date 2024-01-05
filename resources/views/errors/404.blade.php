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
                        <p class="intro_text">404</p>
                    </div>
                    <p class="intro_right">Səhifə tapılmadı</p>
                </div>
            </div>
        </section>
        <section class="not_found_main">
            <div class="container">
                <div class="not_found_main_box">
                    <div class="not_found_main_left">
                        <h2 class="not_found_main_left_title">Səhifə <span>tapılmadı</span></h2>
                        <p class="not_found_main_left_text">Axtardığınız səhifə mövcud deyil</p>
                        <a href="{{route("frontend.dashboard")}}" class="not_found_main_left_link">Əsas səhifəyə qayıt</a>
                    </div>
                    <div class="not_found_main_right">
                        <img src="{{asset('frontend/assets/images/404_bg.svg')}}" alt="404_bg">
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
