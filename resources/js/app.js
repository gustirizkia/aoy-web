import "./bootstrap";
import "tw-elements";
import "flowbite";
import Alpine from "alpinejs";
import { Modal } from "flowbite";

window.Alpine = Alpine;

Alpine.store("global", {
    qtyCart: 0,
    // transaksi
    total_harga: 0,
    biayaAdmin: 0,
    channel_pembayaran: [],
    sub_total: 0,
    diskon: 0,
    total_harga_barang: 0,
    // endTransaksi

    selectPembayaran: 0,
    addCart(param, minus = null) {
        if (minus) {
            this.qtyCart -= param;
        } else {
            this.qtyCart += param;
        }
    },

    numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
});

Alpine.start();
