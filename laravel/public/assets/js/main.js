//Function Toggle Class
function toggleClass(element, className) {
    if (!element || !className) {
        return;
    }

    var classString = element.className,
        nameIndex = classString.indexOf(className);
    if (nameIndex == -1) {
        classString += ' ' + className;
    } else {
        classString = classString.substr(0, nameIndex) + classString.substr(nameIndex + className.length);
    }
    element.className = classString;
}

//Function Check HasClass
function hasClass(element, cls) {
    return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
}


// Function ToggleCheckboxs
function toggleCheckboxs(cbName) {
    var chk = event.target;
    var boxes = document.getElementsByName(cbName);

    //Check uncheck All
    if (chk.checked == true) {
        for (i = 0; i < boxes.length; i++)
            boxes[i].checked = true;
    } else {
        for (i = 0; i < boxes.length; i++)
            boxes[i].checked = false
    }
    // Uncheck check all
    for (i = 0; i < boxes.length; i++) {
        boxes[i].addEventListener('click', function () {
            if (!event.target.checked) {
                chk.checked = false;
            }
        });
    }
}

// Enabale Tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});


// Enabale overlayscrollbars
var {
    OverlayScrollbars,
    ScrollbarsHidingPlugin,
    SizeObserverPlugin,
    ClickScrollPlugin
} = OverlayScrollbarsGlobal;


// OS Theme Light
const customScrollsLight = document.querySelectorAll(".custom-scroll-light");
customScrollsLight.forEach((customScrollItem) => {
    OverlayScrollbars(customScrollItem, {
        scrollbars: {
            theme: 'os-theme-light'
        }
    });

});

// OS Theme Dark 
const customScrolls = document.querySelectorAll(".custom-scroll");
customScrolls.forEach((customScrollItem) => {
    OverlayScrollbars(customScrollItem, {});
});


/*--------------------
    Component: Sidebar 
--------------------*/

function sidebar_open() {
    document.body.classList.remove("sidebar-collapsed");
    localStorage.setItem('sidebar', '');
}
function sidebar_close() {
    document.body.classList.add("sidebar-collapsed");
    localStorage.setItem('sidebar', 'collapsed');
    //Pause Video when sidebar close
}
let btn_sidebar_open = document.querySelector('.btn-sidebar-open');

if (btn_sidebar_open !== null) {
    btn_sidebar_open.addEventListener('click', function () {
        sidebar_open();
    });
}
let btn_sidebar_close = document.querySelector('.btn-sidebar-close');
if (btn_sidebar_close !== null) {
    btn_sidebar_close.addEventListener('click', function () {
        sidebar_close();
    });
}
