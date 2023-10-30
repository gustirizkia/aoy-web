@extends('layouts.dashboard')

@section('title')
    Lengkapi Profile
@endsection

@push('addStyle')
    <style>
        .img__profile{
            width: 90px;
            height: 90px;
            object-fit: cover;
            object-position: center;
            border-radius: 50%;
            cursor: pointer;
        }
        .card__alamat{
            box-shadow: unset;
        }
        .list__alamat{
            box-shadow: unset;
            border: 1px rgb(227, 227, 227) solid;

        }
        .list__alamat.active{
            border: 1px #a349a3 solid;
        }
        .btn__ubah__alamat{
            border: 1px rgb(123, 123, 123) solid;
            color: rgb(123, 123, 123);
            display: block;
            font-size: 14px;
        }
        .btn__ubah__alamat:hover{
            background-color: rgb(123, 123, 123);
            color: white;
        }
        .card__tambah__alamat{
            background-color: rgb(123, 123, 123);
            color: white;
            cursor: pointer;
        }
        .text__edit__alamat{
            font-weight: bold;
            font-size: 12px;
        }
        .text-garis{
            color: rgb(217, 217, 217);
        }
    </style>
@endpush

@section('content')
    <div class="card" x-data="funcData">
        <template  x-if="!showAddAlamat">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Perhatikan!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('updateProfile') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="d-flex justify-content-center">
                        <input type="file"  x-ref="imageRef" class="d-none" name="photo" @change="onFileChange">
                        <div class="text-center">
                            <img :src="img_profile" @click="$refs.imageRef.click()" alt="skincare aoy" class="img-fluid img__profile">
                            <div class="">
                                <small @click="$refs.imageRef.click()">klik untuk ubah photo</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                    </div>
                    <div class="card card__alamat mt-4">
                        <template  x-if="!showAddAlamat">
                            <div  class="card-body">
                                <h5>Alamat Anda</h5>
                                <div class="row">
                                    @foreach ($alamat as $item)
                                    <div class="col-md-4 mb-3">
                                        <div class="card list__alamat h-100 " :class="{{ $item->id }} === alamat_utama_id ? 'active' : '' ">
                                            <div class="card-body d-flex justify-content-between flex-column" >
                                                <h6 style="    font-size: 12px; font-weight: 600;"> {{ $item->kota->name }}, {{ $item->kecamatan->subdistrict_name }}, {{ $item->provinsi->name }}</h6>
                                                <p style="font-size: 10px; color: rgb(75, 75, 75)">{{ $item->address }}</p>

                                                <div class="d-flex">
                                                    <a href="{{ route('edit-alamat-dashboard', $item->id) }}" class="btn btn__outline__primary text__edit__alamat">Ubah Alamat</a>
                                                    <div class="mx-3 text-garis">|</div>
                                                    <div class="btn btn__primary text__edit__alamat cursor-pointer" @click="changeActiveAlamat({{ $item->id }})">Pilih</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    @endforeach
                                    <div class="col-md-4  mb-3">
                                        <div class="card card__tambah__alamat h-100" @click="openModaltambahAlamat">
                                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                                <div  class="text-center">Klik Untuk <br> Tambah Alamat</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn__primary">Simpan Profile</button>
                        </div>
                    </div>
                </form>

            </div>
        </template>

        <template  x-if="showAddAlamat">
            <div class="card-body">

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="">Provinsi</label>
                        <select  id="" class="form-control" x-model="provinsi_id">
                            <option value="0">Pilih Provinsi</option>
                            @foreach ($provinsi as $item)
                                <option value="{{ $item->province_id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="">Kota</label>
                        <select  id="" class="form-control" x-model="city_id">
                            <option value="0">Pilih Kota/Kabupaten</option>
                            <template x-for="kota in list_kota" :key="kota.id">
                            <option :value="kota.city_id" x-text="kota.name"></option>
                            </template>
                        </select>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="">Kecamatan</label>
                        <select  id="" class="form-control" x-model="kecamatan_id">
                            <option value="0">Pilih Kecamatan</option>
                            <template x-for="kecamatan in list_kecamatan" :key="kecamatan.subdistrict_id">
                            <option :value="kecamatan.subdistrict_id" x-text="kecamatan.subdistrict_name"></option>
                            </template>
                        </select>
                    </div>
                    <div class="mb-3 col-md-12 ">
                        <label for="">Alamat Lengkap</label>
                        <input type="text" class="form-control" x-model="alamat_lengkap" placeholder="desa, RT/RW">
                    </div>

                    <div class="col-md-12">
                        <div class="btn btn__primary" @click="handleSimpanAlamat">Simpan Alamat</div>
                    </div>
                </div>
            </div>
        </template>
    </div>

@endsection

@push('addScript')
    <script>
        function funcData(){
            return{
                img_profile: "{{ $user->photo ? url("storage/$user->photo") : asset('gambar/user.png') }}",
                showAddAlamat: true,
                provinsi_id: 0,
                city_id: 0,
                kecamatan_id: 0,
                list_kota: [],
                list_kecamatan: [],
                alamat_lengkap: null,
                alamat_utama_id: {{ $alamat_utama ? $alamat_utama->id : 0 }},
                onFileChange(e)
                {
                    if (e.target.files.length !== 0) {
                        const file = e.target.files[0]
                        let urlimage = URL.createObjectURL(file)
                        this.img_profile = urlimage;
                    }
                },
                openModaltambahAlamat(){
                    if(this.showAddAlamat){
                        this.showAddAlamat = false;
                    }else{
                        this.showAddAlamat = true;
                    }
                },

                changeActiveAlamat(id){
                    axios.get("{{ route('changeActive') }}?address_id="+id).then(res => {
                        this.alamat_utama_id = id;
                        Swal.fire({
                            icon: 'success',
                            title: 'Pilih alamat utaman berhasil',
                            toast: true,
                            position: 'bottom-center',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    });
                },

                handleSimpanAlamat(){
                    let form = {
                        subdistrict_id: parseInt(this.kecamatan_id),
                        city_id: parseInt(this.city_id),
                        province_id: parseInt(this.provinsi_id),
                        address: this.alamat_lengkap
                    };

                    if(this.provinsi_id === 0 ){
                        Swal.fire({
                            icon: 'info',
                            // title: 'Pilih kecamatan terlebih dahulu',
                            text: 'Pilih provinsi terlebih dahulu'
                        });
                    }else if(this.city_id === 0){
                       Swal.fire({
                            icon: 'info',
                            text: 'Pilih kota/kabupaten terlebih dahulu',
                        });
                    }else if(this.kecamatan_id === 0){
                        Swal.fire({
                            icon: 'info',
                            text: 'Pilih kecamatan terlebih dahulu',
                        });
                    }else if(this.alamat_lengkap === null){
                       Swal.fire({
                            icon: 'info',
                            text: 'Isi alamat terlebih dahulu',
                        });
                    }else{

                        axios.post("{{ route('tambah-alamat') }}", form, {
                            csrfToken: "{{ csrf_token() }}",
                        }).then(res => {
                            console.log('res tambah data', res)
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil tambah alamat',
                            });

                            // this.showAddAlamat = false;
                            @if(request()->get("keranjang"))
                                window.location.replace("/keranjang");
                            @else
                                window.location.replace("/produk");
                            @endif

                            // location.reload();
                        }).catch(err => {
                            console.log('ada error', err)
                        });
                    }

                },

                init(){
                    this.$watch("provinsi_id", (value, oldValue) => {
                        axios.get("{{ route('list-kota') }}?provinsi_id="+value).then(res =>{

                            this.list_kota = res.data;
                        })
                    });

                    this.$watch('city_id', (value, oldValue) => {
                        console.log('value city_id', value)
                        axios.get("{{ route('list-kecamatan') }}?city_id="+value).then(res => {
                            this.list_kecamatan = res.data;
                        });
                    });
                }
            }
        }
    </script>
@endpush
