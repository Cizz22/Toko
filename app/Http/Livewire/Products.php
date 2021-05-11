<?php

namespace App\Http\Livewire;


use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product as M_Product;
use illuminate\Support\facades\Storage;


class Products extends Component
{
    use WithFileUploads;
    public $name, $image, $description, $qty, $price;
    public function render()
    {
        $product = M_Product::orderBy('created_at', 'DESC')->get();
        return view('livewire.products', [
            'products' =>$product
        ]);
    }
    public function uploadProduct(){
        $this->validate([
            'name' => 'required',
            'image' => 'image|max:2048|required',
            'description' => 'required',
            'qty' => 'required',
            'price' =>'required',
        ]);

        $imgname = md5($this->image.microtime().'.'.$this->image->extension());
        
        Storage::putFileAs(
            'public/images',
            $this->image,
            $imgname
        );

        M_Product::create([
            'name' => $this->name,
            'image' => $imgname,
            'description' => $this->description,
            'qty' => $this->qty,
            'price' => $this->price,
        ]);

        session()->flash('success','Success');

        $this->name='';
        $this->image='';
        $this->description='';
        $this->qty='';
        $this->price='';
    }

}
