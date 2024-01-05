@extends('layouts.backend.master')
@section('title', trans('backend.titles.writings'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    @include('backend.includes.table.header', ['page' => 'writings', 'id' => $writing->id])
                    @include('backend.writings.tables.show')
                    @include('backend.includes.table.footer', ['page' => 'writings', 'id' => ['writing' => $writing->id]])
                </div>
            </div>
        </div>
    </div>
@endsection
