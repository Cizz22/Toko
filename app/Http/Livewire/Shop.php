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
                    'rowId' => $item->Id,
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
            $rowId = "Cart".$id;
            $cart = \Cart::session(Auth()->id())->getContent();
            $cekid = $cart->whereIn('Id', $rowId);

            if($cekid->isNotEmpty()){
                \Cart::session(Auth()->id())->update($rowId,[
                    'relative' => true,
                    'quatity' => 1
                ]);
            }else{
                $product = M_Product::findOrFail($id);
                \Cart::session(Auth()->id())->add([
                    'id' => "Cart".$product->id,
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
