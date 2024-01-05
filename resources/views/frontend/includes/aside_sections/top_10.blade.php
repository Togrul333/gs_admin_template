<div class="top_10">
    <div class="top_10_header">
        <div class="top_10_heading">
            <div class="line"></div>
            <h3>@lang('frontend.top_10')</h3>
        </div>
{{--        <a href="{{route('frontend.optionPage',['option'=>$top_10_news->first()->options->first()->id])}}">@lang('frontend.see_all')--}}
{{--            <img src="{{asset('frontend/assets/images/arrowRight.png')}}" alt="arrow right"--}}
{{--            /></a>--}}
    </div>
    <div class="top_10_content">
        @php $num_img = 0 @endphp
        @foreach($top_10_news as $top_10_news_item)
            @php $num_img++ @endphp
            <a href="{{route('frontend.news.detail',['category'=>$top_10_news_item ->categories->first()->slug,'slug'=>$top_10_news_item->slug])}}" class="top_10_item">
                <img src="{{asset('frontend/assets/images/'. $num_img .'.png')}}" alt=""/>
                <h3>
                    {{translation($top_10_news_item)->title}}
                </h3>
                <div class="top_10_bottom">
                    <p>@lang('frontend.research')</p>
                    <p>
                        <span>{{\Illuminate\Support\Carbon::parse($top_10_news_item->action_date)->format('m/d/Y')}}</span>
                        <span> {{\Illuminate\Support\Carbon::parse($top_10_news_item->action_date)->format('H:i')}}</span>
                    </p>
                </div>
            </a>
            <div class="partition"></div>
        @endforeach
    </div>
</div>
