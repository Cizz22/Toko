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
                                    <h6 class="font-weight-bold text-center">{{$a->name}}</h6>
                                   
                                        <button class="btn btn-success btn-sm btn-block ">Add</button>
                                         <button class="btn btn-primary btn-sm btn-block ">Detail</button>
                                   
                                   
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
                Cart
            </div>
        </div>
    </div>
</div>
