@extends('layouts.backend.master')
@section('title', trans('backend.titles.packages'))
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
                    @include('backend.includes.form.header', ['page' => 'packages'])
                    <form action="{{ $edit === false ?  route('backend.packages.store') : route('backend.packages.update', ['package' => $package->id]) }}"
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
                                                <a class="nav-link @if($loop->first) active @endif" id="tab-{{ $lang->code }}"
                                                   data-toggle="tab" href="#{{ $lang->code }}">
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
                                            <label for="type:{{ $lang->code }}" class="col-form-label text-right col-lg-3 col-sm-12">
                                                Type ({{ strtoupper($lang->code) }})
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                <div class="input-group">
                                                    <input id="type:{{ $lang->code }}" type="text"
                                                           class="form-control @if($errors->has("type:$lang->code")) is-invalid @endif"
                                                           name="type:{{ $lang->code }}"
                                                           value="{{ isset($package) ? $package->translate($lang->code)?->type : old('type:'.$lang->code) }}"
                                                           placeholder="type">
                                                    @if ($errors->has("type:$lang->code"))
                                                        <div class="invalid-feedback">{{ $errors->first("type:$lang->code") }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="condition:{{ $lang->code }}" class="col-form-label text-right col-lg-3 col-sm-12">
                                                Condition ({{ strtoupper($lang->code) }})
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                <div class="input-group">
                                                    <input id="condition:{{ $lang->code }}" type="text"
                                                           class="form-control @if($errors->has("condition:$lang->code")) is-invalid @endif"
                                                           name="condition:{{ $lang->code }}"
                                                           value="{{ isset($package) ? $package->translate($lang->code)?->condition : old('condition:'.$lang->code) }}"
                                                           placeholder="condition">
                                                    @if ($errors->has("condition:$lang->code"))
                                                        <div class="invalid-feedback">{{ $errors->first("condition:$lang->code") }}</div>
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
                                                           class="form-control @if($errors->has("text:$lang->code")) is-invalid @endif"
                                                           name="description:{{ $lang->code }}"
                                                           value="{{ isset($package) ? $package->translate($lang->code)?->description : old('description:'.$lang->code) }}"
                                                           placeholder="@lang('backend.labels.description')">
                                                    @if ($errors->has("description:$lang->code"))
                                                        <div class="invalid-feedback">{{ $errors->first("description:$lang->code") }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group row">
                                <label for="price" class="col-form-label text-right col-lg-3 col-sm-12">
                                    Price
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input id="price" type="number" class="form-control @if($errors->has("price")) is-invalid @endif" name="price"
                                               value="{{ isset($package) ? $package->price : old('price') }}">
                                        @if ($errors->has("price"))
                                            <div class="invalid-feedback">{{ $errors->first("price") }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="time" class="col-form-label text-right col-lg-3 col-sm-12">
                                    Time
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <select id="time" class="form-control @error('time') is-invalid @enderror" name="time">
                                            @foreach ( \App\Enums\OrderTime::getValues() as $time)
                                                <option value="{{$time }}"
                                                    {{ (isset($package) ? $package->time:  old('time')) == $time ? 'selected' : '' }}>
                                                    {{ ucfirst(str_replace('_', ' ', $time)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="order" class="col-form-label text-right col-lg-3 col-sm-12">
                                    Sıra
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input id="order" type="number" class="form-control @if($errors->has("order")) is-invalid @endif" name="order"
                                               value="{{ isset($package) ? $package->order : old('order') }}">
                                        @if ($errors->has("order"))
                                            <div class="invalid-feedback">{{ $errors->first("order") }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    @lang('backend.labels.status')
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                         <span class="switch switch-md switch-icon">
                                             <label>
                                                 <input type="checkbox" class="bool" name="status"
                                                        value="{{ isset($package) ? $package->status : old('status') }}"
                                                     {{ (isset($package) ? old('status',$package->status) : old('status',1) ) == 1 ? 'checked' : '' }}>
                                                 <span></span>
                                             </label>
                                         </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('backend.includes.form.footer')
                    </form>
                </div>
                <div class="card">
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

