<div for="banner">
  <div class="row">
    <div class="col-12">
      <div class="form-group">
        <label for="title">Title <small class="text-danger">required</small></label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{ old('title', $variant->title) }}">
        @error('title')
        <small class="text-danger">{{ $message}}</small>
        @enderror
      </div>
    </div>

    <div class="col-12">
      <img src="{{$variant->getFirstMediaUrl('VariantBanner')}}" />
      <div class="form-group control-group increment after">
        <label>Banner</label>
        <div class="custom-file after">
            <input type="file" class="custom-file-input" name="banner_image" lang="en">
            <label class="custom-file-label" for="customFileLang">Select file</label>
        </div>
      </div>
    </div>
  </div>
</div>
