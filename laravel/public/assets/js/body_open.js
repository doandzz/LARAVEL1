function check_sidebar() {

    // Check Sidebar Toggle
    var sidebar = localStorage.getItem('sidebar');
    if (sidebar == 'collapsed') {
        document.body.classList.add("sidebar-collapsed");
    } else {
        document.body.classList.remove("sidebar-collapsed");
    }

}
check_sidebar();