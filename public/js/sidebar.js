document.addEventListener("DOMContentLoaded", function () {
    const path = window.location.pathname;

    document.querySelectorAll(".sidebar-link").forEach(link => {
        link.classList.remove("active");
    });

    if (path.includes("/auth/dashboard")) {
        document.getElementById("sidebar-dashboard")?.classList.add("active");
    } else if (path.includes("/tagihan") && !path.includes("riwayat")) {
        document.getElementById("sidebar-tagihan")?.classList.add("active");
    } else if (path.includes("/riwayat-tagihan")) {
        document.getElementById("sidebar-riwayat")?.classList.add("active");
    }
});