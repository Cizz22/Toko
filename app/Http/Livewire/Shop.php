<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product as M_Product;

class Shop extends Component
{
    public $pajak = "0%";

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
        $items = \Cart::session($id)->getContent()->sortBy(function ($cart){
            return $cart->attributes->get('added_at');
        });



        if(\Cart::session($id)->isEmpty()){
            $cartData = [];
        }else{
            foreach ($items as $item) {
                $cart[] = [
                    'rowId' => $item->id,
                    'name' => $item->name,
                    'qty' => $item->qty,
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
    }
    