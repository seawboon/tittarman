<div for="Products">
  <table class="table align-items-center">
    <thead class="thead-light">
      <th scope="col" class="sort" data-sort="budget">Product Name</th>
      <th scope="col" class="sort" data-sort="status">Price (RM)</th>
      <th scope="col" class="sort" data-sort="branch">Unit</th>
      <th scope="col">Total</th>
    </thead>
    <tbody class="list">
      @foreach($products->where('type','!=', 'voucher') as $key => $product)
      <tr>
        <td>
          <input type="hidden" name="product[{{ $key }}][product_id]" value="{{$product->id}}" />
          <input type="hidden" name="product[{{ $key }}][treat_id]" value="{{$payment->treat->id ?? ''}}" />
          <input type="hidden" name="product[{{ $key }}][matter_id]" value="{{$payment->matter->id ?? ''}}" />
          <input type="hidden" name="product[{{ $key }}][patient_id]" value="{{$payment->patient->id ?? ''}}" />
          @if($product->id == 4)
            <textarea class="form-control" name="product[{{ $key }}][remarks]" rows="1" placeholder="Enter Others">{{ old('product.'.$key.'.remarks') }}</textarea>
          @else
            <input type="hidden" name="product[{{ $key }}][remarks]" value="" />
            {{ $product->name }}
          @endif
        </td>
        <td class="w-25">
          <div class="form-group">
            @if($payment->products->isNotEmpty())
            <input type="text" class="form-control productprice" name="product[{{ $key }}][price]" value="{{ old('product.'.$key.'.price', $payment->products[$key]->price) }}" />
            @else
            <input type="text" class="form-control productprice" name="product[{{ $key }}][price]" value="{{ old('product.'.$key.'.price', $product->price) }}" />
            @endif
          </div>
        </td>
        <td class="w-25">
          <div class="form-group">
            @php $pType = 'item';
              if($product->type == 'voucher') {
                  $pType = 'voucher';
              }

            @endphp
          @if($payment->products->isNotEmpty())
              {!! Form::select('product['.$key.'][unit]', range(0, 10) , $payment->products[$key]->unit, array('class' => 'form-control productunit'.$key.' '.$pType.'')) !!}
          @else
            {!! Form::select('product['.$key.'][unit]', range(0, 10) , null, array('class' => 'form-control productunit'.$key.' '.$pType.'')) !!}
          @endif
          </div>

        </td>
        <td class="w-25">
          <div class="form-group">
            <input type="text" class="form-control producttotal{{ $key }}" name="product[{{ $key }}][total]" value="0" readonly />
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
