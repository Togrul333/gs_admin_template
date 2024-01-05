@extends('layouts.backend.master')
@section('title', trans('backend.titles.categories'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    @include('backend.includes.table.header', ['page' => 'categories', 'id' => $category->id])
                    @include('backend.categories.tables.show')
                    @include('backend.includes.table.footer', ['page' => 'categories', 'id' => ['category' => $category->id]])
                </div>
            </div>
        </div>
    </div>
@endsection
