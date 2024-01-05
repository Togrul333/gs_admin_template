@extends('layouts.backend.master')
@section('title', trans('backend.titles.news'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    @include('backend.includes.table.header', ['page' => 'news', 'id' => $news->id])
                    @include('backend.news.tables.show')
                    @include('backend.includes.table.footer', ['page' => 'news', 'id' => ['news' => $news->id]])
                </div>
            </div>
        </div>
    </div>
@endsection
