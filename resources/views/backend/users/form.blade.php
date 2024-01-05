@extends('layouts.backend.master')
@section('title', trans('backend.titles.users'))
@section('styles')
    <link rel="stylesheet" href="{{ asset('/backend/css/datepicker.min.css') }}">
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom example example-compact">
                    @include('backend.includes.form.header', ['page' => 'users'])
                    <form action="{{ $edit === false ?  route('backend.users.store') : route('backend.users.update', ['user' => $user->id]) }}" method="POST">
                        @csrf
                        @if($edit)
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="first_name" class="col-form-label text-right col-lg-3 col-sm-12">
                                    @lang('backend.labels.first_name')
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ isset($user) ? $user->first_name : old('first_name') }}" placeholder="@lang('backend.placeholders.enter.first_name')">
                                        @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_name" class="col-form-label text-right col-lg-3 col-sm-12">
                                    @lang('backend.labels.last_name')
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ isset($user) ? $user->last_name : old('last_name') }}" placeholder="@lang('backend.placeholders.enter.last_name')">
                                        @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-form-label text-right col-lg-3 col-sm-12">
                                    @lang('backend.labels.email')
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ isset($user) ? $user->email : old('email') }}" placeholder="@lang('backend.placeholders.enter.email')">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-form-label text-right col-lg-3 col-sm-12">
                                    @lang('backend.labels.phone_number')
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input id="phone" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone" value="{{ isset($user) ? optional($user->info)->phone : old('phone') }}" placeholder="@lang('backend.placeholders.enter.phone_number')">
                                        @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="birthdate"
                                       class="col-form-label text-right col-lg-3 col-sm-12 col-form-label">
                                    @lang('backend.labels.birthdate')
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">

                                        <input type="text" class="form-control datepicker-here" id="birthdate"
                                               name="birthdate" data-position="right bottom" data-timepicker="false"
                                               value="{{ $edit ? optional($user->info)->birthdate->format('d.m.Y') : old('birthdate') }}"
                                               maxlength="11" data-maxlength="11">
                                        @if ($errors->has("birthdate"))
                                            <div class="invalid-feedback">{{ $errors->first("birthdate") }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    @lang('backend.labels.password')
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="@lang('backend.placeholders.enter.password')">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-form-label text-right col-lg-3 col-sm-12">
                                    @lang('backend.labels.address')
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                          <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="@lang('backend.placeholders.enter.address')" rows="5">
                                           {{  isset($user) ? optional($user->info)->address : old('address') }}
                                        </textarea>
                                        @error ('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">
                                    @lang('backend.labels.status')
                                </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                         <span class="switch switch-md switch-icon">
                                             <label>
                                                 <input type="checkbox" class="bool" name="status" value="{{ isset($user) ? $user->status : old('status',1) }}"  {{ (isset($user) ? $user->status :  old('status',1)) == 1 ? 'checked' : '' }}>
                                                 <span></span>
                                             </label>
                                         </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('backend.includes.form.footer')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('/backend/js/datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            $.fn.datepicker.language['az'] = {
                days: ['Bazar', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                daysMin: ['Bz', 'Be', 'Ça', 'Çş', 'Ca', 'Cm', 'Şb'],
                months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                today: 'Today',
                clear: 'Clear',
                dateFormat: 'mm/dd/yyyy',
                timeFormat: 'hh:ii aa',
                firstDay: 0
            };

        });

    </script>

@endsection

