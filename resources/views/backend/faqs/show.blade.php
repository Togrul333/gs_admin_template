@extends('layouts.backend.master')
@section('title', trans('backend.titles.faqs'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    @include('backend.includes.table.header', ['page' => 'faqs', 'id' => $faq->id])
                    @include('backend.faqs.tables.show')
                    @include('backend.includes.table.footer', ['page' => 'faqs', 'id' => ['faq' => $faq->id]])
                </div>
            </div>
        </div>
    </div>
@endsection
