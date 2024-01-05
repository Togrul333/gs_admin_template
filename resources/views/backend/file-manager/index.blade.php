@extends('layouts.backend.master')
@section('title', trans('backend.titles.file_manager'))
@push('extrahead')
    <link rel="stylesheet" href="{{ asset('/backend/css/lightcase.min.css') }}">

    <style>
        .media_custom {
            display: block;
            text-align: center;
            position: relative;
            padding: 20px;
            background: #fff;
            border: 1px solid #e7e5ea;
            box-sizing: border-box;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .media_custom:hover {
            border-color: #3e4095;
            background-color: #e7e5ea;
            cursor: pointer;
        }

        .media_text {
            font-style: normal;
            color: #262626;
            height: 40px;
            overflow: hidden;
            font-size: 12px;
        }

        .date {
            font-style: normal;
            font-weight: 400;
            font-size: 12px;
            line-height: 28px;
            color: #808191;
            letter-spacing: -.36px;
            display: block;
        }

        .pagination_item {
            display: none !important;
        }

        .pagination_active {
            display: none !important;
        }
    </style>
@endpush
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom example example-compact">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            @if(isset($edit) && $edit == true)
                                <h3 class="card-label">file manager</h3>
                            @else
                                <h3 class="card-label">@lang("backend.titles.file_manager")</h3>
                            @endif
                        </div>

                        <div class="card-toolbar">
                            <form action="{{ route("backend.file_manager.upload_file") }}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    {{--                                @lang('backend.labels.image')--}}
                                </label>
                                <div class="w-100 d-flex gap-3 align-items-center">
                                    <div class="input-group mr-1">
                                        <div class="custom-file">
                                            <input type="file"
                                                   class="custom-file-input @error('image') is-invalid @enderror"
                                                   name="image[]" multiple="multiple" accept="image/*">
                                            <label class="custom-file-label">
                                                @lang('backend.placeholders.choose.image')
                                            </label>
                                        </div>
                                        @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success mr-2 text-nowrap">@lang('backend.buttons.create')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        @foreach($files as $file)
                            @include('backend.includes.file-manager-card',['model' => $file,'isDeleted' => true,])
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        @include('backend.includes.pagination',['items'=>$files])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {{--    <script>--}}
    {{--        $(document).on('click', '.pagination a', function (e) {--}}
    {{--            e.preventDefault();--}}
    {{--            var url = $(this).attr('href');--}}
    {{--            $.ajax({--}}
    {{--                url: url,--}}
    {{--                type: 'get',--}}
    {{--                dataType: 'json',--}}
    {{--                success: function (data) {--}}
    {{--                    var innerContent = $(data.view).find('.d-flex.align-items-center.gap-2.flex-wrap').html();--}}
    {{--                    $('.d-flex.align-items-center.gap-2.flex-wrap').html(innerContent);--}}
    {{--                    window.history.pushState("", "", url);--}}
    {{--                }--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}
@endsection
