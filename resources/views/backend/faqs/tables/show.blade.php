<div class="card-body">
    <div class="table-responsive">
        <table class="table table-light table-light-success">
            <tbody>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">@lang('backend.labels.id')</td>
                    <td class="table-center">{{ $faq->id }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">Question</td>
                    <td class="table-center">{{ $faq->translation->question }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">Answer</td>
                    <td class="table-center">{{ $faq->translation->answer }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">
                        @lang('backend.labels.created_at')
                    </td>
                    <td class="table-center">{{ $faq->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">
                        @lang('backend.labels.updated_at')
                    </td>
                    <td class="table-center">{{ $faq->updated_at->format('d-m-Y H:i:s') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
