@extends('layouts.backend.master')
@section('title', trans('backend.titles.categories'))
@section('styles')
    <link rel="stylesheet" href="{{ asset('/backend/css/datepicker.min.css') }}">
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
                    @include('backend.includes.form.header', ['page' => 'categories'])
                    <form action="{{ $edit === false ?  route('backend.categories.store') : route('backend.categories.update', ['category' => $category->id]) }}"
                          method="POST"  enctype="multipart/form-data">
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
                            <div class="tab-content">
                                @foreach ($langs as $lang)
                                    <div class="tab-pane fade @if($loop->first) active show @endif" id="{{ $lang->code }}"
                                         role="tabpanel" aria-labelledby="tab-{{ $lang->code }}">
                                        <div class="form-group row">
                                            <label for="name:{{ $lang->code }}" class="col-form-label text-right col-lg-3 col-sm-12">
                                                @lang('backend.labels.name') ({{ strtoupper($lang->code) }})
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                <div class="input-group">
                                                    <input id="name:{{ $lang->code }}" type="text"
                                                           class="form-control @if($errors->has("name:$lang->code")) is-invalid @endif"
                                                           name="name:{{ $lang->code }}"
                                                           value="{{ isset($category) ? $category->translate($lang->code)?->name : old('name:'.$lang->code) }}"
                                                           placeholder="@lang('backend.labels.name')">
                                                    @if ($errors->has("name:$lang->code"))
                                                        <div class="invalid-feedback">{{ $errors->first("name:$lang->code") }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description:{{ $lang->code }}" class="col-form-label text-right col-lg-3 col-sm-12">
                                                @lang('backend.labels.description') ({{ strtoupper($lang->code) }})
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                <div class="input-group">
                                                    <input id="description:{{ $lang->code }}" type="text"
                                                           class="form-control @if($errors->has("description:$lang->code")) is-invalid @endif"
                                                           name="description:{{ $lang->code }}"
                                                           value="{{ isset($category) ? $category->translate($lang->code)?->description : old('description:'.$lang->code) }}"
                                                           placeholder="@lang('backend.labels.description')">
                                                    @if ($errors->has("description:$lang->code"))
                                                        <div class="invalid-feedback">{{ $errors->first("description:$lang->code") }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="meta_title:{{ $lang->code }}" class="col-form-label text-right col-lg-3 col-sm-12">
                                                Meta title ({{ strtoupper($lang->code) }})
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                <div class="input-group">
                                                    <input id="meta_title:{{ $lang->code }}" type="text"
                                                           class="form-control @if($errors->has("meta_title:$lang->code")) is-invalid @endif"
                                                           name="meta_title:{{ $lang->code }}"
                                                           value="{{ isset($category) ? $category->translate($lang->code)?->meta_title : old('meta_title:'.$lang->code) }}"
                                                           placeholder="Meta title">
                                                    @if ($errors->has("meta_title:$lang->code"))
                                                        <div class="invalid-feedback">{{ $errors->first("meta_title:$lang->code") }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="meta_description:{{ $lang->code }}" class="col-form-label text-right col-lg-3 col-sm-12">
                                                Meta description ({{ strtoupper($lang->code) }})
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                <div class="input-group">
                                                    <input id="meta_description:{{ $lang->code }}" type="text"
                                                           class="form-control @if($errors->has("meta_description:$lang->code")) is-invalid @endif"
                                                           name="meta_description:{{ $lang->code }}"
                                                           value="{{ isset($category) ? $category->translate($lang->code)?->meta_description : old('meta_description:'.$lang->code) }}"
                                                           placeholder="Meta description">
                                                    @if ($errors->has("meta_description:$lang->code"))
                                                        <div class="invalid-feedback">{{ $errors->first("meta_description:$lang->code") }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="meta_keywords:{{ $lang->code }}" class="col-form-label text-right col-lg-3 col-sm-12">
                                                Meta keywords ({{ strtoupper($lang->code) }})
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                <div class="input-group">
                                                    <input id="meta_keywords:{{ $lang->code }}" type="text"
                                                           class="form-control @if($errors->has("meta_keywords:$lang->code")) is-invalid @endif"
                                                           name="meta_keywords:{{ $lang->code }}"
                                                           value="{{ isset($category) ? $category->translate($lang->code)?->meta_keywords : old('meta_keywords:'.$lang->code) }}"
                                                           placeholder="Meta keywords">
                                                    @if ($errors->has("meta_keywords:$lang->code"))
                                                        <div class="invalid-feedback">{{ $errors->first("meta_keywords:$lang->code") }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="title_first:{{ $lang->code }}" class="col-form-label text-right col-lg-3 col-sm-12">
                                                Title first from page ({{ strtoupper($lang->code) }})
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                <div class="input-group">
                                                    <input id="title_first:{{ $lang->code }}" type="text"
                                                           class="form-control @if($errors->has("title_first:$lang->code")) is-invalid @endif"
                                                           name="title_first:{{ $lang->code }}"
                                                           value="{{ isset($category) ? $category->translate($lang->code)?->title_first : old('title_first:'.$lang->code) }}"
                                                           placeholder="Title first from page">
                                                    @if ($errors->has("title_first:$lang->code"))
                                                        <div class="invalid-feedback">{{ $errors->first("title_first:$lang->code") }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="title_second:{{ $lang->code }}" class="col-form-label text-right col-lg-3 col-sm-12">
                                                Title second from page  ({{ strtoupper($lang->code) }})
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                <div class="input-group">
                                                    <input id="title_second:{{ $lang->code }}" type="text"
                                                           class="form-control @if($errors->has("title_second:$lang->code")) is-invalid @endif"
                                                           name="title_second:{{ $lang->code }}"
                                                           value="{{ isset($category) ? $category->translate($lang->code)?->title_second : old('title_second:'.$lang->code) }}"
                                                           placeholder=" Title second from page">
                                                    @if ($errors->has("title_second:$lang->code"))
                                                        <div class="invalid-feedback">{{ $errors->first("title_second:$lang->code") }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="slug" class="col-form-label text-right col-lg-3 col-sm-12">
                                Slug
                            </label>
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror"
                                               name="slug" value="{{ isset($category) ? $category->slug : old('slug')  }}">
                                    </div>
                                    @error('slug')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="parent_id" class="col-form-label text-right col-lg-3 col-sm-12">
                                Parent category
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <div class="input-group">
                                    <select id="parent_id" class="form-control @error('parent_id') is-invalid @enderror" name="parent_id">
                                        <option value=""></option>
                                        @foreach ($categories as $category_item)
                                            <option value="{{ $category_item->id }}" {{ isset($category) && $category->parent_id == $category_item->id ? 'selected' : ''  }}>
                                                {{ translation($category_item)->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-form-label text-right col-lg-3 col-sm-12">
                                @lang('backend.labels.image')
                                @if(!$edit)
                                    <span class="text-danger">*</span>
                                @endif
                            </label>
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                               name="image[]" multiple="multiple" accept="image/*">
                                        <label class="custom-file-label">
                                            @lang('backend.placeholders.choose.image')
                                        </label>
                                    </div>
                                    @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
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
                                                       value="{{ isset($category) ? $category->status : old('status') }}" {{ (isset($category) ? old('status',$category->status) : old('status',1) ) == 1 ? 'checked' : '' }}>
                                                <span></span>
                                            </label>
                                        </span>
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
                            'model' => $category,
                            'name' => 'category',
                            'isMain' => false,
                            ])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

