<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddCart extends Component
{
    public $count;

    public function render()
    {
        return view('livewire.add-cart');
    }

    public function increment($param)
    {
        // dd("OKOK");
        if($param === 'plus'){
            $this->Datacount++;
        }else{
            if($this->Datacount <= 1){
                $this->Datacount = 1;
            }else{
                $this->Datacount -= 1;
            }
        }
    }
}
