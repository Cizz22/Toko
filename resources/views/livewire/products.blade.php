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
            @forelse ($products as $index=>$product)
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$product->name}}</td>
                <td><img src="{{asset('storage/images/'.$product->image)}}" alt="image" class="img-fluid"></td>
                <td>{{$product->description}}</td>
                <td>{{$product->price}}</td>
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
        <div  >{{ $products->links() }}</div>
        </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class= "card shadow mb-4">
            <div class="card-header">
                <h2 class="card-title">Message</h2>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" defer ></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" defer></script>
<script src="https://cdn.socket.io/4.1.1/socket.io.min.js" integrity="sha384-cdrFIqe3RasCMNE0jeFG9xJHog/tgOVC1E9Lzve8LQN1g5WUHo0Kvk1mawWjxX7a" crossorigin="anonymous"></script>

