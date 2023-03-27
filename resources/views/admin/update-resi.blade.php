@extends('crudbooster::admin_template')

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        .bg-success {
            background-color: #00a65a !important;
            color: white;
        }

        .bg-info {
            background-color: #17a2b8 !important;
            color: white
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }
    </style>
@endpush

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <h4>Update Resi {{ $item->no_inv }}</h4>
            <form action="{{ route('updateResi', $item->id) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Metode Pengiriman</label>
                        <select name="metode_pengiriman" class="form-control">
                            <option value="sicepat" {{ $item->metode_pengiriman === 'sicepat' ? 'selected' : '' }}>Sicepat
                                Reguler</option>
                            <option value="jne" {{ $item->metode_pengiriman === 'jne' ? 'selected' : '' }}>JNE Reguler
                            </option>
                            <option value="anteraja" {{ $item->metode_pengiriman === 'anteraja' ? 'selected' : '' }}>
                                AntarAja
                                Reguler</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="">Resi</label>
                        <input type="text" class="form-control" name="resi">
                    </div>
                    <div class="col-md-12 ">

                        <button type="submit" class="btn btn-success mt-3" style="margin-top: 14px">Update Resi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
