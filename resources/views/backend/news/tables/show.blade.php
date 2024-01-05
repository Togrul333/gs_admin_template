<div class="card-body">
    <div class="table-responsive">
        <table class="table table-light table-light-success">
            <tbody>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">@lang('backend.labels.id')</td>
                    <td class="table-center">{{ $news->id }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">Title</td>
                    <td class="table-center">{{ $news->translation->title }}</td>
                </tr>

                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">Description</td>
                    <td class="table-center">{{ $news->translation->description }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">
                        @lang('backend.labels.created_at')
                    </td>
                    <td class="table-center">{{ $news->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="table-row-title w-25">
                        @lang('backend.labels.updated_at')
                    </td>
                    <td class="table-center">{{ $news->updated_at->format('d-m-Y H:i:s') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @include('backend.includes.media',[
                'model' => $news,
                'name'  => 'news',
                'media_collection_name'  => 'news',
                'isDeleted' => false,
                'isCovered' => false,
            ])
</div>
