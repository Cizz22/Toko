<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product as M_Product;
use Carbon\Carbon;

class Shop extends Component
{
    public $pajak = "10%";

    public function render()
    {
        $products = M_Product::orderBy('created_at', 'DESC')->get();
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
            
            if($cekid->isNotEmpty()){
                $product = M_Product::findOrFail($id);
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
                $product = M_Product::findOrFail($id);
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
    }
