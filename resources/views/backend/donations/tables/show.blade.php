<div class="card-body">
    <div class="table-responsive">
        <table class="table table-light table-light-success">
            <tbody>
            <tr class="bg-gray-100">
                <td class="table-row-title w-25">@lang('backend.labels.id')</td>
                <td class="table-center">{{ $donation->id }}</td>
            </tr>
            <tr class="bg-gray-100">
                <td class="table-row-title w-25">ip address</td>
                <td class="table-center">{{ $donation->ip_address }}</td>
            </tr>
            <tr class="bg-gray-100">
                <td class="table-row-title w-25">Total amount</td>
                <td class="table-center">{{ $donation->total_amount }}</td>
            </tr>

            <tr class="bg-gray-100">
                <td class="table-row-title w-25">User</td>
                <td class="table-center">{{ $donation->user?->name }}</td>
            </tr>

            <tr class="bg-gray-100">
                <td class="table-row-title w-25">
                    @lang('backend.labels.created_at')
                </td>
                <td class="table-center">{{ $donation->created_at->format('d-m-Y H:i:s') }}</td>
            </tr>
            <tr class="bg-gray-100">
                <td class="table-row-title w-25">
                    @lang('backend.labels.updated_at')
                </td>
                <td class="table-center">{{ $donation->updated_at->format('d-m-Y H:i:s') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
