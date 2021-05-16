<div class="row">
    <div class="col-md-9">
        <div class="card shadow mb-3">
            <div class="card-header"><h2 class="font-weight-bold">Product List</h2> </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($products as $a)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <img src="{{asset('storage/images/'.$a->image)}}" alt="Item" class="img-fluid" >
                                </div>
                                <div class="card-footer">
                                    <h5 class="font-weight-bold text-center card-title">{{$a->name}}</h5>
                                    <h6 class="card-text">Price : Rp. {{$a->price}}</h6>
                                    <h6 class="card-text">Seller : {{$a->user->name}}</h6>
                                    <button wire:click = "addProduct({{$a->id}})" class="btn btn-success btn-sm btn-block ">Add</button>
                                    <button wire:click = "" class="btn btn-primary btn-sm btn-block ">Chat Seller</button>
                                </div>
                            </div>
                        </div>   

                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">  
        <div class="card shadow mb-3">
            <div class="card-header"> <h2 class="font-weight-bold">Cart</h2> </div>
            <div class="card-body">
               
                @if(session()->has('error'))
                                <h6 class="text-danger">{{session('error')}}</h6>
                            @endif
               <table class="table table-hovered table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Product Name</th>
                        <th>Price Total</th>
                        <th>Quatity</th>
                    </tr>
                    <tbody>
                        @forelse ($carts as $index=>$cart)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$cart['name']}}</td>
                            <td>Rp. {{$cart['total']}}</td>
                            <td>  <a href="#" wire:click = "addItemInCart({{$cart['rowId']}})" class="font-weight-bold text-secondary" style="font-size:20px">+</a> {{$cart['quantity']}} <a href="#" wire:click = "deleteItemInCart({{$cart['rowId']}})" class="font-weight-bold text-secondary" style="font-size:20px">-</a> 
                            </td>
                        </tr>
                        @empty
                        <td colspan="4"><h5 class="text-center font-weight-bold">Empty Cart</h5></td>
                    @endforelse
                    </tbody>
                </thead>
            </table>
           
            </div>
            <div class="card-footer">
                <h5 class="card-title font-weight-bold">Total Harga</h5>
                <h6 class="card-text"> Sub-total: Rp. {{$data['sub_total']}} </h6>
                <h6 class="card-text">Pajak: Rp. {{$data['pajak']}} </h6>
                <h6 class="card-text">Total: Rp. {{$data['total']}}</h6>
                <button class="btn btn-primary btn-block">Buy</button>
            </div>
        </div>
    </div>
</div>
