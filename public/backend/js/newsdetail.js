const selectLanguageChecks = document.querySelectorAll(".tab_check");
const selectedLanguageTabPanels = document.querySelectorAll('.tab_panel_check');
const headingPanels = document.querySelectorAll(".panel_check");
const mobileTabChecks = document.querySelectorAll('.mobile_tab_check');


if (selectLanguageChecks.length > 2) {
    selectedLanguageTabPanels.forEach((pan, idx) => {
        if (idx != 0) {
            pan.classList.add("d-none")
        }
    });


    headingPanels.forEach((pan, idx) => {
        if (idx != 0) {
            pan.classList.add("d-none")
        }
    });
} else {
    if (selectLanguageChecks[0].id == 1) {
        selectedLanguageTabPanels.forEach((pan, idx) => {
            if (idx != 1) {
                pan.classList.add("d-none")
            }
        });


        headingPanels.forEach((pan, idx) => {
            if (idx != 1) {
                pan.classList.add("d-none")
            }
        });
    } else if (selectLanguageChecks[0].id == 0) {
        selectedLanguageTabPanels.forEach((pan, idx) => {
            if (idx != 0) {
                pan.classList.add("d-none")
            }
        });


        headingPanels.forEach((pan, idx) => {
            if (idx != 0) {
                pan.classList.add("d-none")
            }
        });
    } else if (selectLanguageChecks[0].id == 2) {
        selectedLanguageTabPanels.forEach((pan, idx) => {
            if (idx != 2) {
                pan.classList.add("d-none")
            }
        });


        headingPanels.forEach((pan, idx) => {
            if (idx != 2) {
                pan.classList.add("d-none")
            }
        });
    }
}
selectLanguageChecks[0].style.opacity = "1"


if (selectLanguageChecks.length == 1) {
    selectLanguageChecks[0].click()

}
mobileTabChecks[0].classList.add('language_container_mobile_active');


selectLanguageChecks.forEach(select => {
    select.addEventListener("click", (e) => {
        selectLanguageChecks[0].style.opacity = '0.5'
        e.preventDefault();

        selectLanguageChecks.forEach(s => {
            if (s.id == e.target.parentElement.id) {
                s.classList.add("active")
            } else {
                s.classList.remove('active')
            }
        })
        selectedLanguageTabPanels.forEach((selects, i) => {
            if (i == e.target.parentElement.id) {
                const checkClassName = selects.className;

                if (checkClassName.includes('d-none')) {
                    selects.classList.remove("d-none")
                } else {

                }
            } else {
                selects.classList.add("d-none");
            }
        });


        headingPanels.forEach((selects, i) => {
            if (i == e.target.parentElement.id) {
                const checkClassName = selects.className;

                if (checkClassName.includes('d-none')) {
                    selects.classList.remove("d-none")
                } else {

                }
            } else {
                selects.classList.add("d-none");
            }
        })
    })
})

mobileTabChecks.forEach((select, idx) => {
    select.addEventListener("click", (e) => {

        e.preventDefault();
        console.log(e.target);
        mobileTabChecks.forEach(s => {
            if (s.id == e.target.id) {

                s.classList.add("language_container_mobile_active")
            } else {
                s.classList.remove('language_container_mobile_active')
            }
        })
        selectedLanguageTabPanels.forEach((selects, i) => {
            if (i == idx) {
                const checkClassName = selects.className;

                if (checkClassName.includes('d-none')) {
                    selects.classList.remove("d-none")
                } else {

                }
            } else {
                selects.classList.add("d-none");
            }
        });


        headingPanels.forEach((selects, i) => {
            if (i == idx) {
                const checkClassName = selects.className;

                if (checkClassName.includes('d-none')) {
                    selects.classList.remove("d-none")
                } else {

                }
            } else {
                selects.classList.add("d-none");
            }
        })
    })
})