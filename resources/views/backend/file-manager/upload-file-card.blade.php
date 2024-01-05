<div class="form-group d-flex flex-column gap-2">
    <label class="col-form-label pl-4">
        @lang('backend.labels.image')
        @if(!$edit)
        <span class="text-danger">*</span>
        @endif
    </label>
    <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Upload image</button>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="modal-title" id="exampleModalLabel">Upload image</h5>
                        <button type="button" class="btn btn-primary mr-3" data-toggle="modal" id="exampleModalTwoModal_2" data-target="#exampleModalTwo" data-whatever="@fat">Сhoose from existing</button>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12 col-md-9 col-sm-12">
                        <div class="input-group">
                            <div class="custom-file w-100">
                                <input type="file" class="custom-file-input w-100 @error('image') is-invalid @enderror" name="image[]" multiple="multiple" accept="image/*">
                                <label class="custom-file-label">
                                    @lang('backend.placeholders.choose.image')
                                </label>
                            </div>
                            @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="exampleModalTwoModal_1_close" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade w-100" id="exampleModalTwo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 1280px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">File manager</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="pagination_modal">
                    <div class="d-flex align-items-center gap-2 flex-column">
                        <div class="d-flex gap-2 w-100 align-items-center flex-wrap">
                            @foreach($files as $file)
                            @include('backend.includes.file-manager-card-show',['model' => $file])
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-end align-items-center w-100">
                            @include('backend.includes.pagination',['items'=>$files])
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="selectedImage" class="d-flex flex-wrap gap-2 justify-content-between mt-2"></div>

<div id="selectedImages" class="d-flex flex-wrap gap-2 justify-content-between mt-4"></div>
@push('extrascripts')
<script>
    $(document).ready(function() {
        $('#exampleModalTwoModal_2').on('click', function() {
            $("#exampleModalTwoModal_1_close").trigger("click");
        });
    });


    const inputFile = document.querySelector(".custom-file-input");
    const selectedImage = document.getElementById('selectedImage')

    inputFile.addEventListener("change", (e) => {
        selectedImage.innerHTML = '';

        [...e.target.files].map(file => {
            const reader = new FileReader();

            reader.onload = function(v) {
                let variable = v.target
                variable.imageName = file.name
                console.log(variable);

                selectedImage.innerHTML += `
         <div class="selected-image-container d-flex flex-column gap-2 flex-shrink-0 justify-content-between " style="width:100px; height: 150px;">
         <label class="d-flex align-items-center">
           <span>Select main</span>
           <input class="mx-2" type="radio" name="selectMain" value="${variable.imageName}" >

           </label>
           <div class="image_container" style="height: 80px;">

           <img src="${v.target.result}" class="img-thumbnail w-100 h-100" >
           </div>

           <input type="text" class="form-control" name="alt_uploaded[${variable.imageName}]" placeholder="Alt yazi elave edin">
         </div>
        `

            }
            reader.readAsDataURL(file);
        })
    })
</script>

@endpush
