@extends('layouts.backend.master')
@section('title', trans('backend.titles.packages'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    @include('backend.includes.table.header', ['page' => 'packages', 'id' => $package->id])
                    @include('backend.packages.tables.show')
                    @include('backend.includes.table.footer', ['page' => 'packages', 'id' => ['package' => $package->id]])
                </div>
            </div>
        </div>
    </div>
@endsection
