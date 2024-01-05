<div class="modal fade" id="imageModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md text-center" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('backend.labels.image')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                @isset($model)
                  <img class="img-fluid" style="object-fit: contain; max-width: 150px;" alt="{{ $model->name }}" src="{{ $image_path }}">
                @endisset
            </div>
        </div>
    </div>
</div>
