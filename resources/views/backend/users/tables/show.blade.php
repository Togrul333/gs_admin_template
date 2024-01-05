<div class="card-body">
    <div class="table-responsive">
        <table class="table table-light table-light-success">
            <tbody>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">@lang('backend.labels.id')</td>
                    <td class="table-center">{{ $user->id }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">@lang('backend.labels.fullname')</td>
                    <td class="table-center">{{ $user->full_name }}</td>
                </tr>

                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">@lang('backend.labels.email')</td>
                    <td class="table-center">{{ $user->email }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">@lang('backend.labels.phone_number')</td>
                    <td class="table-center">+{{ optional($user->info)->phone ?? '' }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">@lang('backend.labels.address')</td>
                    <td class="table-center">{{ optional($user->info)->address ?? '' }}</td>
                </tr>

                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">
                        @lang('backend.labels.birthdate')
                    </td>
                    <td class="table-center">{{ optional(optional($user->info)->birthdate)->format('d-m-Y') ?? '' }}</td>
                </tr>

                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">@lang('backend.labels.status')</td>
                    <td class="table-center">{!! badge($user->status) !!}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">
                        @lang('backend.labels.created_at')
                    </td>
                    <td class="table-center">{{ $user->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>

                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">
                        @lang('backend.labels.updated_at')
                    </td>
                    <td class="table-center">{{ $user->updated_at->format('d-m-Y H:i:s') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
