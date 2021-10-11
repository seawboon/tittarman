<div for="Price">
  <div class="row">
    <div class="col-6">
      <div class="form-group">
        <label for="price">Original Price <small class="text-danger">required</small></label>
        <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" value="{{ old('price', $variant->price) }}">
        @error('price')
        <small class="text-danger">{{ $message}}</small>
        @enderror
      </div>
    </div>
    <div class="col-6">
        <div class="form-group">
          <label for="sell">Selling Price <small class="text-danger">required</small></label>
          <input type="text" class="form-control" id="sell" name="sell" placeholder="Enter Selling Price" value="{{ old('sell', $variant->sell) }}">
          @error('sell')
          <small class="text-danger">{{ $message}}</small>
          @enderror
        </div>
    </div>
  </div>
</div>
