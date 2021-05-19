<div>
    <div class="card shadow">
        <div class="card-body">
            <h3 class="card-title">Transaction history</h3>
            <div class="row">
                @forelse ($transactions as $transaction )
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Transaction Code: {{$transaction->invoice_number}}</h5>
                            <h5>{{$transaction->created_at}}</h5>
                            <h5>Price: Rp. {{$transaction->total}}</h5>
                            <table class="table table-hovered table-striped table-bordered " >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaction->product as $index => $product)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{$product->product->name}}</td>
                                        <td>{{$product->qty}}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                @empty
                    No Transactions
                @endforelse

            </div>
        </div>
    </div>
</div>
