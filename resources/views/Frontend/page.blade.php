@extends('layouts.frontend')

@section('title')
    {{ $item->page }}
@endsection

@section('content')
<div class="md:w-1/2 mx-auto mt-8 shadow rounded-lg p-4 border">
    <div class="">
        {!! $item->body !!}
    </div>
</div>
@endsection
