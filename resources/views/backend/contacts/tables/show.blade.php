<div class="card-body">
    <div class="table-responsive">
        <table class="table table-light table-light-success">
            <tbody>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">@lang('backend.labels.id')</td>
                    <td class="table-center">{{ $contact->id }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">name</td>
                    <td class="table-center">{{ $contact->fullName }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">email</td>
                    <td class="table-center">{{ $contact->email }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">subject</td>
                    <td class="table-center">{{ $contact->subject }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">
                        @lang('backend.labels.created_at')
                    </td>
                    <td class="table-center">{{ $contact->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">
                        @lang('backend.labels.updated_at')
                    </td>
                    <td class="table-center">{{ $contact->updated_at->format('d-m-Y H:i:s') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
