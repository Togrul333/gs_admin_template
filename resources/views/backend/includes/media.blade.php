@if($model->files->count() > 0)
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
        </style>
    @endpush
    <div class="row">
        <h2 class="text-center w-100 mb-10">
            @lang('backend.labels.images')
        </h2>
        @foreach($model->files as $image)
            <div class="mr-3">
                <div class="media media_custom">
                    <a class="gal-item showcase" data-rel="lightcase:myCollection:slideshow"
                       title="" href="{{ $image->document }}">
                        <figure>
                            <img style="width:100px; height:80px" class="img-fluid" alt=""
                                 src="{{ $image->document }}">
                        </figure>
                    </a>
                    <div class="media-body mt-2">
                        @if($image->status == 'main')
                            main image
                        @else
                            @if(isset($isMain) && $isMain)
                                <button type="button" data-id="{{ $image->id }}"
                                        class="btn btn-primary btn-block mb-1 domain">
                                    set main image
                                </button>
                            @endif
                        @endif
                        @if(isset($isDeleted) && $isDeleted)
                            <button type="button" data-id="{{ $image->id }}"
                                    class="btn btn-primary btn-block mb-1 dodelete">
                                Sil
                            </button>
                        @endif
                            <hr>
                           alt : {{ $image->alt }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @push('extrascripts')
        <script src="{{ asset('/backend/js/lightcase.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                let showcase = $('a.showcase'),
                    dodelete = $('.dodelete'),
                    domain = $('.domain');

                showcase.lightcase({
                    transition: 'scrollHorizontal',
                    showSequenceInfo: false,
                    showTitle: false
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

                domain.click(function (e) {
                    e.preventDefault();

                    {!! confirm_update() !!}.then((result) => {
                        if (result.isConfirmed) {
                            let id = $(this).data('id');
                            $.ajax({
                                type: 'post',
                                url: '/admin/documents/' + id + '/set-status',
                                data: {'id': id,},
                                dataType: 'json',
                                success: function (result) {
                                    if (result.status != 1) {
                                        {!! notify('error', trans('backend.messages.error.update')) !!}
                                    } else {
                                        {!! notify('success', trans('backend.messages.success.update')) !!}
                                        $('#' + id).remove();
                                    }

                                    location.reload();

                                }
                            });
                        }
                    });
                });

                dodelete.click(function (e) {
                    e.preventDefault();

                    {!! confirm() !!}.then((result) => {
                        if (result.isConfirmed) {
                            let id = $(this).data('id');
                            $.ajax({
                                type: 'post',
                                url: '/admin/documents/' + id + '/delete',
                                data: {'id': id},
                                dataType: 'json',
                                success: function (result) {
                                    if (result.status != 1) {
                                        {!! notify('error', trans('backend.messages.error.delete')) !!}
                                    } else {
                                        {!! notify('success', trans('backend.messages.success.delete')) !!}
                                        $('#' + id).remove();
                                    }

                                    location.reload();

                                }
                            });
                        }
                    });
                });

            });
        </script>
    @endpush
@endif
