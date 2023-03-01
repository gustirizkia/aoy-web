@extends('layouts.dashboard')

@section('title')
    Buat Invoice Penjualan
@endsection

@push('addStyle')
    <style>
        .card__produk{
            box-shadow: unset;
            border: 1px solid rgba(217, 217, 217, 0.48);
        }
        .card__produk .form-control{
            width: 80px;
        }
        .card__produk img{
            width: 60px;
            margin-right: 10px;
        }
        .pilih__lainnya{
            background: #F7F5FF;
            border-radius: 4px;
            color: #A349A3;
            font-size: 14px;
            cursor: pointer;
        }
        .tambah__Produk{
            background: #EDEDED;
            border: 1px solid rgba(217, 217, 217, 0.48);
            border-radius: 4px;
            color: #5B5B5B;
            cursor: pointer;
        }

        .form-check-input-custom{
            width: 20px;
            height: 20px;
            border-radius: 20px;
        }

    </style>
@endpush

@section('content')
    <div class="card" x-data="funcData">
        <div class="card-body">
            <h4>Pilih Produk</h4>
            <div class="">
                <template x-for="(produk, index) in selectProduk" :key="index">
                    <div class="card card__produk p-2 mt-2">
                        <div class="row">
                            <div class="col d-flex">
                                <img :src="produk.image" alt="" class="img-fluid">
                                <div class="" style="font-size: 14px">
                                    <div class=""> <span x-text="produk.nama"></span></div>
                                    <div class="text__primary font-weight-bold"><span x-text="'Rp'+$store.global.numberWithCommas(produk.harga)"></span></div>
                                </div>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" placeholder="0" x-model="produk.qty">
                            </div>
                            <div class="col d-flex align-items-center justify-content-end " >
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" @click="handleRemove(produk.id)">
                                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM17 13H7V11H17V13Z" fill="#FF0000"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="mt-2" x-show="showAddProduk">
                <div class="tambah__Produk p-3 text-center font-weight-bold" @click="handleTambahProduk">
                    Klik untuk tambah produk
                </div>
            </div>

            <div class="mt-5">
                <div class="mb-3">
                    <h5>Subtotal <span x-text="'Rp'+$store.global.numberWithCommas(totalHarga)"></span></h5>
                    <h5>keuntungan <span x-text="'Rp'+$store.global.numberWithCommas(potongan.diskon)"></span></h5>
                </div>
                <div class="btn btn__primary " @click="handleSimpan">
                    Buat Transaksi
                </div>
            </div>
        </div>
    </div>
@endsection


@push('addScript')
<script>
    function funcData(){
        return{
            produks:[
                @foreach($produk as $item)
                {
                    id: {{ $item->produk->id }},
                    nama: "{{ $item->produk->nama }}",
                    image: "{{ url('/').'/'.$item->produk->thumbnail->photo }}",
                    harga: {{ $item->produk->harga }},
                    qty: {{ $item->qty }}
                },
                @endforeach
            ],
            pilihan: [0],
            showAddProduk: true,
            selectProduk: [],
            potongan: {
                    harga: {{ $member->potongan_harga }},
                    tipe_potongan: "{{ $member->tipe_potongan }}",
                    total_potongan: 0,
                    diskon: 0,
            },
            totalHarga: 0,

            handleTambahProduk(){

                let nextIndex = 0;
                this.selectProduk.push(
                    {
                        id: this.produks[nextIndex].id,
                        qty: 1,
                        max_qty: this.produks[nextIndex].qty,
                        image: this.produks[nextIndex].image,
                        harga: this.produks[nextIndex].harga,
                        nama: this.produks[nextIndex].nama,
                    },
                );



                if(this.selectProduk.length >= this.produks.length){
                    this.showAddProduk = false;
                }
                this.produks.splice(nextIndex, 1);
                this.handleSubtotal()
            },

            hanldeChangeSelectProduk(id_produk, index_produk){

            },

            handleSubtotal(){
                this.totalHarga = 0;
                this.potongan= {
                        harga: {{ $member->potongan_harga }},
                        tipe_potongan: "{{ $member->tipe_potongan }}",
                        total_potongan: 0,
                        diskon: 0,
                },

                this.selectProduk.forEach(item => {
                    this.totalHarga += item.harga*item.qty;

                    if(this.potongan.tipe_potongan === 'fix'){
                        // potong tiap satuan produk
                        let potonganProduk = this.potongan.harga*item.qty;

                        this.potongan.diskon  += potonganProduk;
                        this.potongan.total_potongan = this.totalHarga - this.potongan.diskon;
                    }else{
                        let nilai = (this.potongan.harga/100)*item.harga;
                        let potonganProduk = nilai*item.qty;

                        this.potongan.diskon += potonganProduk;
                        this.potongan.total_potongan += this.totalHarga - potonganProduk;
                    }
                });
            },

            handleRemove(id){
                const index = this.selectProduk.findIndex(key => key.id === id);
                if(this.produks.length > 1){
                    this.produks.push({
                        id: this.selectProduk[index].id,
                        nama: this.selectProduk[index].nama,
                        harga: this.selectProduk[index].harga,
                        image: this.selectProduk[index].image,
                        qty: this.selectProduk[index].max_qty,
                    });

                    this.selectProduk.splice(index, 1)

                    this.showAddProduk = true;
                    this.handleSubtotal();
                }

            },

            handleSimpan(){
                console.log('this.selectProduk =simpan======', this.selectProduk)
                axios.post("{{ route('invPenjualan') }}", {
                    produk: this.selectProduk
                }, {
                    csrfToken: "{{ csrf_token() }}",
                }).then(res =>{
                })
            },

            init(){

                this.selectProduk.push(
                    {
                        id: this.produks[0].id,
                        qty: 1,
                        max_qty: this.produks[0].qty,
                        image: this.produks[0].image,
                        harga: this.produks[0].harga,
                        nama: this.produks[0].nama,
                    },
                );

                if(this.produks.length < 2){
                    this.showAddProduk = false;
                }

                this.produks.splice(0, 1);

                this.$watch('selectProduk', (value, oldValue) =>{
                    this.selectProduk.forEach((element, index) => {
                        qty = parseInt(element.qty);
                        if(element.max_qty < qty){
                            this.selectProduk[index].qty = element.max_qty;
                        }
                        if(qty < 1){
                           this.selectProduk[index].qty = 1;
                        }

                        this.handleSubtotal()

                    });
                    console.log('value', value)
                    console.log('oldValue', oldValue)
                });

                this.handleSubtotal()
            },
        }
    }
</script>
@endpush
