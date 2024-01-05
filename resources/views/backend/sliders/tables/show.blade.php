<div class="card-body col-md-10 offset-md-1 text-center mt-2">
<div class="table-responsive">
    <table class="table table-hover table-rounded border gy-7 gs-7">
            <tbody>
                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                    <td class="table-row-title w-25">@lang('backend.labels.id')</td>
                    <td class="table-center">{{ $slider->id }}</td>
                </tr>

                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                    <td class="table-row-title w-25">Link</td>
                    <td class="table-center">{{ $slider->link }}</td>
                </tr>
                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                    <td class="table-row-title w-25">@lang('backend.labels.status')</td>
                    <td class="table-center">{!! badge($slider->status) !!}</td>
                </tr>

                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                    <td class="table-row-title w-25">name</td>
                    <td class="table-center">{{{$slider->translation->name}}}</td>
                </tr>

                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                    <td class="table-row-title w-25">text</td>
                    <td class="table-center">{{{$slider->translation->text}}}</td>
                </tr>

                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                    <td class="table-row-title w-25">
                        @lang('backend.labels.created_at')
                    </td>
                    <td class="table-center">{{ $slider->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>

                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                    <td class="table-row-title w-25">
                        @lang('backend.labels.updated_at')
                    </td>
                    <td class="table-center">{{ $slider->updated_at->format('d-m-Y H:i:s') }}</td>
                </tr>

            </tbody>
    </table>
</div>
    @include('backend.includes.media',[
                        'model' => $slider,
                        'name'  => 'slider',
                        'media_collection_name'  => 'slider_image',
                        'isDeleted' => false,
                        'isCovered' => false,
                    ])
</div>
