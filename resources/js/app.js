import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.store("global", {
    qtyCart: 0,
    total_harga: 0,
    addCart(param, minus = null) {
        if (minus) {
            this.qtyCart -= param;
        } else {
            this.qtyCart += param;
        }
    },
});

Alpine.start();
