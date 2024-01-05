<nav class="container">
    <div class="nav_wrapper">
        <div class="links">
            @foreach($categories_menu  as $category_menu)
                <a href="{{route('frontend.categoryNews',['category'=>$category_menu])}}"
                   class="{{ url()->current() ==  route('frontend.categoryNews',['category'=>$category_menu]) ? 'active' : '' }}"
                > {{ translation($category_menu)->name}}</a>
            @endforeach
        </div>
        @include('frontend.includes.watch_info')
    </div>
</nav>
