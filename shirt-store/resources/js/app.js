import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// ── Toast Auto-dismiss ──────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const toasts = document.querySelectorAll('[data-toast]');
    toasts.forEach(toast => {
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    });
});
