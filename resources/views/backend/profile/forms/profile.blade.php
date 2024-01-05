<form action="{{ route('backend.profile') }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="card-body">
        <div class="form-group row">
            <label class="col-form-label text-right col-lg-3 col-sm-12">
                @lang('backend.labels.name')
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-6 col-md-9 col-sm-12">
                <div class="input-group">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', admin()->name) }}" placeholder="@lang('backend.profile.name')">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label text-right col-lg-3 col-sm-12">
                @lang('backend.labels.email')
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-6 col-md-9 col-sm-12">
                <div class="input-group">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', admin()->email) }}" placeholder="@lang('backend.profile.email')">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label text-right col-lg-3 col-sm-12">
                @lang('backend.labels.password')
            </label>
            <div class="col-lg-6 col-md-9 col-sm-12">
                <div class="input-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="@lang('backend.profile.password')">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    @include('backend.includes.form.footer')
</form>