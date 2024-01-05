@extends('layouts.backend.master')
@section('title', trans('backend.titles.roles'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    @include('backend.includes.table.header', ['page' => 'roles', 'id' => $role->id])
                    @include('backend.roles.tables.show')
                    @include('backend.includes.table.footer', ['page' => 'roles', 'id' => ['role' => $role->id]])
                </div>
            </div>
        </div>
    </div>
@endsection
