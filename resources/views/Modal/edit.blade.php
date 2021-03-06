<div wire:ignore.self class="modal fade" id="editModal{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
               @if(session()->has('success'))
                  <h5 class="text-success">{{session('success')}}</h5>
               @endif
           <form wire:submit.prevent="editProduct({{$product->id}})">
                <div class="form-group">
                    <label for="">Product Name</label>
                    <input wire:model="name"  class="form-control" type="text">
                    @error('name')<small class="text-danger"> {{$message}}</small>@enderror
                </div>
                <div class="form-group">
                    <label for="">Image</label>
                    <div class="custom-file">
                    <input wire:model="image" class="form-control custom-file-input" type="file" id="customFile">
                    <label for="customFile" class="custom-file-label">Choose Image</label>
                    @error('image')<small class="text-danger"> {{$message}}</small>@enderror
                    </div>
                    @if($image)
                        <label class = "mt-2">Image Preview</label>
                        <img src="{{$image->temporaryUrl()}}" class="img-fluid" alt="Preview">
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <textarea wire:model="description" class="form-control"></textarea>
                    @error('description')<small class="text-danger"> {{$message}}</small>@enderror
                </div>
                <div class="form-group">
                    <label for="">Price</label>
                    <input wire:model="price" class="form-control" type="text">
                    @error('price')<small class="text-danger"> {{$message}}</small>@enderror
                </div>
                <div class="form-group">
                    <label for="">Qty</label>
                    <input wire:model="qty" class="form-control" type="text">
                    @error('qty')<small class="text-danger"> {{$message}}</small>@enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block"/>
                </div>
            </div>
        </div>
    </div>
  </div>

