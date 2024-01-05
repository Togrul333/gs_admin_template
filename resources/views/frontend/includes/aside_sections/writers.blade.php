<div class="writers_news_container">
    <div class="writers_news_header">
        <div class="writers_heading">
            <div class="line"></div>
            <h3>@lang('frontend.writers')</h3>
        </div>
        <a href="{{route('frontend.writers')}}"
        >@lang('frontend.see_all')
            <img src="{{asset('frontend/assets/images/arrowRight.png')}}" alt="arrow right"
            /></a>
    </div>
    <div class="writers_news_content">
        @foreach($writers->take(3) as $writer)
            <div class="partition"></div>
            <a href="{{route('frontend.writerWritings',['writer'=>$writer])}}" class="writers_news_item">
                <div class="left">
                    <img src="{{$writer->main_photo}}" alt=""/>
                </div>
                <div class="right">
                    <h3>
                        {{$writer->name}}
                    </h3>
                    <div class="right_bottom">
                        <figure class="author_name">{{$writer->role}}</figure>
{{--                        <p><span>{{\Illuminate\Support\Carbon::parse($news->action_date)->format('m/d/Y')}}</span>--}}
{{--                            <span> {{\Illuminate\Support\Carbon::parse($news->action_date)->format('H:i')}}</span></p>--}}
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
