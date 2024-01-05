@extends('layouts.backend.master')
@section('title', trans('backend.titles.users'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    @include('backend.includes.table.header', ['page' => 'users', 'id' => $user->id])
                    @include('backend.users.tables.show')
                    @include('backend.includes.table.footer', ['page' => 'users', 'id' => ['user' => $user->id]])
                </div>
            </div>
        </div>
    </div>
@endsection
