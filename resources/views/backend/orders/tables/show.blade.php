<div class="card-body">
    <div class="table-responsive">
        <table class="table table-light table-light-success">
            <tbody>
            <tr class="bg-gray-100">
                <td class="table-row-title w-25">@lang('backend.labels.id')</td>
                <td class="table-center">{{ $order->id }}</td>
            </tr>
            <tr class="bg-gray-100">
                <td class="table-row-title w-25">ip address</td>
                <td class="table-center">{{ $order->ip_address }}</td>
            </tr>
            <tr class="bg-gray-100">
                <td class="table-row-title w-25">Total amount</td>
                <td class="table-center">{{ $order->total_amount }}</td>
            </tr>

            <tr class="bg-gray-100">
                <td class="table-row-title w-25">User</td>
                <td class="table-center">{{ $order->user?->fullname }}</td>
            </tr>

            <tr class="bg-gray-100">
                <td class="table-row-title w-25">status</td>
                <td class="table-center">
                    @switch($order->order_status_id)
                        @case(1)
                            PENDING
                            @break

                        @case(2)
                            APPROVED
                            @break

                        @case(3)
                            CANCELLED
                            @break

                        @case(4)
                            FAILED
                            @break

                        @default

                    @endswitch
                </td>
            </tr>

            <tr class="bg-gray-100">
                <td class="table-row-title w-25">
                    @lang('backend.labels.created_at')
                </td>
                <td class="table-center">{{ $order->created_at->format('d-m-Y H:i:s') }}</td>
            </tr>
            <tr class="bg-gray-100">
                <td class="table-row-title w-25">
                    @lang('backend.labels.updated_at')
                </td>
                <td class="table-center">{{ $order->updated_at->format('d-m-Y H:i:s') }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
