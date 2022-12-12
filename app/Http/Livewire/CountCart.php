<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use Livewire\Component;

class CountCart extends Component
{
    public function render()
    {
        $countData = Cart::where('user_id', auth()->user()->id)->count();
        return view('livewire.count-cart', [
            'count_data' => $countData
        ]);
    }
}
