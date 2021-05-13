<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
            <img src="{{asset('storage/images/'.$a->image)}}" alt="Item" class="img-fluid" >
            <div class="card">
                <div class="card-body card-border">
                    <h5 class="card-title">{{$a->name}}</h5>
                    <h6 class="card-text">
                        {{$a->description}}
                    </h6>
                    <h6 class="card-text">
                       Price:  Rp. {{$a->price}}
                    </h6>
                    
                </div>
            </div>
            </div>
        </div>
    </div>
</div>