@extends('layouts.backend.master')
@section('title', trans('backend.titles.news'))
@section('styles')
    <link rel="stylesheet" href="{{ asset('/backend/css/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/main/pagination.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card card-custom example example-compact">
                    @include('backend.includes.form.header', ['page' => 'news'])
                    <form action="{{ $edit === false ?  route('backend.news.store') : route('backend.news.update', ['news' => $news->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($edit) @method('PUT') @endif
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12"></label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <ul class="nav nav-light-primary nav-pills" role="tablist">
                                        @foreach ($langs as $lang)
                                            <li class="nav-item">
                                                <a class="nav-link @if($loop->first) active @endif"
                                                   id="tab-{{ $lang->code }}" data-toggle="tab"
                                                   href="#{{ $lang->code }}">
                                                    <span class="nav-text">{{ $lang->name }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                @foreach ($langs as $lang)
                                    <div class="tab-pane fade @if($loop->first) active show @endif"
                                         id="{{ $lang->code }}" role="tabpanel" aria-labelledby="tab-{{ $lang->code }}">

                                        <div class="d-flex gap-4 justify-content-between flex-wrap ">
                                            <label class="required form-label d-flex flex-column gap-2"
                                                   style="width: 49%" for="title:{{ $lang->code }}">
                                                <p class="d-flex gap-2 align-items-center pl-2">
                                            <span>
                                                @lang('backend.labels.title')  ({{ strtoupper($lang->code) }})
                                            </span>
                                                    <span class="text-danger">*</span>
                                                </p>
                                                <input type="text" name="title:{{ $lang->code }}"
                                                       id="title:{{ $lang->code }}"
                                                       class="form-control mb-2 mx-2 @if($errors->has(" title:$lang->code")) is-invalid @endif"
                                                       value="{{ isset($news) ? $news->translate($lang->code)?->title : old('title:'.$lang->code) }}"
                                                       placeholder="@lang('backend.labels.title')">
                                                @if ($errors->has("title:$lang->code"))
                                                    <div
                                                        class="invalid-feedback">{{ $errors->first("title:$lang->code") }}</div>
                                                @endif
                                            </label>

                                            <label class="required form-label d-flex flex-column gap-2"
                                                   style="width: 49%" for="sub_title:{{ $lang->code }}">
                                                <p class="d-flex gap-2 align-items-center pl-2">
                                            <span>
                                                Sub title ({{ strtoupper($lang->code) }})
                                            </span>
                                                    <span class="text-danger">*</span>
                                                </p>
                                                <input type="text" name="sub_title:{{ $lang->code }}"
                                                       id="sub_title:{{ $lang->code }}"
                                                       class="form-control mb-2 mx-2 @if($errors->has(" sub_title:$lang->code")) is-invalid @endif"
                                                       value="{{ isset($news) ? $news->translate($lang->code)?->sub_title : old('sub_title:'.$lang->code) }}"
                                                       placeholder="Sub title">
                                                @if ($errors->has("sub_title:$lang->code"))
                                                    <div
                                                        class="invalid-feedback">{{ $errors->first("sub_title:$lang->code") }}</div>
                                                @endif
                                            </label>

                                            <label class="required form-label d-flex flex-column gap-2"
                                                   style="width: 49%" for="slug:{{ $lang->code }}">
                                                <p class="d-flex gap-2 align-items-center pl-2">
                                            <span>
                                                @lang('backend.labels.slug') ({{ strtoupper($lang->code) }})
                                            </span>
                                                    <span class="text-danger">*</span>
                                                </p>
                                                <input type="text" name="slug:{{ $lang->code }}"
                                                       id="slug:{{ $lang->code }}"
                                                       value="{{ isset($news) ? $news->translate($lang->code)?->slug : old('slug:'.$lang->code) }}"
                                                       class="form-control mb-2 mx-2 @if($errors->has(" slug:$lang->code")) is-invalid @endif"
                                                       placeholder="@lang('backend.labels.slug')">
                                                @if ($errors->has("slug:$lang->code"))
                                                    <div
                                                        class="invalid-feedback">{{ $errors->first("slug:$lang->code") }}</div>
                                                @endif
                                            </label>
                                        </div>

                                        <div class="d-flex gap-4 flex-column">
                                            <div class="d-flex gap-4 justify-content-between flex-wrap flex-grow-1">
                                                <div class="form-group d-flex flex-column flex-grow-1">
                                                    <label for="content" class=" text-left pl-3">
                                                        @lang('backend.labels.description')
                                                        ({{ strtoupper($lang->code) }})
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-12 col-md-9 col-sm-12">
                                                        <div class="input-group flex-grow-1">
                                                    <textarea id="content"
                                                              class="summernote @if($errors->has(" description:$lang->code")) is-invalid @endif"
                                                              name="description:{{ $lang->code }}"
                                                              placeholder="@lang('backend.placeholders.enter.description')">
                                                      {!! isset($news) ? $news->translate($lang->code)?->description  : old('description:'.$lang->code) !!}
                                                   </textarea>
                                                            @if ($errors->has("description:$lang->code"))
                                                                <div
                                                                    class="invalid-feedback">{{ $errors->first("description:$lang->code") }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="d-flex gap-2 w-100 align-items-center">
                                <div class="form-group row col-lg-6">
                                    <label for="category_id" class="col-form-label pl-4">
                                        Category
                                    </label>
                                    <div class="col-lg-12 col-md-9 col-sm-12">
                                        <select class="form-control selectpicker" multiple
                                                aria-label="Default select example" data-live-search="true"
                                                name="category_ids[]" id="category_id">
                                            @foreach($categories as $category)
                                                <option
                                                    value="{{$category->id}}" {{ isset($news) && $news->categories->contains($category->id)  ? 'selected' : ''  }}>{{$category->translate(locale())->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row col-lg-6">
                                    <label for="option_id" class="col-form-label pl-4">
                                        Option
                                    </label>
                                    <div class="col-lg-12 col-md-9 col-sm-12">
                                        <select class="form-control selectpicker" multiple
                                                aria-label="Default select example" data-live-search="true"
                                                name="option_ids[]" id="option_id" multiple>
                                            @foreach($options as $option)
                                                <option
                                                    value="{{$option->id}}" {{ isset($news) && $news->options->contains($option->id)   ? 'selected' : ''  }}>{{$option->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <br>
                            <br>

                            <div class="d-flex gap-2 align-items-center w-100">

                                <div class="d-flex flex-column gap-5 w-100 col-lg-6">
                                          @include('backend.file-manager.upload-file-card')
                                </div>

                                <div class="d-flex flex-column gap-2 w-100">
                                    <div class="form-group d-flex flex-column gap-2 pl-0 col-lg-11">
                                        <label for="date" class="col-form-label pl-4">
                                            Action Date
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-12 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                <input id="link" type="date"
                                                       class="form-control @if($errors->has(" date")) is-invalid @endif"
                                                       name="action_date"
                                                       value="{{ isset($news) ? \Illuminate\Support\Carbon::parse($news->action_date)->format('Y-m-d') : date('Y-m-d') }}"
                                                       max="{{ date('Y-m-d') }}">
                                                @if ($errors->has("action_date"))
                                                    <div
                                                        class="invalid-feedback">{{ $errors->first("action_date") }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group d-flex flex-column gap-2 pl-3 col-lg-11">
                                        <label class="col-form-label pl-0" for="timepicker">Select Time:</label>
                                        <div class="input-group date d-flex" id="timepicker-container">
                                            <input type="text" class="form-control" name="action_date_time"
                                                   value="{{ isset($news) ? \Illuminate\Support\Carbon::parse($news->action_date)->format('h:i:s') : date('h:i:s') }}"
                                                   id="timepicker" placeholder="Select time">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="d-flex gap-2 align-items-center w-100">
                                <div class="form-group d-flex flex-column gap-2 pl-0 col-lg-6">
                                    <label for="order" class="col-form-label pl-4">
                                        Sıra
                                    </label>
                                    <div class="col-lg-12 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input id="order" type="number"
                                                   class="form-control @if($errors->has(" order")) is-invalid @endif"
                                                   name="order"
                                                   value="{{ isset($news) ? $news->order : old('order') }}">
                                            @if ($errors->has("order"))
                                                <div class="invalid-feedback">{{ $errors->first("order") }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group d-flex flex-column gap-2 pl-0 col-lg-6">
                                    <label for="type" class="col-form-label pl-4">
                                        Tipi
                                    </label>
                                    <div class="col-lg-12 col-md-9 col-sm-12">
                                        <select class="form-control" name="type" id="type">
                                            <option
                                                value="normal" {{ isset($news) && $news->news_type == 'normal' ? 'selected' : ''  }}>
                                                Normal
                                            </option>
                                            <option
                                                value="yenilənir" {{ isset($news) && $news->news_type == 'yenilənir' ? 'selected' : ''  }}>
                                                Yenilənir
                                            </option>
                                            <option
                                                value="yenilənib" {{ isset($news) && $news->news_type == 'yenilənib' ? 'selected' : ''  }}>
                                                Yenilənib
                                            </option>
                                            <option
                                                value="video" {{ isset($news) && $news->news_type == 'video' ? 'selected' : ''  }}>
                                                Video
                                            </option>
                                            <option
                                                value="foto" {{ isset($news) && $news->news_type == 'foto' ? 'selected' : ''  }}>
                                                Foto
                                            </option>
                                            <option
                                                value="ekskluziv" {{ isset($news) && $news->news_type == 'ekskluziv' ? 'selected' : ''  }}>
                                                Ekskluziv
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 align-items-center w-100">
                                <div class="form-group d-flex flex-column gap-2 pl-0 col-lg-6">
                                    <label for="video" class="col-form-label pl-4">
                                        Upload video
                                    </label>
                                    <div class="col-lg-12 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input id="video" type="file"
                                                   class="form-control @if($errors->has(" video")) is-invalid @endif"
                                                   name="video[]"
                                                   value="{{ isset($news) ? $news->order : old('video') }}"
                                                   accept="video/*">
                                            @if ($errors->has("video"))
                                                <div class="invalid-feedback">{{ $errors->first("video") }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group d-flex flex-column gap-2 pl-0 col-lg-6">
                                    <label for="video_url" class="col-form-label pl-4">
                                        Video url
                                    </label>
                                    <div class="col-lg-12 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input id="video_url" type="text"
                                                   class="form-control @if($errors->has("video_url")) is-invalid @endif"
                                                   name="video_url"
                                                   value="{{ isset($news) ? $news->video_url : old('video_url') }}">
                                            @if ($errors->has("video_url"))
                                                <div class="invalid-feedback">{{ $errors->first("video_url") }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-5 w-100 justify-content-center">

                                <div class="form-group row mx-5">
                                    <label class="col-form-label">
                                        confirmed
                                    </label>
                                    <div>
                                        <div class="input-group">
                                        <span class="switch switch-md switch-icon">
                                            <label>
                                                <input type="checkbox" class="bool" name="confirmed"
                                                       value="{{ isset($news) ? $news->confirmed : old('confirmed') }}" {{ (isset($news) ? old('confirmed',$news->confirmed) : old('confirmed',1) ) == 1 ? 'checked' : '' }}>
                                                <span></span>
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mx-5">
                                    <label class="col-form-label">
                                        for free
                                    </label>
                                    <div>
                                        <div class="input-group">
                                        <span class="switch switch-md switch-icon">
                                            <label>
                                                <input type="checkbox" class="bool" name="for_free"
                                                       value="{{ isset($news) ? $news->for_free : old('for_free') }}" {{ (isset($news) ? old('for_free',$news->for_free) : old('for_free',1) ) == 1 ? 'checked' : '' }}>
                                                <span></span>
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mx-5">
                                    <label class="col-form-label">
                                        @lang('backend.labels.status')
                                    </label>
                                    <div>
                                        <div class="input-group">
                                        <span class="switch switch-md switch-icon">
                                            <label>
                                                <input type="checkbox" class="bool" name="status"
                                                       value="{{ isset($news) ? $news->status : old('status') }}" {{ (isset($news) ? old('status',$news->status) : old('status',1) ) == 1 ? 'checked' : '' }}>
                                                <span></span>
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        @include('backend.includes.form.footer')
                    </form>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if ($edit)
                            @include('backend.includes.media',[
                            'model' => $news,
                            'name' => 'news',
                            'isMain' => true,
                            ])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
            var pageParam = urlParams.get('page');

            if (pageParam) {
                $('#exampleModalTwoModal_2').click();
            }
        });
    </script>
    <script>
        let key_az = document.querySelector('.tagify-az');
        let key_en = document.querySelector('.tagify-en');
        let key_ru = document.querySelector('.tagify-ru');

        new Tagify(key_az);
        new Tagify(key_en);
        new Tagify(key_ru);

        $('.summernote').summernote({
            height: 300,
            imageAttributes: {
                icon: '<i class="note-icon-pencil"/>',
                figureClass: 'figureClass',
                figcaptionClass: 'captionClass',
                captionText: 'Caption Goes Here.',
                manageAspectRatio: true
            },
            lang: 'en-US',
            popover: {
                image: [
                    ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']],
                    ['custom', ['imageAttributes']],
                ],
            },
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#timepicker').timepicker({
                showMeridian: false,
                showSeconds: true,
                defaultTime: false,
                icons: {
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down'
                }
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
    <script src="{{ asset('/backend/js/select2.min.js') }}"></script>
    <script src="{{ asset('/backend/js/newsSelectImage.js') }}"></script>
@endsection
