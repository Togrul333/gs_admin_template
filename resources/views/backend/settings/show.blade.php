@extends('layouts.backend.master')
@section('title', trans('backend.titles.settings'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    @include('backend.includes.table.header', ['page' => 'settings', 'id' => $setting->id])
                    @include('backend.settings.tables.show')
                    @include('backend.includes.table.footer', ['page' => 'settings', 'id' => ['setting' => $setting->id]])
                </div>
            </div>
        </div>
    </div>
@endsection
