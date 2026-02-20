import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

// Toast Component
Alpine.data("toastComponent", () => ({
    toasts: [],

    init() {
        // Listen for toast events
        window.addEventListener("toast", (event) => {
            this.add(event.detail);
        });
    },

    add(toast) {
        const id = Date.now() + Math.random();
        const newToast = { id, ...toast, visible: true };
        this.toasts.push(newToast);

        // Auto remove after 5 seconds
        setTimeout(() => {
            this.remove(id);
        }, 5000);
    },

    remove(id) {
        const index = this.toasts.findIndex((toast) => toast.id === id);
        if (index > -1) {
            this.toasts[index].visible = false;
            setTimeout(() => {
                this.toasts.splice(index, 1);
            }, 300);
        }
    },
}));

// Global toast function
window.showToast = (message, type = "info") => {
    window.dispatchEvent(
        new CustomEvent("toast", {
            detail: { message, type },
        }),
    );
};

Alpine.start();
