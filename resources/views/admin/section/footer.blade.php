</div>
{{-- <script src="{{ asset('/assets/front/js/jquery.min.js') }}" type="text/javascript"></script> --}}
<script src="{{ asset('js/manifest.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/vendor.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin.js') }}" type="text/javascript"></script>
{{-- <script src="//{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script> --}}
  
 @livewireScripts
@stack('scripts')
</body>
</html>