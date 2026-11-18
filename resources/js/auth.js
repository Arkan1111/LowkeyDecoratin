document.addEventListener("DOMContentLoaded", function () {
    // Menampilkan dan menyembunyikan password
    const password = document.getElementById("password");
    const toggle = document.getElementById("passwordToggle");

    if (password && toggle) {
        toggle.addEventListener("click", function () {
            const showPassword = password.type === "password";

            password.type = showPassword ? "text" : "password";

            toggle.setAttribute(
                "aria-label",
                showPassword
                    ? "Sembunyikan kata sandi"
                    : "Tampilkan kata sandi",
            );
        });
    }

    // Pilihan Klien dan Admin
    const tabs = document.querySelectorAll(".auth-tab");
    const info = document.getElementById("authInfoText");

    const messages = {
        customer:
            "Akses papan inspirasi, jadwal fitting dekorasi & rincian reservasi pernikahan.",

        staff: "Akses portal internal untuk pengelolaan reservasi, pelanggan, dan operasional Loki Decoration.",
    };

    tabs.forEach(function (tab) {
        tab.addEventListener("click", function () {
            tabs.forEach(function (item) {
                item.classList.remove("active");
                item.setAttribute("aria-pressed", "false");
            });

            tab.classList.add("active");
            tab.setAttribute("aria-pressed", "true");

            info.textContent = messages[tab.dataset.portal];
        });
    });
});
