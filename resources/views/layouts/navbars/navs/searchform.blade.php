<form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto" action="{{ route('patient.search') }}" method="post">
  @csrf
  @isset($searchTerms)

  @endisset
  <div class="row">
    <div class="col-6">
      <div class="form-group">
        <input class="form-control form-control-sm" name="searchID" id="searchID" placeholder="by ID" type="text">
      </div>
    </div>

    <div class="col-6">
      <div class="form-group">
        <input class="form-control form-control-sm" name="searchAccount" id="searchAccount" placeholder="by Branches Patient No" type="text">
      </div>
    </div>

    <div class="col-6">
      <div class="form-group">
        <input class="form-control form-control-sm" name="searchName" id="searchName" placeholder="by Name" type="text">
      </div>
    </div>

    <div class="col-6">
      <div class="form-group">
        <input class="form-control form-control-sm" name="searchNRIC" id="searchNRIC" placeholder="by NRIC" type="text">
      </div>
    </div>

    <div class="col-6">
      <div class="form-group">
        <input class="form-control form-control-sm" name="searchEmail" id="searchEmail" placeholder="by Email" type="text">
      </div>
    </div>

    <div class="col-6">
      <div class="form-group">
        <input class="form-control form-control-sm" name="searchContact" id="searchContact" placeholder="by Contact" type="text">
      </div>
    </div>

    <button type="submit" name="submit" value="save" class="btn btn-primary d-none">Submit</button>

  </div>
</form>

{{-- <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto" action="{{ route('patient.search') }}" method="post">
  @csrf
    <div class="form-group mb-0">
        <div class="input-group input-group-alternative bg-primary">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input class="form-control" name="search" id="search" placeholder="Search ID (p*) / Name / NRIC / Email /Contact" type="text" value="{{ $searchTerm ?? '' }}">
        </div>
    </div>
</form> --}}

@push('js')
<style>
.search-form {
  display: none;
  position: absolute;
  right: 0;
  top: 24px;
  width: 500px;
}

.search-form .form-control {
  margin-bottom: 0.5rem;
  width: 100%;
}
</style>

<script>
$(document).ready(function(){
  $(".ttm-search").click(function(){
    $(".search-form").toggle();
  });
});
</script>
@endpush
