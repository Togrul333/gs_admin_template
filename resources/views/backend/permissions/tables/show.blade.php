<div class="card-body col-md-10 offset-md-1 text-center mt-2">
<div class="table-responsive">
    <table class="table table-hover table-rounded border gy-7 gs-7">
            <tbody>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                <td class="table-row-title w-25">@lang('backend.labels.id')</td>
                <td class="table-center">{{ $permission->id }}</td>
            </tr>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                <td class="table-row-title w-25">@lang('backend.labels.name')</td>
                <td class="table-center">{{ $permission->name }}</td>
            </tr>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                <td class="table-row-title w-25">@lang('backend.labels.guard_name')</td>
                <td class="table-center">{{ $permission->guard_name }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
