document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("custMenuToggle");
    const navbarContent = document.getElementById("custNavbarContent");

    if (!menuToggle || !navbarContent) return;

    // Membuka dan menutup menu navigasi
    menuToggle.addEventListener("click", function () {
        const isExpanded = menuToggle.getAttribute("aria-expanded") === "true";

        menuToggle.setAttribute("aria-expanded", String(!isExpanded));

        navbarContent.classList.toggle("is-open", !isExpanded);
    });

    // Menutup menu setelah link diklik
    navbarContent.querySelectorAll("a").forEach(function (link) {
        link.addEventListener("click", function () {
            navbarContent.classList.remove("is-open");

            menuToggle.setAttribute("aria-expanded", "false");
        });
    });
});
