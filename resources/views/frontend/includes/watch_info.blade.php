<div class="weather_info_and_watch">
    <div class=" swiper swiper_weather">
        <div class="swiper-wrapper" >
            <div class="swiper-slide">
                <div class="watch">
                    <p>
                        <span>{{ \Carbon\Carbon::now('Asia/Baku')->format('H') }}</span>
                        <span>:</span>
                        <span>{{ \Carbon\Carbon::now('Asia/Baku')->format('i') }}</span>
                    </p>
                </div>
                <div class="weather">
                    <img src="{{asset('frontend/assets/images/weathericon.png')}}" alt="weather icon" />
                    <p>
                        <span>{{weather()}}</span>
                        <span>°C</span>
                    </p>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="watch">
                    <p>
                        <span>$</span>
                        <span>USD</span>
                    </p>
                </div>
                <div class="weather">
                    <p>
{{--                        <span>{{array_key_exists('USD', currencies() ) ? currencies()['USD'] : 0.000}}</span>--}}
                        <span>{{currencies()['USD']}}</span>
                    </p>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="watch">
                    <p>
                        <span>€</span>
                        <span>EUR</span>
                    </p>
                </div>
                <div class="weather">
                    <p>
{{--                        <span>{{array_key_exists('EUR', currencies()) ? currencies()['EUR'] : 0.000}}</span>--}}
                        <span>{{currencies()['EUR']}}</span>
                    </p>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="watch">
                    <p>
                        <span>₺</span>
                        <span>TRY</span>
                    </p>
                </div>
                <div class="weather">
                    <p>
{{--                        <span>{{array_key_exists('TRY', currencies()) ? currencies()['TRY'] : 0.000}}</span>--}}
                        <span>{{currencies()['TRY']}}</span>

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
