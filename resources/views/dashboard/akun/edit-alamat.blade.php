@extends('layouts.dashboard')

@section('title')
    Edit alamat anda
@endsection

@push('addStyle')
    <style>

    </style>
@endpush

@section('content')
    <div class="card" x-data="funcData">
        <div class="card-body">
            <div class="d-flex justify-content-start align-items-center mb-4">
                <a href="{{ route('akun-saya') }}" class="cursor-pointer">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" >
                        <path d="M14.5002 25.7331L5.70016 16.9331C5.56683 16.7998 5.47216 16.6553 5.41616 16.4998C5.36105 16.3442 5.3335 16.1776 5.3335 15.9998C5.3335 15.822 5.36105 15.6553 5.41616 15.4998C5.47216 15.3442 5.56683 15.1998 5.70016 15.0665L14.5002 6.26645C14.7446 6.02201 15.0499 5.89401 15.4162 5.88245C15.7833 5.87178 16.1002 5.99978 16.3668 6.26645C16.6335 6.5109 16.7726 6.81623 16.7842 7.18245C16.7948 7.54956 16.6668 7.86645 16.4002 8.13312L9.86683 14.6665H24.7668C25.1446 14.6665 25.4615 14.794 25.7175 15.0491C25.9726 15.3051 26.1002 15.622 26.1002 15.9998C26.1002 16.3776 25.9726 16.694 25.7175 16.9491C25.4615 17.2051 25.1446 17.3331 24.7668 17.3331H9.86683L16.4002 23.8665C16.6446 24.1109 16.7726 24.422 16.7842 24.7998C16.7948 25.1776 16.6668 25.4887 16.4002 25.7331C16.1557 25.9998 15.8446 26.1331 15.4668 26.1331C15.0891 26.1331 14.7668 25.9998 14.5002 25.7331Z" fill="#292929"/>
                    </svg>
                </a>
                <a href="{{ route('akun-saya') }}" class="ml-4">
                    <h5 class="cursor-pointer " style="margin-bottom: 0px"  class="ml-3">Edit Alamat</h5>
                </a>
            </div>

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
                        @foreach ($kota as $itemKota)
                            <option value="{{ $item->city_id }}">{{ $item->name }}</option>
                        @endforeach
                        {{-- <template x-for="kota in list_kota" :key="kota.id">
                        <option :value="kota.city_id" x-text="kota.name"></option>
                        </template> --}}
                    </select>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="">Kecamatan</label>
                    <select  id="" class="form-control" x-model="kecamatan_id">
                        <option value="0">Pilih Kecamatan</option>
                        @foreach ($kecamatan as $itemKecamatan)

                        @endforeach
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
    </div>
@endsection

@push('addScript')
    <script>
        function funcData(){
            return{
                img_profile: "{{ Auth::user()->photo ? url("storage/Auth::user()->photo") : asset('gambar/user.png') }}",
                showAddAlamat: false,
                provinsi_id: {{ $alamat->provinsi->id }},
                city_id: {{ $alamat->kota->city_id }},
                kecamatan_id: {{ $alamat->kecamatan->subdistrict_id }},
                // kecamatan_id: 11011111,
                list_kota: [],
                list_kecamatan: [],
                alamat_lengkap: "{{ $item->address }}",
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
                        console.log('form', form)

                        axios.post("{{ route('tambah-alamat') }}", form, {
                            csrfToken: "{{ csrf_token() }}",
                        }).then(res => {
                            console.log('res tambah data', res)
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil tambah alamat',
                            });

                            // this.showAddAlamat = false;
                            location.reload();
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
                        axios.get("{{ route('list-kecamatan') }}?city_id="+value).then(res => {
                            this.list_kecamatan = res.data;
                        });
                    });
                },

            }
        }

        async function getLabel(){

        }
    </script>
@endpush
