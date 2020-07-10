@extends('layouts.app', ['titlePage' => 'New Treat: '. $patient->fullname])

@section('content')
    <div class="header bg-gradient-secondary py-7 py-lg-8">
      <div class="container-fluid">
        <div class="row">


          <div class="col-xl-4 order-xl-2">
           @include('treat.card')
          </div>

      <div class="col-xl-8 order-xl-1">
        <div class="card-body">
            <form action="{{ route('treat.store', ['patient' => $patient, 'matter' => $matter]) }}" method="post" enctype="multipart/form-data">
              @csrf

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="branch_id" class="d-block">Branch</label>
                    @php
                      $defBranch = null;
                      if(Session::get('myBranch')) {
                        $defBranch=session('myBranch')->id;
                      }
                    @endphp
                    {!! Form::select('treat[branch_id]', [null=>'Please Select'] + $branches, $defBranch, array('class' => 'form-control', 'id' => 'branch_id')) !!}
                    @error('treat.branch_id')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="user_id" class="d-block">Treat By</label>
                    {!! Form::select('treat[user_id]', [null=>'Please Select'] + $users, auth()->user()->id, array('class' => 'form-control', 'id' => 'user_id')) !!}
                    @error('treat.user_id')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-12">
                  <label for="gemder" class="d-block">Treatment Date & Time</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                      </div>
                      <input class="flatpickr datetimepicker form-control" name="treat[treat_date]" type="text" placeholder="Date & Time" value="{{ old('treat.treat_date') }}">
                    </div>
                    @error('treat.treat_date')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-12">

                  <div class="form-group control-group increment before">
                    <label>Before Treat Upload</label>
                    <div class="custom-file before">
                        <input type="file" class="custom-file-input" name="filenamebefore[]" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>
                        <button class="btn btn-icon btn-success btn-before" type="button">
                        	<span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                            <span class="btn-inner--text">Add</span>
                        </button>
                    </div>
                  </div>


                  <div class="clone before d-none">
                    <div class="form-group control-group">
                      <div class="custom-file before">
                          <input type="file" class="custom-file-input" name="filenamebefore[]" lang="en">
                          <label class="custom-file-label" for="customFileLang">Select file</label>
                          <button class="btn btn-icon btn-danger" type="button">
                            <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                              <span class="btn-inner--text">Delete</span>
                          </button>
                      </div>
                    </div>
                  </div>


                  @error('filenamebefore')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <label for="address">Treatment</label>
                    <textarea class="form-control" id="treatment" name="treat[treatment]" rows="3" placeholder="Enter Treatment">{{ old('treat.treatment') }}</textarea>
                    @error('treat.treatment')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>



                <div class="col-12">
                  <div class="form-group">
                    <label for="address">Remarks</label>
                    <textarea class="form-control" id="remarks" name="treat[remarks]" rows="3" placeholder="Enter Remarks">{{ old('treat.remarks') }}</textarea>
                    @error('treat.remarks')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group control-group increment after">
                    <label>After Treat Upload</label>
                    <div class="custom-file after">
                        <input type="file" class="custom-file-input" name="filenameafter[]" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>
                        <button class="btn btn-icon btn-success btn-after" type="button">
                        	<span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                            <span class="btn-inner--text">Add</span>
                        </button>
                    </div>
                  </div>


                  <div class="clone after d-none">
                    <div class="form-group control-group">
                      <div class="custom-file after">
                          <input type="file" class="custom-file-input" name="filenameafter[]" lang="en">
                          <label class="custom-file-label" for="customFileLang">Select file</label>
                          <button class="btn btn-icon btn-danger" type="button">
                            <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                              <span class="btn-inner--text">Delete</span>
                          </button>
                      </div>
                    </div>
                  </div>


                  @error('filenameafter')
                  <small class="text-danger">{{ $message}}</small>
                  @enderror
                </div>


              </div>
              <hr />
              @hasanyrole('Master|Admin')
                <h3>Treatment Fee</h3>
              @else
                <h3>Payment</h3>
              @endhasanyrole
              <div class="table-responsive products">
                <div>
                  <table class="table align-items-center">
                    @can('reception-edit')
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="budget">Product Name</th>
                            <th scope="col" class="sort" data-sort="status">Price (RM)</th>
                            <th scope="col" class="sort" data-sort="branch">Unit</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    @endcan
                    <tbody class="list">
                      @foreach($products as $key => $product)
                      @can('reception-edit')
                      <tr>
                      @else
                      <tr class="producut-hide">
                      @endcan
                        <td>
                          <input type="hidden" name="product[{{ $key }}][product_id]" value="{{$product->id}}" />
                          <input type="hidden" name="product[{{ $key }}][matter_id]" value="{{$matter->id}}" />
                          <input type="hidden" name="product[{{ $key }}][patient_id]" value="{{$patient->id}}" />

                          @if($product->id == 4)
                            <textarea class="form-control" name="product[{{ $key }}][remarks]" rows="1" placeholder="Enter Others">{{ old('product.'.$key.'.remarks') }}</textarea>
                          @else
                            <input type="hidden" name="product[{{ $key }}][remarks]" value="" />
                            {{ $product->name }}
                          @endif
                        </td>
                        <td class="w-25">
                          <div class="form-group">
                            <input type="text" class="form-control productprice" name="product[{{ $key }}][price]" value="{{ old('product.'.$key.'.price', $product->price) }}" />
                          </div>
                        </td>
                        <td class="w-15">
                          <div class="form-group">
                          {!! Form::select('product['.$key.'][unit]', range(0, 10) , null, array('class' => 'form-control productunit'.$key.'')) !!}


                          </div>

                        </td>
                        <td class="w-25">
                          <div class="form-group">
                            <input type="text" class="form-control producttotal{{ $key }}" name="product[{{ $key }}][total]" value="0" />
                          </div>
                        </td>
                      </tr>
                      @endforeach

                      <tr>
                        <td colspan="3" class="text-right">
                          Treatment Fee (RM)
                        </td>
                        <td class="">
                          <div class="form-group">
                            <input type="text" class="form-control treat-fee" name="treat[fee]" value="{{ old('treat.fee', '0') }}" />
                          </div>
                        </td>
                      </tr>

                      @can('reception-edit')
                      <tr>
                      @else
                      <tr class="producut-hide">
                      @endcan
                        <td colspan="3" class="text-right">
                          Total Fees (RM)
                        </td>
                        <td class="">
                          <div class="form-group">
                            <input type="text" class="form-control productsum" name="treat[total]" value="{{ old('treat.total', '0') }}" readonly />
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <h3>Appointment</h3>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="days" class="d-block">Next Treatment</label>
                    {!! Form::select('treat[days]', [null=>'Please Select'] + $days, null, array('class' => 'form-control', 'id' => 'days')) !!}
                    @error('treat.days')
                    <small class="text-danger">{{ $message}}</small>
                    @enderror
                  </div>
                </div>
              </div>


              <button type="submit" name="submit" value="save" class="btn btn-primary">Submit</button>

              <button type="submit" name="submit" value="new-treat" class="btn btn-primary">Submit & New Treatment</button>

            </form>
         </div>



      </div>


      </div>

      </div>

    </div>


@endsection

@push('js')
<style>
.datepicker table tr td.today,  .datepicker table tr td.today:hover {
  background-color: #ccc;
}

.datetimepicker {
  background-color: #fff !important;
}

.table-responsive {
  overflow-y: hidden;
}


.producut-hide, .producut-hide td{
  visibility: hidden;
  display: block;
  height: 0;
}

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
$(document).ready(function() {
  //$("input").attr("autocomplete", "off");
    flatpickr('.datetimepicker', {
    enableTime: true,
    altInput: true,
    altFormat: "F j, Y H:i",
    dateFormat: "Y-m-d H:i",
    maxDate: new Date().fp_incr(1),
    minTime: "10:00",
    maxTime: "18:00",
    defaultHour: {{date('H')}},
    defaultMinute: {{date('i')}}
  });

  $('.treat-fee').on('change blur',function(){
      if($(this).val().trim().length === 0){
        $(this).val({{ old('fee', '0') }});
      }
    });

  getvalues();

  $('[class*=product], .treat-fee').change(function(){
    getvalues();
  });

  function getvalues(){
    $('[class*=productprice]').each(function (key, value) {
       var price = $(this).val();
       var unit = $('.productunit'+key).val();
       var total = price*unit;
       var fee = $('.treat-fee').val();
       $('.producttotal'+key).val(total);

       var productsum = parseFloat(fee);

       $('[class*=producttotal]').each(function () {
          productsum += parseFloat($(this).val());
       });

       $('.productsum').val(productsum);

    });

  };

  $('.btn-before').click(function(){
    var html = $('.clone.before').html();
    $('.increment.before').after(html);
  });

  $('.btn-after').click(function(){
    var html = $('.clone.after').html();
    $('.increment.after').after(html);
  });

  $('body').on('click', '.btn-danger', function(){
    $(this).parents(".control-group").remove();
  });

  $("body").on('change', '.custom-file input', function (e) {
    if (e.target.files.length) {
      $(this).next('.custom-file-label').html(e.target.files[0].name);
    }
  });

});
</script>
@endpush
