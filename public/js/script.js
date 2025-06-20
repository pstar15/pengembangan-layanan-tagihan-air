//script alert
setTimeout(() => {
    const alertBox = document.getElementById('alertBox');
    if(alertBox) {
        alertBox.style.transition = 'opacity 1s';
        alertBox.style.opacity = '0';
        setTimeout(() => alertBox.remove(), 1000);
    }
}, 5000);
//sidebar
document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const toggleButton = document.getElementById('sidebarToggle');

    // Baca status sidebar dari localStorage
    const isSidebarOpen = localStorage.getItem('sidebarOpen');

    if (isSidebarOpen === 'false') {
        body.classList.remove('sidebar-open');
        body.classList.add('sidebar-collapsed');
    } else {
        body.classList.add('sidebar-open');
        body.classList.remove('sidebar-collapsed');
    }

    // Event toggle klik
    toggleButton?.addEventListener('click', function () {
        body.classList.toggle('sidebar-open');
        body.classList.toggle('sidebar-collapsed');

        // Simpan status
        const isOpen = body.classList.contains('sidebar-open');
        localStorage.setItem('sidebarOpen', isOpen);
    });
});
// script Tambah data tagihan dan Edit data Tagihan
document.addEventListener("DOMContentLoaded", function () {
    // Fade in alert
    const alertBox = document.querySelector(".alert-error");
    if (alertBox) {
        alertBox.style.opacity = 0;
        setTimeout(() => {
            alertBox.style.transition = "opacity 0.5s ease";
            alertBox.style.opacity = 1;
        }, 100);

        // Auto dismiss after 4s
        setTimeout(() => {
            alertBox.style.opacity = 0;
            setTimeout(() => {
                alertBox.remove();
            }, 500);
        }, 4000);
    }

    // script Input Focus
    const inputs = document.querySelectorAll(".form-tagihan input, .form-tagihan select");
    inputs.forEach((input) => {
        input.addEventListener("focus", () => {
            input.style.boxShadow = "0 0 5px rgba(41, 128, 185, 0.4)";
        });
        input.addEventListener("blur", () => {
            input.style.boxShadow = "none";
        });
    });
});
//script Filter Data Tagihan
document.addEventListener('DOMContentLoaded', function () {
    const filter = document.getElementById('statusFilter');
    const rows = document.querySelectorAll('.tagihan-row');

    filter.addEventListener('change', function () {
        const value = this.value;

        rows.forEach(row => {
            const isLunas = row.classList.contains('status-lunas');
            const isBelum = row.classList.contains('status-belum');

            if (value === 'all') {
                row.style.display = '';
            } else if (value === 'lunas' && isLunas) {
                row.style.display = '';
            } else if (value === 'belum' && isBelum) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
//script loading pencarian data tagihan
const form = document.querySelector('.search-form');
form.addEventListener('submit', function() {
    const button = form.querySelector('button');
    button.disabled = true;
    button.innerHTML = '⏳';
    button.style.display = 'none';
    button.style="margin-top: 10px;";
});
