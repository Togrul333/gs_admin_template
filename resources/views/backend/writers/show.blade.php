@extends('layouts.backend.master')
@section('title', trans('backend.titles.writers'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    @include('backend.includes.table.header', ['page' => 'writers', 'id' => $writer->id])
                    @include('backend.writers.tables.show')
                    @include('backend.includes.table.footer', ['page' => 'writers', 'id' => ['writer' => $writer->id]])
                </div>
            </div>
        </div>
    </div>
@endsection
