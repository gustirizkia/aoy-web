
@if (request()->is('keranjang'))
<section class="md:hidden shadow p-2 py-3 sticky top-0 bg-white z-40">
        <a href="{{ Session::get('prev') }}" class="flex items-center ">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
            </svg>
            <div class="ml-3">
                Keranjang saya
            </div>
        </a>

</section>
@else

<section class="md:hidden shadow p-2 flex items-center justify-between sticky top-0 bg-white z-40">
    <div class="relative w-64">
        <form action="{{ route('produk') }}" method="get">
            <input type="text" id="search-dropdown" name="search" class="block p-2 w-full z-20 text-sm text-gray-900 bg-gray-50 pr-14 rounded-lg border border-gray-300 focus:ring-primary focus:border-primary placeholder-gray-400" placeholder="Cari barang " value="{{ Request::get('search') }}">
        </form>
            <div  class="absolute top-0 right-0 p-2 text-sm font-medium text-gray-400  rounded-r-lg border b  focus:ring-4 focus:outline-none focus:ring-blue-300">
                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
    </div>

    <div class="text-gray-600">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
        </svg>

    </div>
@if (Auth::user())
<button class="text-gray-600 relative" id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification" type="button">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
    </svg>
    <span class="top-0 left-4 absolute  w-3.5 h-3.5 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
</button>
@else
   <a href="/login" class="text-gray-600 relative" id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        <span class="top-0 left-4 absolute  w-3.5 h-3.5 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
    </a>
@endif
@auth
  @php
        $notifTopBar = \App\Models\Notification::where('user_uuid', Auth::user()->uuid)->limit(7)->get();
  @endphp
        <div id="dropdownNotification" class="z-20 overflow-x-auto h-screen hidden w-full max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700" aria-labelledby="dropdownNotificationButton">
            <div class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white">
                Notifications
            </div>
            @foreach ($notifTopBar as $item)
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    <a href="{{ $item->cta ? $item->cta : '#' }}" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">

                    <div class="w-full pl-3">
                        <div class="font-medium text-gray-800">{{ $item->title }}</div>
                        <div class="text-gray-500 text-sm">{{ $item->short_body }}</div>
                    </div>
                    </a>
                </div>
            @endforeach
            <a href="#" class="block py-2 text-sm font-medium text-center text-gray-900 rounded-b-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white">
                <div class="inline-flex items-center ">
                <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                    View all
                </div>
            </a>
      </div>
@endauth


</section>
@endif


