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
                        <label for="">Deskripsi Toko</label>
                        <textarea  id="" cols="30" rows="4" class="form-control" name="deskripsi">{{ $member->deskripsi }}</textarea>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="mt-4">
                        <div class="row">
                            @foreach ($gallery as $item)
                                <div class="col-md-3">
                                    <img src="{{ Storage::url($item->image) }}" class="img-fluid" alt="">
                                </div>
                            @endforeach
                            <template x-for="(item, index) in image" :key="index">
                                <div class="col-md-3" x-show="image.length > 0">
                                    <img :src="item" alt="" class="img-fluid">
                                </div>
                            </template>
                            <div class="col-md-3">
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
                    const file = e.target.files[0]
                    let urlimage = URL.createObjectURL(file)
                    this.imgStore = urlimage;
                }
            }
        }
    </script>
@endpush
