@extends('layouts.backend.master')
@section('title', trans('backend.titles.roles'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom example example-compact">
                    @include('backend.includes.form.header', ['page' => 'roles'])
                    <form action="{{ $edit === false ? route('backend.roles.store') : route('backend.roles.update', ['role' => $role->id]) }}" method="POST">
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
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($role) ? $role->name : old('name') }}" placeholder="@lang('backend.placeholders.enter.name')">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-9 col-form-label ml-auto">
                                    <div class="checkbox-list">
                                        <label class="checkbox">
                                            <input type="checkbox" id="check_uncheck">
                                            <span></span> @lang('backend.mixins.check_uncheck_all')
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label text-right">
                                    @lang('backend.labels.permissions')
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-9 col-form-label">
                                    <div class="checkbox-list">
                                        @foreach ($permissions as $permission)
                                            <label for="permission_{{ $permission->id }}" class="checkbox">
                                                <input id="permission_{{ $permission->id }}" type="checkbox" class="is-invalid" name="permissions[]"  value="{{ $permission->id }}" @if(isset( $rolePermissions) ? collect(old('permissions', $rolePermissions))->contains($permission->id) : collect(old('permissions'))->contains($permission->id)) checked @endif>
                                                <span></span> {{ $permission->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('permissions')
                                    <div class="invalid text-danger mt-4">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @include('backend.includes.form.footer')
                    </form>
                </div>
            </div>
        </div>
@endsection
