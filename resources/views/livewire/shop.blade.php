<div class="row">
    <div class="col-md-9">
        <div class="card shadow mb-3">
            <div class="card-body">
                <h2 class="font-weight-bold">Product List</h2> 
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
                                        <button wire:click = "addProduct({{$a->id}})" class="btn btn-success btn-sm btn-block ">Add</button>
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
            <div class="card-body">
                <h2 class="font-weight-bold">Cart</h2> 
              
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
                            <td>{{$cart['quantity']}}</td>
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
                <button class="btn btn-primary btn-lg ">Buy</button>
            </div>
        </div>
    </div>
</div>
