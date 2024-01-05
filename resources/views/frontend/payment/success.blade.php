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
                        <img
                            class="intro_img"
                            src="{{asset('frontend/assets/images/help.svg')}}"
                            alt="help"
                        />
                    </div>
                    <p class="intro_right">Dəstək</p>
                </div>
            </div>
        </section>
        <section class="help_page">
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
                    <a href="#" class="help_page_link">Əsas səhifəyə qayıt</a>
                </div>
            </div>
        </section>
    </main>
@endsection
