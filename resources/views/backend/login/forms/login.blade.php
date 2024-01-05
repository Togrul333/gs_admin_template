<form action="{{ route('backend.login') }}" method="POST">
    @csrf
    <div class="form-group">
        <input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 @error('email') is-invalid @enderror" type="email" placeholder="@lang('backend.login.email')" name="email" value="{{ old('email') }}">
        @error('email')
            <span class="form-text text-danger pt-2">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 @error('password') is-invalid @enderror" type="password" placeholder="@lang('backend.login.password')" name="password">
        @error('password')
            <span class="form-text text-danger pt-2">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group d-flex flex-wrap justify-content-between align-items-center px-8 opacity-60">
        <div class="checkbox-inline">
            <label class="checkbox checkbox-outline checkbox-white text-white m-0">
                <input type="checkbox" class="bool" name="remember" value="{{ old('remember') ?? 0 }}" @if(old('remember')) checked @endif>
                <span></span> @lang('backend.login.remember')
            </label>
        </div>
    </div>
    <div class="form-group text-center mt-10">
        <button class="btn btn-pill btn-primary opacity-90 px-15 py-3">
            @lang('backend.buttons.login')
        </button>
    </div>
</form>