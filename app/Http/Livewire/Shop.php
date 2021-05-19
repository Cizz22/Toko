<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product as M_Product;
use App\Models\ProductTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\WithPagination;
use DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;

use function PHPUnit\Framework\returnSelf;

class Shop extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;

    public $pajak = "10%";

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = M_Product::where('name', 'like', '%'.$this->search.'%')->orderBy('created_at', 'DESC')->paginate(8);
        $id= Auth()->id();
        $condition = new \Darryldecode\Cart\CartCondition([
            'name' => 'pajak',
            'type' => 'tax',
            'target' => 'total',
            'value' => $this->pajak,
            'order' => 1
        ]);

        \Cart::session($id)->condition($condition);
        $items = \Cart::session($id)->getContent()->sortByDesc(function ($cart){
            return $cart->attributes->get('added_at',);
        });



        if(\Cart::session($id)->isEmpty()){
            $cartData = [];
        }else{
            foreach ($items as $item) {
                $cart[] = [
                    'rowId' => $item->id,
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->getPriceSum(),
                ];
            }
                $cartData = collect($cart);
            }

            $subtotal = \Cart::session($id)->getSubTotal();
            $total = \Cart::session($id)->getTotal();


            $newCondition = \Cart::session($id)->getCondition('pajak');
            $pajak = $newCondition->getCalculatedValue($subtotal);


            $data = [
                'sub_total' => $subtotal,
                'total' => $total,
                'pajak' => $pajak
            ];
            return view('livewire.shop', [
                'products' => $products,
                'carts' => $cartData,
                'data' => $data
            ]);
        }
        public function addProduct($id){
            $cart = \Cart::session(Auth()->id())->getContent();
            $cekid = $cart->whereIn('id', $id);
            $product = M_Product::findOrFail($id);

            if($cekid->isNotEmpty()){
                if($product->qty == $cekid[$id]->quantity){
                    return session()->flash('error','Stok item habis');
                }

                \Cart::session(Auth()->id())->update($id,[
                    'quantity' => [
                        'relative' => true,
                        'value' => 1
                    ]
                ]);
            }else{
                if($product->qty == 0){
                    return session()->flash('error','Stok item habis');
                }
                else{
                    \Cart::session(Auth()->id())->add([
                        'id' => $product->id,
                        'name' => $product->name,
                        'quantity' => 1,
                        'attributes' => [
                            'added_at' => Carbon::now()
                        ],
                        'price' => $product->price
                    ]);
                }
            }

        }
        public function addItemInCart($id){
            $product = M_Product::findOrFail($id);
            $cart = \Cart::session(Auth()->id())->getContent();
            $cekid = $cart->whereIn('id', $id);

            if($product->qty == $cekid[$id]->quantity){
                return session()->flash('error','Stok item habis');
            }else{
                \Cart::session(Auth()->id())->update($id, [
                    'quantity' => [
                        'relative' => true,
                        'value' => 1
                    ]
                ]);
            }

        }
        public function deleteItemInCart($id){
            $product = M_Product::findOrFail($id);
            $cart = \Cart::session(Auth()->id())->getContent();
            $cekid = $cart->whereIn('id', $id);

            if($cekid[$id]->quantity == 1){
                \Cart::session(Auth()->id())->remove($id);
            }else{
            \Cart::session(Auth()->id())->update($id, [
                'quantity' => [
                    'relative' => true,
                    'value' => -1
                ]
            ]);
                }
        }

        public function buyProduct(){
            $cartTotal = \Cart::session(Auth()->id())->getTotal();

            DB::beginTransaction();
            try {
            $allCart = \Cart::session(Auth()->id())->getContent();

            $cartFilter = $allCart->map(function($item){
                return [
                    'id' => $item->id,
                    'quantity'=> $item->quantity
                ];
            });

            foreach ($cartFilter as $item) {
                $product = M_Product::find($item['id']);

                if($product->qty === 0){
                    return session()->flash('error','Stok item habis');
                }

                $product->decrement('qty', $item['quantity']);
            }

            $id = idGenerator::generate([
                'table' => 'transactions',
                'length' => 7,
                'prefix' => "INV.",
                'field' => 'invoice_number'
            ]);

            Transaction::create([
                'invoice_number' => $id,
                'user_id' => Auth()->id(),
                'total' => $cartTotal
            ]);

            foreach ($cartFilter as $cart) {
                ProductTransaction::create([
                    'product_id' => $cart['id'],
                    'invoice_number' => $id,
                    'qty' => $cart['quantity']
                ]);
            }

            \Cart::session(Auth()->id())->clear();

            DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                return session()->flash('error', $th);
            }

        }
    }
