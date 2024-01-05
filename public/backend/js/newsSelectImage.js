const selectCheckImages = document.querySelectorAll(".selectCheckImage");
const selectedImages = document.getElementById("selectedImages");

let selectedImagesArray = [];

selectCheckImages.forEach(selImg => selImg.addEventListener("change", (e) => {


  const targetImage = e.target.nextElementSibling.querySelector('img').src;

  if (e.target.checked) {
    selectedImagesArray.push(targetImage);
    selectedImages.innerHTML = "";

    selectedImagesArray.forEach(selImg => selectedImages.innerHTML += `
        <div class="selected-image-container d-flex flex-column gap-2 flex-shrink-0 justify-content-between " style="width:100px; height: 150px;">
        <label class="d-flex align-items-center">
          <span>Select main</span>
          <input class="mx-2" type="radio" name="selectMain"  value="${selImg}">

          </label>
          <div class="image_container" style="height: 80px;">

          <img src="${selImg}" class="img-thumbnail w-100 h-100" >
          </div>

          <input type="text" class="form-control" name="alt_selected[${selImg}]" placeholder="Alt yazi elave edin">
        </div>
     `)
  } else {
    const filterImages = selectedImagesArray.filter(selImg => selImg != targetImage);
    selectedImagesArray = [...filterImages];
    selectedImages.innerHTML = "";
    selectedImagesArray.forEach(selImg => selectedImages.innerHTML += `
        <div class="selected-image-container d-flex flex-column gap-2 flex-shrink-0 justify-content-between " style="width:100px; height: 150px;">
        <label class="d-flex align-items-center">
          <span>Select main</span>
          <input class="mx-2" type="radio" name="selectMain"  value="${selImg}">

          </label>
          <div class="image_container" style="height: 80px;">

          <img src="${selImg}" class="img-thumbnail w-100 h-100" >
          </div>

          <input type="text" class="form-control" name="alt_selected[${selImg}]" placeholder="Alt yazi elave edin">
        </div>
     `)
  }
}))
