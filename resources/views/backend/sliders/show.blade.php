@extends('layouts.backend.master')
@section('title', trans('backend.titles.sliders'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    @include('backend.includes.table.header', ['page' => 'sliders', 'id' => $slider->id])
                    @include('backend.sliders.tables.show')
                    @include('backend.includes.table.footer', ['page' => 'sliders', 'id' => ['slider' => $slider->id]])
                </div>
            </div>
        </div>
    </div>
@endsection
