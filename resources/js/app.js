import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.store("global", {
    qtyCart: 0,
    addCart(param) {
        this.qtyCart += param;
    },
});

Alpine.start();
