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
                    <p class="intro_right">Xeta bash verdi</p>
                </div>
            </div>
        </section>
        <section class="not_found_main">
            <div class="container">
                <div class="not_found_main_box">
                    <div class="not_found_main_left">
                        <h2 class="not_found_main_left_title">Xeta bash verdi</h2>
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
