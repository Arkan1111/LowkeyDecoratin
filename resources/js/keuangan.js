document.addEventListener('DOMContentLoaded', function () {
    // Mobile sidebar toggle
    const sidebar = document.getElementById('financeSidebar');
    const sidebarToggle = document.getElementById('financeSidebarToggle');

    if (sidebar && sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            const opened = sidebar.classList.toggle('is-open');
            sidebarToggle.setAttribute('aria-expanded', String(opened));
        });

        document.addEventListener('click', function (event) {
            if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('is-open');
                sidebarToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // Search payment and petty-cash rows (demo frontend only)
    const search = document.getElementById('financeSearch');
    const searchableItems = document.querySelectorAll('.finance-search-item');

    if (search) {
        search.addEventListener('input', function () {
            const keyword = search.value.trim().toLocaleLowerCase('id-ID');

            searchableItems.forEach(function (item) {
                const matches = item.textContent.toLocaleLowerCase('id-ID').includes(keyword);
                item.hidden = !matches;
            });
        });
    }

    // Display current local date in Indonesian format
    const dateElement = document.getElementById('financeCurrentDate');
    if (dateElement) {
        dateElement.textContent = new Intl.DateTimeFormat('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }).format(new Date());
    }
});
