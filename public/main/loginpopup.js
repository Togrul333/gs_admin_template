const login_btn = document.querySelectorAll(".login_btn")
const closeBtn = document.querySelector(".close_modal_popup");


login_btn.forEach(logBtn => logBtn.addEventListener("click",() =>{
     document.querySelector(".modal_pop_up").classList.remove("d-none") 
}))
closeBtn.addEventListener("click", () => document.querySelector(".modal_pop_up").classList.add("d-none"))
