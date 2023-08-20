@extends('layouts.dashboard')

@section('title')
    Gabung Member
@endsection

@push('addStyle')
    <style>
        .logo__image_edit {
            width: 220px;
            border-radius: 10px;
            padding: 6px;
        }

        .shape_edit {
            position: absolute;
            right: 4px;
            bottom: 30px;
        }

        .delete_image {
            background-color: red;
            color: white;
            position: absolute;
            top: -6px;
            right: -6px;
            border-radius: 50%;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <form action="{{ route('store-setting') }}" method="post">
        @csrf
        <div class="card" x-data="funcDataStore">
            <div class="card-body">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <h5 class="text-center">
                            Dapatkan penawaran terbaik <br> dan terhubung seluruh seller di Indonesia
                        </h5>
                        <p class="text-secondary text-center">
                            Isi dengan lengkap form pendaftaran ini
                        </p>
                        <img src="{{ asset('gambar/open-store.jpg') }}" class="img-fluid" alt="AY'S ON YOU">
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-12 mb-4">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <h6 class="text-center mb-3">Profile Toko</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Nama toko</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    name="nama" placeholder="nama toko" value="{{ old('nama') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">No WhatsApp</label>
                                <input type="number" name="nomor_wa"
                                    class="form-control @error('nomor_wa') is-invalid @enderror" placeholder="nomor wa"
                                    value="{{ old('nomor_wa') }}">
                            </div>
                            <div class="col-md-6
                                    mb-3">
                                <label for="">Akun Instagram</label>
                                <input type="text" name="akun_ig"
                                    class="form-control @error('akun_ig') is-invalid @enderror" placeholder="akun ig toko"
                                    value="{{ old('akun_ig') }}">
                            </div>
                            <div class="col-md-6
                                    mb-3">
                                <label for="">Tentang Toko</label>
                                <input type="text" name="deskripsi" value="{{ old('deskripsi') }}"
                                    class="form-control @error('deskripsi') is-invalid @enderror"
                                    placeholder="tentang toko">
                            </div>

                            <div class="col-12 my-2">
                                <h6 class="text-center">Alamat Toko</h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="">Provinsi</label>
                                <select x-model="provinsi_id" name="provinsi"
                                    class="form-control @error('provinsi') is-invalid @enderror">
                                    <option>Pilih provinsi</option>
                                    @foreach ($provinsi as $item)
                                        <option value="{{ $item->province_id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Kota/Kabupaten</label>
                                <select id="" class="form-control @error('city_id') is-invalid @enderror"
                                    x-model="city_id" name="city_id">
                                    <option value="0">Pilih Kota/Kabupaten</option>
                                    <template x-for="kota in list_kota" :key="kota.id">
                                        <option :value="kota.city_id" x-text="kota.name"></option>
                                    </template>
                                </select>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Kecamatan</label>
                                <select id="" class="form-control @error('kecamatan_id') is-invalid @enderror"
                                    x-model="kecamatan_id" name="kecamatan_id">
                                    <option value="0">Pilih Kecamatan</option>
                                    <template x-for="kecamatan in list_kecamatan" :key="kecamatan.subdistrict_id">
                                        <option :value="kecamatan.subdistrict_id" x-text="kecamatan.subdistrict_name">
                                        </option>
                                    </template>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Jalan</label>
                                <input type="text" class="form-control @error('jalan') is-invalid @enderror"
                                    value="{{ old('jalan') }}" name="jalan" placeholder="masuk alamat jalan">
                            </div>
                            <div class="col-md-12">
                                <label for="">Pilih Paket</label>
                            </div>
                            @foreach ($level as $item)
                                <div class="col-md-12">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="{{ $item->id }}level" name="paket"
                                            class="custom-control-input" value="{{ $item->id }}">
                                        <label class="custom-control-label"
                                            for="{{ $item->id }}level">{{ $item->nama }}
                                            (potongan
                                            {{ $item->tipe_potongan === 'fix' ? 'Rp.' . number_format($item->potongan_harga) : "$item->potongan_harga%" }})
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-12 mt-4">
                                <input type="text" hidden name="daftar_seller" value="1">
                                <button type="submit" class="btn btn__primary btn-block w-100">
                                    Daftar Reseller
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('addScript')
    <script>
        function funcDataStore() {
            return {
                image: [],
                all_selectedFiles: null,
                imgStore: "{{ asset('gambar/no-image.png') }}",
                provinsi_id: null,
                city_id: 0,
                kecamatan_id: 0,
                list_kota: [],
                list_kecamatan: [],

                onFileChange(e) {
                    // console.log('e', e)
                    // console.log('e.target.files[0]', e.target.files[0])
                    if (e.target.files.length !== 0) {
                        const file = e.target.files[0]
                        let urlimage = URL.createObjectURL(file)
                        let selectedFiles = this.$refs.imageRef.files
                        this.all_selectedFiles = selectedFiles[0]

                        let formData = new FormData()
                        formData.append('image', this.all_selectedFiles);
                        axios.post("{{ route('upload-image-gallery') }}", formData, {
                            csrfToken: "{{ csrf_token() }}",
                        }).then(res => {
                            location.reload();
                        }).catch(err => {
                            console.log('err', err)
                        })

                    }
                },

                handleImageDelete(id) {
                    axios.get("{{ route('deleteImage') }}?id=" + id).then(res => {
                        console.log('res', res)
                    }).catch(err => {
                        console.log('err', err);
                    })
                },

                onChangeImageStore(e) {
                    if (e.target.files.length !== 0) {
                        const file = e.target.files[0]
                        let urlimage = URL.createObjectURL(file)
                        this.imgStore = urlimage;
                    }
                },

                init() {

                    this.$watch("provinsi_id", (value, oldValue) => {
                        axios.get("{{ route('list-kota') }}?provinsi_id=" + value).then(res => {

                            this.list_kota = res.data;
                        })
                    });

                    this.$watch('city_id', (value, oldValue) => {
                        console.log('value city_id', value)
                        axios.get("{{ route('list-kecamatan') }}?city_id=" + value).then(res => {
                            this.list_kecamatan = res.data;
                        });
                    });
                }
            }
        }
    </script>
@endpush
