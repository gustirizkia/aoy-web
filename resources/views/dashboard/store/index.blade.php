@extends('layouts.dashboard')

@section('title')
    Pengaturan Toko
@endsection

@push('addStyle')
    <style>
        .logo__image_edit{
            width: 220px;
            border-radius: 10px;
            padding: 6px;
        }
        .shape_edit{
            position: absolute;
            right: 4px;
            bottom: 30px;
        }
        .delete_image{
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
<form action="{{ route('insert-store-setting') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="card" x-data="funcDataStore">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="sidebar-heading text-center">
                <div class="d-flex justify-content-center">
                    <div class="position-relative">

                        <img :src="imgStore " alt="" class="mt-4 logo__image_edit cursor-pointer" @click="$refs.imageStore.click()" />
                        <input type="file" accept="image/*" name="image" x-ref="imageStore" class="d-none" @change="onChangeImageStore">
                        <div class="text-sm text-secondary cursor-pointer" @click="$refs.imageStore.click()">Klik untuk update</div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-4">
                                <label for="">Nama Toko</label>
                                <input type="text" class="form-control" name="nama" value="{{ $member->nama }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mt-4">
                                <label for="">Akun Instagram Toko</label>
                                <input type="text" class="form-control" name="akun_ig" value="{{ $member->akun_ig }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mt-4">
                                <label for="">Nomor WhatsApp Toko</label>
                                <input type="number" class="form-control" name="nomor_wa" value="{{ $member->nomor_wa }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="mt-2">
                        <label for="">Alamat Toko</label>
                        <div class="row">
                            <div class="col-md-4">
                                <select name="provinsi" class="form-control" x-model="provinsi_id">
                                    <option value="">Provinsi</option>
                                    @foreach ($provinsi as $item)
                                        <option value="{{ $item->province_id }}" >{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select  id="" class="form-control" x-model="city_id" name="city_id">
                                    <option value="0">Pilih Kota/Kabupaten</option>
                                    <template x-for="kota in list_kota" :key="kota.id">
                                    <option :value="kota.city_id" x-text="kota.name"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select  id="" class="form-control" x-model="kecamatan_id" name="kecamatan_id">
                                    <option value="0">Pilih Kecamatan</option>
                                    <template x-for="kecamatan in list_kecamatan" :key="kecamatan.subdistrict_id">
                                    <option :value="kecamatan.subdistrict_id" x-text="kecamatan.subdistrict_name"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control mt-2" name="address" placeholder="alamat lengkap" value="{{ $member->address }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="mt-2">
                        <label for="">Deskripsi Toko</label>
                        <textarea  id="" cols="30" rows="4" class="form-control" name="deskripsi">{{ $member->deskripsi }}</textarea>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="mt-4">
                        <div class="row">
                            @foreach ($gallery as $item)
                                <div class="col-md-3">
                                    <div class="position-relative">
                                        <img src="{{ Storage::url($item->image) }}" class="img-fluid" alt="">
                                        <div class="delete_image px-1">X</div>
                                    </div>
                                </div>
                            @endforeach
                            <template x-for="(item, index) in image" :key="index">
                                <div class="col-md-3 position-relative" x-show="image.length > 0">
                                    <div class="position-relative">
                                        <img :src="item" alt="" class="img-fluid">
                                        <div class="delete_image px-1">X</div>
                                    </div>
                                </div>
                            </template>
                            <div class="col-md-3 position-relative">
                                <img src="{{ asset('gambar/add-image.png') }}" class="img-fluid" alt="" @click="$refs.imageRef.click()"  >
                                <input type="file" accept="image/*" x-ref="imageRef" class="d-none" @change="onFileChange">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <button class="btn btn__primary btn-block mt-4" type="submit">Simpan perubahan</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('addScript')
    <script>
        function funcDataStore(){
            return{
                image: [],
                all_selectedFiles: null,
                imgStore: "{{ $member->image ? url('storage/'.$member->image) : asset('gambar/no-image.png') }}",
                provinsi_id: 0,
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
                        axios.post("{{ route('upload-image-gallery') }}",formData, {
                            csrfToken: "{{ csrf_token() }}",
                        }).then(res =>{
                            this.image.push(urlimage)
                            console.log('res', res)
                        }).catch(err =>{
                            console.log('err', err)
                        })

                    }
                },

                onChangeImageStore(e)
                {
                    if (e.target.files.length !== 0) {
                        const file = e.target.files[0]
                        let urlimage = URL.createObjectURL(file)
                        this.imgStore = urlimage;
                    }
                },

                init(){
                    @if($member)
                    this.provinsi_id = {{ $member->province_id }};

                    axios.get("{{ route('list-kota') }}?provinsi_id="+this.provinsi_id).then(res =>{
                            this.list_kota = res.data;
                            this.city_id = {{ $member->city_id }};
                            console.log('this.city_id', this.city_id)

                            axios.get("{{ route('list-kecamatan') }}?city_id="+this.city_id).then(res => {
                                    this.list_kecamatan = res.data;
                                    this.kecamatan_id = {{ $member->subdistrict_id }};
                            });
                    })



                    @endif
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
