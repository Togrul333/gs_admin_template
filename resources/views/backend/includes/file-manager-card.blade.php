<div class="row pl-5 mx-0 pt-4">
        <div class="mr-3">
            <div class="media media_custom">
                <a class="gal-item showcase" data-rel="lightcase:myCollection:slideshow"
                   title="" href="{{ $file->document }}">
                    <figure>
                        <img style="width:100px; height:50px" class="img-fluid" alt=""
                             src="{{ $file->document }}">
                    </figure>
                </a>

                <div class="media-body mt-2">
                    @if(isset($isDeleted) && $isDeleted)
                        <button type="button" data-id="{{ $file->id }}"
                                class="btn btn-primary btn-block mb-1 dodelete">
                            Sil
                        </button>
                    @endif
                </div>
            </div>
        </div>
</div>
@push('extrascripts')
    <script src="{{ asset('/backend/js/lightcase.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            let showcase = $('a.showcase'),
                dodelete = $('.dodelete');

            showcase.lightcase({
                transition: 'scrollHorizontal',
                showSequenceInfo: false,
                showTitle: false
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            dodelete.click(function (e) {
                e.preventDefault();

                {!! confirm() !!}.then((result) => {
                    if (result.isConfirmed) {
                        let id = $(this).data('id');
                        $.ajax({
                            type: 'post',
                            url: '/admin/documents/' + id + '/delete',
                            data: {'id': id},
                            dataType: 'json',
                            success: function (result) {
                                if (result.status != 1) {
                                    {!! notify('error', trans('backend.messages.error.delete')) !!}
                                } else {
                                    {!! notify('success', trans('backend.messages.success.delete')) !!}
                                    $('#' + id).remove();
                                }

                                location.reload();

                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
