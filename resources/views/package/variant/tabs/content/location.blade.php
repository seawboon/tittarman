<div for="location"><div class="row">


{{--
App\Branches::all()
--}}


<div class="col-12">
  <div class="form-group">
    <label>Redeem Locations</label>
    <div class="custom-control custom-checkbox">
      <?php $locations = [];?>
      @if($variant->redeemLocations)

        @foreach($variant->redeemLocations as $xxx)
          <?php
            $locations[] = $xxx['branch_id'];
          ?>
        @endforeach
      @endif

      <div class="row">
      @foreach(App\Branches::all() as $branch)
        <div class="col-6">
          <input type="checkbox" name="location[][branch_id]"
          class="custom-control-input" id="branch-{{$branch->name}}" value="{{$branch->id}}"
          {{ (is_array($locations) && in_array($branch->id, $locations)) ? ' checked' : '' }}>
          <label class="custom-control-label" for="branch-{{$branch->name}}">{!!$branch->name!!}</label>
        </div>
      @endforeach

      </div>
      @error('injuries')
      <small class="text-danger">{{ $message}}</small>
      @enderror
    </div>
  </div>
</div>

</div></div>
