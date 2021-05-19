<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Transaction;
use Livewire\Component;

class History extends Component
{
    public function render()
    {
        $transactions = Transaction::where('user_id', Auth()->id())->orderBy('created_at','DESC')->get();

        return view('livewire.history', [
            'transactions' => $transactions
        ]);
    }
}
