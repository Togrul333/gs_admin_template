<aside>
    <div class="aside_wrapper">
        <div class="video_news_container">
            <div class="video_news_header">
                <div class="video_heading">
                    <div class="line"></div>
                    <h3>@lang('frontend.video')</h3>
                </div>
                <a href="{{route('frontend.optionPage',['option'=>'video'])}}"
                >@lang('frontend.see_all')
                    <img src="{{asset('frontend/assets/images/arrowRight.png')}}" alt="arrow right"
                    /></a>
            </div>

            <div class="video_news_content">
                <a href="{{route('frontend.news.detail',['category'=>$video_news->categories->first()->slug,'slug'=>$video_news->slug])}}">
                    <button class="play_btn">
                        <img src="{{asset('frontend/assets/images/playicon.png')}}" alt="play icon">
                    </button>
                    <h3>

                        {{translation($video_news)?->title}}
                    </h3>
                    <p><span> @lang('frontend.editor_s_choice')</span>
                        <span>{{\Illuminate\Support\Carbon::parse($video_news?->action_date)->format('m/d/Y')}}</span>
                    </p>

                </a>
            </div>

            {{--            <div class="video_news_content">--}}
            {{--                <button class="play_btn">--}}
            {{--                    <iframe width="560" height="315"--}}
            {{--                            src="https://www.youtube.com/embed/OOtxXPaQvoM?si=eUnVQWtrtzvO50f9" --}}
            {{--                            title="YouTube video player" frameborder="0"--}}
            {{--                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; --}}
            {{--                            picture-in-picture; web-share" allowfullscreen></iframe>--}}

            {{--                    <img src="{{$video_news->main_photo}}" alt="play icon" />--}}
            {{--                </button>--}}
            {{--                <h3>--}}
            {{--                    {{translation($video_news)?->title}}--}}
            {{--                </h3>--}}
            {{--                <p><span>Redaktorun seçimi</span> <span>{{\Illuminate\Support\Carbon::parse($video_news?->action_date)->format('m/d/Y')}}</span></p>--}}
            {{--            </div>--}}
        </div>

        @include('frontend.includes.aside_sections.latest_news')

        @include('frontend.includes.aside_sections.writers')
        @include('frontend.includes.aside_sections.top_10')
    </div>
</aside>
