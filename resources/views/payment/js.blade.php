function getvalues(){
  $('[class*=productprice]').each(function (key, value) {
     var price = $(this).val();
     var unit = $('.productunit'+key).val();
     var total = price*unit;
     var fee = $('.treat-fee').val();
     var discount = $('.productdiscount').val();
     var bpackage = $('.variantValue').val();
     $('.producttotal'+key).val(total);

     var productsum = parseFloat(fee - discount);

     $('.treatmentfinal').val(productsum);

     $('[class*=producttotal]').each(function () {
        productsum += parseFloat($(this).val());
     });

     productsum += parseFloat(bpackage);

     $('.productsum').val(productsum);

  });

};

$.ajaxSetup({
  headers: {
  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

function getVariants(package_id){
  //var package_id = e.target.value;
  $.ajax({
    url:"{{ route('subVariants') }}",
    type:"POST",
    data: {
    package_id: package_id
    },
    success:function (data) {
      $('#buyVariant, #voucher-details').empty();
      $('.variantValue').val(0);
      getvalues();
      hideCheckCode();
      $('#buyVariant').append('<option value="">Choose Variant</option>');
      var pkgVarId = 0;
      @if(old('package.variant.id'))
        pkgVarId = {{old('package.variant.id')}};
      @endif
      $.each(data.variants[0].variants,function(index,varaint){
        if(pkgVarId == varaint.id) {
          $('#buyVariant').append('<option value="'+varaint.id+'" selected>'+varaint.name+'</option>');
        } else {
          $('#buyVariant').append('<option value="'+varaint.id+'">'+varaint.name+'</option>');
        }
      });

      if(pkgVarId != 0) {
        getVariantDetails(pkgVarId);
      }

    }
  })
};

function getVariantDetails(variant_id){
  hideCheckCode();
  $.ajax({
    url:"{{ route('varaintDetail') }}",
    type:"POST",
    data: {
    variant_id: variant_id
    },
    success:function (data) {
      //$('#voucher-details').append('<option value="">Choose Variant</option>');
      //console.log(data);
      if(data.variant[0]) {

        $('#voucher-details').empty();
        $('#voucher-details').append('<h2><del>RM '+data.variant[0].price+'</del> RM '+data.variant[0].sell+'</h2>');
        $('.variantValue').val(data.variant[0].sell);
        getvalues();
        @if(old('package.variant.id'))
        var olds = {!! json_encode(session()->getOldInput('package.voucher')) !!};
        @endif
        var arrIndex = 0;
        $.each(data.variant[0].vouchers,function(index,voucher){
          //console.log(voucher);
          $('#voucher-details').append('<div><h3>'+voucher.type.name+'</h3></div>');
          $('#voucher-details').append('<div class="row field-'+voucher.prefix+'"></div>');
          for (let i = 0; i < voucher.quantity; ++i) {
            var defValue = voucher.prefix;
            @if(old('package.variant.id'))
              if(olds[arrIndex].code && olds[arrIndex].code != null) {
                defValue = olds[arrIndex].code;
              }
            @endif
            $('.field-'+voucher.prefix).append('<div class="col-6"><input type="text" class="form-control" name="package[voucher]['+arrIndex+'][code]" value="'+defValue+'" /><input type="hidden" name="package[voucher]['+arrIndex+'][voucher_type_id]" value="'+voucher.type.id+'"></div>');
            arrIndex++;
          };

        });

        showCheckCode();

      } else {
        $('#voucher-details').empty();
      }//endif
    }
  })
};

@if(old('package.id'))
  getVariants({{old('package.id')}});
@endif

$('#buyPackage').on('change',function(e) {
  var package_id = e.target.value;
  getVariants(package_id);
});

$('#buyVariant').on('change',function(e) {
  var variant_id = e.target.value;
  getVariantDetails(variant_id);
});

$('#chk-code').click(function(){
  $('.loader').css('display', 'inline-block');
  var arr = [];
  $("input[name$='[code]']").each(function() {
    var value = $(this).val();
    var name = $(this).attr("name");
    var chkResult;
    if (arr.indexOf(value) == -1) {
      arr.push(value);
      $(this).removeClass("alert-danger");
      chkResult = ajaxChkCode(value, name);
      if(chkResult == 'yes') {
        $(this).addClass("alert-danger");
      } else {
        $(this).addClass("alert-success");
      }
    } else {
      $(this).addClass("alert-danger");
    }
      //console.log( this.value + ":" + this.value );
  });



  if ($('.alert-danger').length) {
    $("#hchkbox").val('');
  } else {
    $("#hchkbox").val('ok');
  }

  $('.loader').hide(500);

  return false;

});

function showCheckCode() {
  $('#chk-code').show();
  if(!$("#hchkbox").length){
    $('#hidden-chkbox').append('<input type="text" id="hchkbox" required oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);">');
  }
}

function hideCheckCode() {
  $('#chk-code').hide();
  $('#hidden-chkbox').empty();
}

function ajaxChkCode(code,name) {
  var result;

  $.ajax({
    async: false,
    url:"{{ route('checkCode') }}",
    type:"GET",
    data: {
    code: code,
    name: name
    },
    success:function (data) {
      //console.log(data.status);
      result = data.status;
      /*if(data.status == 'yes') {
        $("input[name='"+name+"']").addClass("alert-danger");
        $("#hchkbox").prop("checked", false );
      } else {
        $("#hchkbox").prop("checked", true );
      }*/
    }
  });

    return result;

};

function InvalidMsg(textbox) {

    if (textbox.value === '' || textbox.value!='ok') {
        textbox.setCustomValidity
              ('Please Check Codes');
    } else if (textbox.validity.typeMismatch) {
        textbox.setCustomValidity
              ('Please Check Codes');
    } else {
        textbox.setCustomValidity('');
    }

    return true;
}
