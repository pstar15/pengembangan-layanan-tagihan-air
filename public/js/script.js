//script alert
setTimeout(() => {
    const alertBox = document.getElementById('alertBox');
    if(alertBox) {
        alertBox.style.transition = 'opacity 1s';
        alertBox.style.opacity = '0';
        setTimeout(() => alertBox.remove(), 1000);
    }
}, 5000);
// SCRIPT ALERT
document.addEventListener('DOMContentLoaded', function () {
    const alertBox = document.getElementById('alertBox');
    if (alertBox) {
        // Setelah 4 detik, mulai animasi slide keluar
        setTimeout(() => {
            alertBox.style.animation = 'slideOut 0.6s ease-in forwards';

            // Hapus elemen setelah animasi selesai
            setTimeout(() => {
                alertBox.remove();
            }, 600); // sama dengan durasi animasi
        }, 4000);
    }
});
// END SCRIPT ALERT
// SCRIPT SIDEBAR
document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const toggleButton = document.getElementById('sidebarToggle');

    const isSidebarOpen = localStorage.getItem('sidebarOpen');

    if (isSidebarOpen === 'false') {
        body.classList.remove('sidebar-open');
        body.classList.add('sidebar-collapsed');
    } else {
        body.classList.add('sidebar-open');
        body.classList.remove('sidebar-collapsed');
    }

    toggleButton?.addEventListener('click', function () {
        body.classList.toggle('sidebar-open');
        body.classList.toggle('sidebar-collapsed');

        const isOpen = body.classList.contains('sidebar-open');
        localStorage.setItem('sidebarOpen', isOpen);
    });
});
// END SCRIPT SIDEBAR
// SCRIPT TOGGLE PASSWORD
document.addEventListener("DOMContentLoaded", function () {
    const toggles = document.querySelectorAll(".toggle-password");

    toggles.forEach(function (toggle) {
        toggle.addEventListener("click", function () {
            const targetSelector = toggle.getAttribute("data-target");
            const input = document.querySelector(targetSelector);
            const icon = toggle.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            } else {
                input.type = "password";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            }
        });
    });
});
//END SCRIPT TOGGLE PASSWORD
// SCRIPT NOTIFIKASI POPUP
const icon = document.getElementById('notificationIcon');
const popup = document.getElementById('notificationPopup');

if (icon && popup) {
    icon.addEventListener('click', () => {
    popup.style.display = 'block';
    setTimeout(() => {
        popup.style.display = 'none';
    }, 8000);
    });
}
// END SCRIPT NOTIFIKASI POPUP
// SCRIPT TAMBAH AND EDIT DATA TAGIHAN
document.addEventListener("DOMContentLoaded", function () {
    const alertBox = document.querySelector(".alert-error");
    if (alertBox) {
        alertBox.style.opacity = 0;
        setTimeout(() => {
            alertBox.style.transition = "opacity 0.5s ease";
            alertBox.style.opacity = 1;
        }, 100);

        setTimeout(() => {
            alertBox.style.opacity = 0;
            setTimeout(() => {
                alertBox.remove();
            }, 500);
        }, 4000);
    }

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
// END SCRIPT TAMBAH AND EDTI DATA TAGIHAN
// SCRIPT FILTER DATA TAGIHAN
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
// EDN SCRIPT FILTER DATA TAGIHAN
// SCRIPT CARI DATA TAGIHAN
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('filterForm');
    const input = document.getElementById('keywordInput');
    const filterBtn = document.getElementById('filterBtn');
    const filterIcon = document.getElementById('filterIcon');

    if (input.value.trim() !== "") {
        filterBtn.classList.remove("btn-outline-primary");
        filterBtn.classList.add("btn-outline-danger");
        filterIcon.classList.remove("bi-search");
        filterIcon.classList.add("bi-x-lg");
        filterBtn.type = "button";
    }

    filterBtn.addEventListener('click', function () {
        if (filterBtn.type === "button") {
            window.location.href = "/tagihan";
        } else {
            form.submit();
        }
    });

    input.addEventListener('input', function () {
        if (input.value.trim() === "") {
            filterBtn.classList.remove("btn-outline-danger");
            filterBtn.classList.add("btn-outline-primary");
            filterIcon.classList.remove("bi-x-lg");
            filterIcon.classList.add("bi-search");
            filterBtn.type = "submit";
        }
    });
});
// END SCRIPT CARI DATA TAGIHAN
// SCRIPT DROPDOWN PESAN NOTIFIKASI
document.addEventListener('DOMContentLoaded', function () {
    const notifBtn = document.getElementById('notifikasiBtn');
    const dropdown = document.querySelector('.notifikasi-dropdown');
    let hasMarked = false;

    function bersihkanNotifikasi() {
        const dot = notifBtn.querySelector('.dot');
        if (dot) dot.remove();

        const items = dropdown.querySelectorAll('.dropdown-item');
        items.forEach(item => item.remove());

        const kosong = document.createElement('div');
        kosong.className = 'dropdown-item text-muted';
        kosong.textContent = 'Tidak ada notifikasi';
        dropdown.insertBefore(kosong, dropdown.querySelector('.dropdown-footer'));
    }

    notifBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        const isOpen = dropdown.classList.contains('show');

        if (!isOpen) {
            dropdown.classList.add('show');

            if (!hasMarked) {
                fetch('/notifikasi/markAllAsRead', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        hasMarked = true;
                    }
                });
            }

        } else {
            dropdown.classList.remove('show');
            bersihkanNotifikasi();
        }
    });

    document.addEventListener('click', function (e) {
        if (!notifBtn.contains(e.target) && !dropdown.contains(e.target)) {
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
                bersihkanNotifikasi();
            }
        }
    });
});
// END SCRIPT DROPDOWN PESAN NOTIFIKASI