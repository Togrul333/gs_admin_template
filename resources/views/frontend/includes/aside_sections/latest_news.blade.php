<div class="writers_news_container_mobile latest_news_container">
    <div class="writers_news_header">
        <div class="writers_heading">
            <div class="line"></div>
            <h3>@lang('frontend.latest_news')</h3>
        </div>
        <a href="{{route('frontend.categoryNews',['category'=>category('news')])}}">@lang('frontend.see_all')
            <img src="{{asset('frontend/assets/images/arrowRight.png')}}" alt="arrow right" /></a>
    </div>
    <div class="writers_news_content">
        @foreach($fresh_news->take(3) as $news)
        @include('frontend.pages.news.news_aside_card')
        @endforeach

    </div>

    <a href="{{route('frontend.categoryNews',['category'=>category('news')])}}" class="view_all_btn">@lang('frontend.see_all')</a>
</div>
