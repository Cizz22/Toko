<div class="row">
    <div class="col-md-9">
        <div class= "card shadow mb-4">
        <div class="card-body">
        <div class="row">
            <div class="col-7">
                <h1 class="h3 mb-2 text-gray-800">Product List</h1>
                </div>
                <div class="col-md-3">
                    <input wire:model="search" type="text" class="form-control" placeholder="Search">
                </div>
                <div class="col-2 justify-content-around d-flex flex-column">
                <button type="button" class="btn btn-primary mb-3 " data-toggle="modal" data-target="#exampleModal">
	                Insert Product
                </button>
<!-- Modal -->
@include('Modal.insert')
</div>
        </div>

        <table id="listProduct" class="table table-striped table-bordered table-hovered">
        <thead>
            <tr>
            <th>No.</th>
            <th>Product Name</th>
            <th width="20%">Image</th>
            <th>Description</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productslist as $index=>$product)
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$product->name}}</td>
                <td><img src="{{asset('storage/images/'.$product->image)}}" alt="image" class="img-fluid"></td>
                <td>{{$product->description}}</td>
                <td>Rp. {{$product->price}}</td>
                <td>{{$product->qty}}</td>
                <td>
                <button wire:click = "deleteProduct({{$product->id}})" class="btn btn-danger ">Delete</button>
                </td>
            </tr>
            @empty
            <td colspan="7"><h4 class="text-center font-weight-bold">Not Found</h4></td>
            @endforelse
        </tbody>
        </table>
        <div  >{{ $productslist->links() }}</div>
        </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class= "card shadow mb-4">
            <div class="card-header">
                <h2 class="card-title">Info</h2>
            </div>
            <div class="card-body">

                @forelse ($productsinfo as $a)
                    @if($a->transaction->isNotEmpty())
                    <h3 class="card-title">{{$a->name}} : {{$a->transaction->count()}} Transaksi</h3>
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample{{$a->id}}" aria-expanded="false" aria-controls="collapseExample">
                       Detail
                      </button>
                    </p>
                    <div class="collapse" id="collapseExample{{$a->id}}">
                      <div class="card card-body">
                        <table class="table table-hovered table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Transaction Code</th>
                                    <th>Buyer Name</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($a->transaction as $transaction)
                                <tr>
                                    <td>{{$transaction->invoice_number}}</td>
                                    <td>{{$transaction->transaction->user->name}}</td>
                                    <td>{{$transaction->qty}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                      </div>
                    </div>
                    @endif
                @empty
                    Not Found
                @endforelse
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" defer ></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" defer></script>
<script src="https://cdn.socket.io/4.1.1/socket.io.min.js" integrity="sha384-cdrFIqe3RasCMNE0jeFG9xJHog/tgOVC1E9Lzve8LQN1g5WUHo0Kvk1mawWjxX7a" crossorigin="anonymous"></script>

