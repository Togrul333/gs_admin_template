@extends('layouts.backend.master')
@section('title', trans('backend.titles.profile'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom example example-compact">
                    @include('backend.includes.form.header', ['page' => 'profile'])
                    @include('backend.profile.forms.profile')
                </div>
            </div>
        </div>
    </div>
@endsection
