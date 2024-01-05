<div class="main_news">
    <div class="left">
        <div class="slider_container swiper mySwiper" pagination="true">
            <div class="swiper-wrapper">
                @foreach($main_news->take(3) as $news)
                    @include('frontend.pages.news.news_slider_card')
                @endforeach
            </div>

            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="right">
        <div class="wrapper">
            @foreach($main_news->slice(3, 4) as $news)
                <a href="{{route('frontend.news.detail',['category'=>$news->categories->first()->slug,'slug'=>$news->slug])}}" class="news_item">

                <img src="{{$news->main_photo}}" alt="main banner">
                    <h4>
                    {{\Illuminate\Support\Str::limit(translation($news)->title,200)}}
                    </h4>
                    <p><span>@lang('frontend.research')</span> <span>{{\Illuminate\Support\Carbon::parse($news->action_date)->format('m/d/Y')}}</span></p>
                </a>
            @endforeach
        </div>
    </div>
</div>
