@extends('layouts.backend.master')
@section('title', trans('backend.titles.guard_name'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom example example-compact">
                    @include('backend.includes.form.header', ['page' => 'permissions'])
                    <form action="{{ $edit === false ? route('backend.permissions.store') : route('backend.permissions.update', ['permission' => $permission->id]) }}" method="POST">
                        @csrf
                        @if($edit)
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-form-label text-right col-lg-3 col-sm-12">
                                    @lang('backend.labels.name')
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($permission) ? $permission->name : old('name') }}" placeholder="@lang('backend.placeholders.enter.name')">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gurad_name" class="col-form-label text-right col-lg-3 col-sm-12">
                                    @lang('backend.labels.guard_name')
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input id="gurad_name" type="text" class="form-control @error('guard_name') is-invalid @enderror" name="guard_name" value="{{ isset($permission) ? $permission->guard_name : old('guard_name') }}" placeholder="@lang('backend.placeholders.enter.guard_name')">
                                        @error('guard_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
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
