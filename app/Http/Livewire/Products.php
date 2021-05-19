<?php

namespace App\Http\Livewire;


use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product as M_Product;
use illuminate\Support\facades\Storage;
use Livewire\WithPagination;

class Products extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search;
    protected $paginationTheme = 'bootstrap';
    public $name, $image, $description, $qty, $price;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $product = M_Product::where('name', 'like', '%'.$this->search.'%')->orderBy('created_at', 'DESC')->where('seller',Auth()->id())->paginate(5);
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
            'seller' => Auth()->id()
        ]);

        session()->flash('success','Success');

        $this->name='';
        $this->image='';
        $this->description='';
        $this->qty='';
        $this->price='';
    }
    public function deleteProduct($id){
        $product = M_Product::find($id);
        $product->delete();
    }

    public function editProduct(){

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



        session()->flash('success','Edit Success');

        $this->name='';
        $this->image='';
        $this->description='';
        $this->qty='';
        $this->price='';
    }



}
