@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissable fade show">
    <button class="close" data-dismiss="alert" aria-label="Close">×</button>
    <strong>Success!</strong> {{ $message }}
</div>
@endif
@if ($message = Session::get('status'))
<div class="alert alert-success alert-dismissable fade show">
    <button class="close" data-dismiss="alert" aria-label="Close">×</button>
    {{ $message }}
</div>
@endif
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissable fade show">
    <button class="close" data-dismiss="alert" aria-label="Close">×</button>
    <strong>Error!</strong> {{ $message }}
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger alert-dismissable fade show">
    @foreach ($errors->all() as $error)
    <!-- <button class="close" data-dismiss="alert" aria-label="Close">×</button> -->
    <i class="fa fa-close"></i> {{ $error }} <br>
    @endforeach
</div>
@endif