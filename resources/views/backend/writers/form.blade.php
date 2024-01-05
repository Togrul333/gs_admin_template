@extends('layouts.backend.master')
@section('title', trans('backend.titles.writers'))
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
                    @include('backend.includes.form.header', ['page' => 'writers'])
                    <form action="{{ $edit === false ?  route('backend.writers.store') : route('backend.writers.update', ['writer' => $writer->id]) }}"
                          method="POST"  enctype="multipart/form-data">
                        @csrf
                        @if($edit)
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12"></label>
                            </div>
                            <div class="tab-content">
                                <div class="form-group row">
                                    <label for="name" class="col-form-label text-right col-lg-3 col-sm-12">
                                        name
                                    </label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                                       name="name" value="{{ isset($writer) ? $writer->name : old('name')  }}">
                                            </div>
                                            @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="role" class="col-form-label text-right col-lg-3 col-sm-12">
                                        Role
                                    </label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input id="role" type="text" class="form-control @error('role') is-invalid @enderror"
                                                       name="role" value="{{ isset($writer) ? $writer->role : old('role')  }}">
                                            </div>
                                            @error('role')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
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
                                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" name="image[]" multiple="multiple" accept="image/*">
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

                            </div>
                        </div>
                        @include('backend.includes.form.footer')
                    </form>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if ($edit)
                            @include('backend.includes.media',[
                                    'model' => $writer,
                                    'name'  => 'writer',
                                    'media_collection_name'  => '',
                                    'isDeleted' => true,
                                    'isCovered' => false,
                                     ])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

