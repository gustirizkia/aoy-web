<div>
    <div class="my-6 md:block hidden">
        <div class="font-medium mb-2">
            Jumlah
        </div>
        <div class="p-2  rounded-full border inline-block">
            <div class="flex justify-between items-center">
                <div class="mr-6 cursor-pointer" @click="$wire.increment('min')">
                    <img src="{{ asset('gambar/icon/min-circle.png') }}" alt="" class="opacity-60">
                </div>
                <div class="font-bold text-lg" x-data="{
                    qty: @entangle('Datacount')
                }">
                    <span x-text="qty"></span>
                </div>
                <div class="ml-6 cursor-pointer" @click="$wire.increment('plus')">
                    <img src="{{ asset('gambar/icon/plus-circle.png') }}" alt="" >
                </div>
            </div>
        </div>
        <div class="my-4 flex">
            <div  class="border-2 border-primary px-4 py-2 rounded-xl font-medium text-primary cursor-pointer hover:bg-primary hover:text-white w-full text-center">
                + Keranjang
            </div>
            <div class="border-2 border-primary px-4 py-2 rounded-xl font-medium cursor-pointer bg-primary text-white ml-4 w-full text-center">
                Order
            </div>
        </div>
    </div>
</div>
