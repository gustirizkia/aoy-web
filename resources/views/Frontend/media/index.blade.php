@extends('layouts.frontend')

@section('title')
    Media
@endsection

@section('content')
<div class="md:px-32 px-4 pb-32 md:mb-0">
    <div class="text-center md:w-1/2 mx-auto mt-10 ">
        <div class="">
            <iframe src="https://youtube.com/embed/n1iSeEyTYU4?feature=share" frameborder="0" class="w-full aspect-video rounded-lg"></iframe>
        </div>

        <div class="text-lg md:mt-8 mt-4 mb-12 text-gray-500">
            Selamat datang di halaman media kami! Di sini, kami berbagi wawasan terbaru tentang perawatan kecantikan, tren terkini dalam skincare, dan tips berguna untuk meraih kulit sehat dan bersinar. Kami sangat peduli dengan kesehatan dan kecantikan Anda, dan kami berkomitmen untuk menyediakan informasi yang berharga bagi Anda.
        </div>
    </div>


    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($items as $item)
            <div>
                <img class="h-auto max-w-full rounded-lg" src="{{ url($item->image) }}" alt="">
            </div>
        @endforeach
    </div>


</div>
@endsection

@push('addScript')
@endpush
