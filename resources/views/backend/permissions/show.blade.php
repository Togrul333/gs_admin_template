@extends('layouts.backend.master')
@section('title', trans('backend.titles.permissions'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    @include('backend.includes.table.header', ['page' => 'permissions', 'id' => $permission->id])
                    @include('backend.permissions.tables.show')
                    @include('backend.includes.table.footer', ['page' => 'permissions', 'id' => ['permission' => $permission->id]])
                </div>
            </div>
        </div>
    </div>
@endsection
