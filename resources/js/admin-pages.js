document.addEventListener('DOMContentLoaded', () => {
    const toast = document.querySelector('.admin-toast');
    let toastTimer;

    const showToast = (message) => {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('is-visible');
        window.clearTimeout(toastTimer);
        toastTimer = window.setTimeout(() => toast.classList.remove('is-visible'), 3200);
    };

    // Modal open / close
    document.querySelectorAll('[data-modal-open]').forEach((button) => {
        button.addEventListener('click', () => {
            const modal = document.getElementById(button.dataset.modalOpen);
            if (modal) {
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
            }
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach((button) => {
        button.addEventListener('click', () => {
            const modal = button.closest('.admin-modal');
            if (modal) {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
            }
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            document.querySelectorAll('.admin-modal.is-open').forEach((modal) => {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
            });
        }
    });

    // Package / add-on tabs
    document.querySelectorAll('[data-admin-tab]').forEach((button) => {
        button.addEventListener('click', () => {
            const tabGroup = button.closest('.admin-feature-panel');
            if (!tabGroup) return;
            tabGroup.querySelectorAll('[data-admin-tab]').forEach((tab) => tab.classList.remove('active'));
            tabGroup.querySelectorAll('.admin-tab-panel').forEach((panel) => panel.classList.remove('active'));
            button.classList.add('active');
            const panel = document.getElementById(button.dataset.adminTab);
            if (panel) panel.classList.add('active');
        });
    });

    // Search rows in a table
    document.querySelectorAll('[data-table-search]').forEach((input) => {
        const tableId = input.dataset.tableSearch;
        const table = document.getElementById(tableId);
        if (!table) return;
        const filter = document.querySelector(`[data-table-filter="${tableId}"]`);

        const applyFilter = () => {
            const query = input.value.trim().toLocaleLowerCase('id');
            const selected = filter ? filter.value.trim().toLocaleLowerCase('id') : '';
            table.querySelectorAll('tbody tr').forEach((row) => {
                const text = row.innerText.toLocaleLowerCase('id');
                const matchesSearch = !query || text.includes(query);
                const matchesFilter = !selected || text.includes(selected);
                row.hidden = !(matchesSearch && matchesFilter);
            });
        };

        input.addEventListener('input', applyFilter);
        if (filter) filter.addEventListener('change', applyFilter);
    });

    // Search portfolio cards
    document.querySelectorAll('[data-card-search]').forEach((input) => {
        const grid = document.getElementById(input.dataset.cardSearch);
        if (!grid) return;
        input.addEventListener('input', () => {
            const query = input.value.trim().toLocaleLowerCase('id');
            grid.querySelectorAll('.admin-portfolio-card').forEach((card) => {
                card.hidden = query && !card.innerText.toLocaleLowerCase('id').includes(query);
            });
        });
    });

    // Portfolio category filter
    document.querySelectorAll('[data-portfolio-filter]').forEach((button) => {
        button.addEventListener('click', () => {
            const category = button.dataset.portfolioFilter;
            document.querySelectorAll('[data-portfolio-filter]').forEach((tab) => tab.classList.remove('active'));
            button.classList.add('active');
            document.querySelectorAll('#portfolioGrid .admin-portfolio-card').forEach((card) => {
                card.hidden = category !== 'all' && card.dataset.category !== category;
            });
        });
    });

    // Fill reservation detail modal from the selected row
    document.querySelectorAll('[data-reservation-detail]').forEach((button) => {
        button.addEventListener('click', () => {
            const fields = {
                detailCode: 'code',
                detailCustomer: 'customer',
                detailEvent: 'event',
                detailPackage: 'package',
                detailDate: 'date',
                detailLocation: 'location',
                detailStatus: 'status'
            };
            Object.entries(fields).forEach(([id, key]) => {
                const target = document.getElementById(id);
                if (target) target.textContent = button.dataset[key] || '-';
            });
            const modal = document.getElementById('reservationDetailModal');
            if (modal) {
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
            }
        });
    });

    // Demo forms intentionally do not submit to a backend
    document.querySelectorAll('[data-demo-form]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            showToast('Tampilan demo: data belum disimpan. Hubungkan form ke backend saat integrasi.');
            const modal = form.closest('.admin-modal');
            if (modal) {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
            }
            form.reset();
        });
    });

    // Frontend-only row actions
    document.querySelectorAll('[data-demo-action]').forEach((button) => {
        button.addEventListener('click', () => {
            const action = button.dataset.demoAction;
            if (action === 'delete') {
                showToast('Aksi hapus masih berupa demo dan belum mengubah data.');
            } else {
                showToast('Form edit akan dihubungkan pada tahap integrasi backend.');
            }
        });
    });
});
