@extends('crudbooster::admin_template')

@section('content')
<div class="panel panel-default">
    <div class="panel-body">
        <h4>Edit Level Member User {{ $user->name }}</h4>
        <form action="{{ route("updateLevel", $user->id) }}" method="post">
            @csrf
            <div class="form-group header-group-0 " id="form-group-nama" style="">

                <div class="col-sm-12">
                    <div class="">
                        Pilih Level
                        <span class="text-danger" title="This field is required">*</span>
                    </div>
                    <select name="level_id" id="" class="form-control">
                        <option value="">Pilih Level</option>
                        @foreach ($level as $item)
                            <option value="{{$item->id}}" {{ $user->level === $item->id ? "selected" : "" }}>{{ $item->nama }} </option>
                        @endforeach
            
                    </select>
                </div>
            </div>
            <button type="submit" class=" btn btn-success" style="margin-top: 24px;">Simpan Perubahan</button>
        </form>

    </div>
</div>
@endsection