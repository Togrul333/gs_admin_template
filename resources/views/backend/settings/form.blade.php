@extends('layouts.backend.master')
@section('title', trans('backend.titles.settings'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom example example-compact">
                    @include('backend.includes.form.header', ['page' => 'settings'])
                    <form action="{{ $edit === false ? route('backend.settings.store') : route('backend.settings.update', ['setting' => $setting->id]) }}"
                          method="POST">
                        @csrf
                        @if($edit)
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12"></label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <ul class="nav nav-light-primary nav-pills" role="tablist">
                                        @foreach ($langs as $lang)
                                            <li class="nav-item">
                                                <a class="nav-link @if($loop->first) active @endif" id="tab-{{ $lang->code }}" data-toggle="tab" href="#{{ $lang->code }}">
                                                    <span class="nav-text">{{ $lang->name }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>


                            <div class="tab-content mt-5">
                                @foreach ($langs as $lang)
                                    <div class="tab-pane fade @if($loop->first) active show @endif" id="{{ $lang->code }}" role="tabpanel" aria-labelledby="tab-{{ $lang->code }}">
                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-3 col-sm-12 col-form-label">
                                                @lang('backend.labels.content') ({{ strtoupper($lang->code) }})
                                            </label>
                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                <div class="input-group">
                                                   <textarea class="summernote @if($errors->has("content:$lang->code")) is-invalid @endif" name="content:{{ $lang->code }}" placeholder="@lang('backend.placeholders.enter.content')">
                                                      {!! isset($setting) ? $setting->translate($lang->code)?->content : old('content:'.$lang->code) !!}
                                                   </textarea>`
                                                    @if ($errors->has("content:$lang->code"))
                                                        <div class="invalid-feedback">{{ $errors->first("content:$lang->code") }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-form-label text-right col-lg-3 col-sm-12">
                                    @lang('backend.labels.name')
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($setting) ? $setting->name : old('name') }}" placeholder="@lang('backend.placeholders.enter.name')">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="slug" class="col-form-label text-right col-lg-3 col-sm-12">
                                    Slug
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ isset($setting) ? $setting->slug : old('slug')  }}">
                                        @error('slug')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('backend.includes.form.footer')
                    </form>
                </div>
            </div>
        </div>
@endsection
@section('scripts')
            <script>
                let text = $('.summernote');

                text.summernote({height: 300 });

            </script>
@endsection
