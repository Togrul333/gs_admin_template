<script src="{{asset('main/loginpopup.js')}}"></script>
<script src="{{asset('main/custom.js')}}"></script>
<script src="{{asset('frontend/js/dropdown.js')}}"></script>
<script src="{{asset('frontend/js/script.js')}}"></script>
<script src="{{asset('frontend/js/swiper.min.js')}}"></script>
<script src="{{asset('frontend/js/mySwiper.js')}}"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- JavaScript Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    toastr.options = {
        positionClass: "toast-top-right",
        closeButton: true,
    };
</script>

@if(!auth()->check())
    <script src="{{asset('main/auth/login.js')}}"></script>
@endif
