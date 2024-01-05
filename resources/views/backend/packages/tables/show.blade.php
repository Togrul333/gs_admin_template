<div class="card-body">
    <div class="table-responsive">
        <table class="table table-light table-light-success">
            <tbody>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">@lang('backend.labels.id')</td>
                    <td class="table-center">{{ $package->id }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">Type</td>
                    <td class="table-center">{{ $package->translation->type }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">Condition</td>
                    <td class="table-center">{{ $package->translation->condition }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">Description</td>
                    <td class="table-center">{{ $package->translation->description }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">
                        @lang('backend.labels.created_at')
                    </td>
                    <td class="table-center">{{ $package->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">
                        @lang('backend.labels.updated_at')
                    </td>
                    <td class="table-center">{{ $package->updated_at->format('d-m-Y H:i:s') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
