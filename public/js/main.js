
function init() {
    initCheckEditor();
    initEvents();
    showModalCookies();
}

function initEvents() {
    if (document.getElementById("icon-search")) {
        document.getElementById("icon-search").addEventListener("click", function () {
            showHideSearch();
        });
    }
    if (document.getElementById("password")) {
        document.getElementById("password").addEventListener("keyup", function (e) {
            let regex = new RegExp(/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,20}$/);
            validateField("password", regex);
        })
    }
    if (document.getElementById("email")) {
        document.getElementById("email").addEventListener("keyup", function (e) {
            let regex = new RegExp(/^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/);
            validateField("email", regex);
        })
    }
    if (document.getElementById("formUser")) {
        document.getElementById("formUser").addEventListener("submit", function (e) {
            let regexPass = new RegExp(/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,20}$/);
            validateField("password", regexPass);
            regexEmail = new RegExp(/^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/);
            validateField("email", regexEmail);
        })
    }
    if (document.getElementsByName("back") && document.getElementsByName("back").length > 0) {
        document.getElementsByName("back")[0].addEventListener("click", function () {
            window.history.back();
        })
    }

    if (document.getElementById("accept-cookies")) {
        document.getElementById("accept-cookies").addEventListener("click", function () {
            closeModalCookies();
        })
    }

    hljs.initHighlightingOnLoad();

    if (document.querySelectorAll('pre code').length > 0) {
        document.querySelectorAll('pre code').forEach((block) => {
            hljs.highlightBlock(block);
        });
    }

}

function validateField(id, regex) {

    let value = document.getElementById(id).value;

    if (regex.test(value)) {
        document.getElementById(id).setAttribute("class", "form-control is-valid");

    } else {
        document.getElementById(id).setAttribute("class", "form-control is-invalid");
        event.preventDefault();
    }
}


function initCheckEditor() {

    if (document.querySelector('#editor')) {

        var config = {
            extraPlugins: 'codesnippet',
            codeSnippet_theme: 'monokai_sublime',
            height: 356
        };
        CKEDITOR.replace('editor', config);
    }

}

function showHideSearch() {

    const formSearch = document.getElementById("form-search");
    const iconSearch = document.getElementById("icon-search");

    if (formSearch.getAttribute("class").includes("d-none")) {
        formSearch.setAttribute("class", "d-block");
        iconSearch.setAttribute("class", "fa fa-times");
    } else {
        formSearch.setAttribute("class", "d-none");
        iconSearch.setAttribute("class", "fa fa-search");
    }

}

function showModalCookies() {

    const cookies = localStorage.getItem("cookies");

    if (!cookies) {
        $('#cookies').modal('show');
    }

}

function closeModalCookies() {

    localStorage.setItem("cookies", "1");
    $('#cookies').modal('hide');
}



window.onload = init;