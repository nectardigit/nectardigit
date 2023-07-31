@if(session('success') ||session('error')||session('warning')||session('status'))
@push('scripts')
    <script src="{{asset('plugins/toastrjs/toastr.min.js')}}"></script>
    <script>

        toastr.options.closeButton = true
        @if(session('success'))

        toastr.success("{{Session::get('success')}}","Success !")
        @endif
        @if(session('error'))
        toastr.error("{{Session::get('error')}}","Error !")
        @endif
        @if(session('warning'))
        toastr.warning("{{Session::get('warning')}}","Warning !")
        @endif
        @if(session('status'))
        toastr.success("{{ucfirst(Session::get('status'))}}","Success !")
        @endif
    </script>
@endpush

@endif
