<div class="row pl-5 mx-0 pt-4">
    <div class="mr-3">
        <label>
            <input type="checkbox" name="selectedFiles[]" class="selectCheckImage" value="{{ $file->id }}">
            <div class="media media_custom">
                <img style="width:100px; height:100px" class="img-fluid" alt="" src="{{ $file->document }}">
            </div>
        </label>
    </div>
</div>
