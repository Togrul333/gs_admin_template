<div class="card-header flex-wrap py-5">
    <div class="card-title">
        <h3 class="card-label">@lang("backend.titles.$page")</h3>
    </div>
{{--    @can("$page create")--}}
        <div class="card-toolbar">
            <a href="{{ route("backend.$page.create") }}" class="btn btn-primary font-weight-bolder">
                <i class="la la-plus"></i> @lang('backend.buttons.create')
            </a>
        </div>
{{--    @endcan--}}
</div>
