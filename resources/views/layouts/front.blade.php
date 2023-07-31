<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('meta')
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="shortcut icon" href="{{ $website->favicon ?? asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('template/css/stellarnav.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/front.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- @livewireStyles --}}
    @stack('styles')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script asyncsrc="https://www.googletagmanager.com/gtag/js?id=UA-123598320-1"></script>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-123598320-1');
    </script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-123598320-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-123598320-1');
</script>

    <script type='text/javascript'
        src='https://platform-api.sharethis.com/js/sharethis.js#property=60b9c097858dc10011cdb7cc&product=sop'
        async='async'></script>


</head>

<body>
    <div class="main">

        <div class="header-moal">
            <div class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Contact Information</h5>
                            <button type="button" class="btn-close bt-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-logo">
                                <img src="{{ asset($website->logo_url ?? 'images/logo.png') }}"
                                    alt="{{ $website->name }} Logo">
                            </div>
                            <div class="contact-information">
                                <ul>
                                    <li>
                                        <div class="contact-information-icon">
                                            <i class="fa fa-map-o"></i>
                                        </div>
                                        <div class="contact-information-content">
                                            <a href="{{ @$website->map_url }}"
                                                title="{{ @$website->address ?? 'Sundhara, Kathmandu, Nepal' }}"
                                                target="_blank">
                                                {{ $website->phone[0]['contact_city'] ?? 'Sundhara, Kathmandu, Nepal' }}
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="contact-information-icon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <div class="contact-information-content">
                                            <a title="Phone"
                                                href="tel:{{ $website->phone[0]['phone_number'] ?? '+977015904030' }}">{{ $website->phone[0]['phone_number'] ?? '+977-01-5904030' }}</a>
                                            <a title="Phone"
                                                href="tel:{{ $website->phone[1]['phone_number'] ?? '+977 9807555929' }}">{{ $website->phone[1]['phone_number'] ?? '+977 9807555929' }}</a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="contact-information-icon">
                                            <i class="fa fa-paper-plane-o"></i>
                                        </div>
                                        <div class="contact-information-content">
                                            <a title=" Email"
                                                href="mainto:{{ $website->email ?? 'info@nectardigit.com' }}">{{ $website->email ?? 'info@nectardigit.com' }}</a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="contact-information-icon">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        <div class="contact-information-content">
                                            <a href="{{ env('APP_URL') }}" title="{{ env('APP_NAME') }}"
                                                target="_blank">{{ env('APP_URL') }}</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="modal-social-media">
                                @if (isset($website->facebook) || isset($website->twitter) || isset($website->linkedin) || isset($website->youtube) || isset($website->instagram))
                                    <h3>Follow Us On:</h3>
                                @endif
                                <ul>
                                    @if (isset($website->facebook))
                                        <li class="facebook"><a href="{{ @$website->facebook }}"
                                                title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    @endif
                                    @if (isset($website->twitter))
                                        <li class="twitter"><a href="{{ @$website->twitter }}" title="Twitter"
                                                target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    @endif
                                    @if (isset($website->linkedin))
                                        <li class="linkedin"><a href="{{ @$website->linkedin }}"
                                                title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    @endif
                                    @if (isset($website->youtube))
                                        <li class="youtube"><a href="{{ @$website->youtube }}" title="Youtube"
                                                target="_blank"><i class="fa fa-youtube"></i></a></li>
                                    @endif
                                    @if (isset($website->instagram))
                                        <li class="instagram"><a href="{{ @$website->instagram }}"
                                                title="Instagram" target="_blank"><i class="fa fa-instagram"></i></a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="top-header-right">
            <ul>
                <li><a href="https://wa.me/{{ '+977' . $website->phone[0]['phone_number'] ?? '+977-01-5904030' }}"
                        target="_blank" href="tel:{{ $website->phone[0]['phone_number'] ?? '+977-01-5904030' }}"><i
                            class="fab fa-whatsapp"></i></a></li>
            </ul>
        </div>



        <header class="header">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo">
                        <a href="{{ url('/') }}" title="{{ @$website->name ?? 'Home' }}"><img
                                src="{{ asset(@$website->logo_url ?? 'images/logo.png') }}"
                                alt="{{ $website->name ?? 'Logo' }}"></a>
                    </div>
                    <div class="header-right">
                        <div class="navbar">
                            <div class="stellarnav">
                                <ul>
                                    <li class="{{ request()->is('/') ? 'active' : ' ' }}"><a
                                            href="{{ url('/') }}"
                                            title="{{ @$website->name ?? 'Home' }}">Home</a></li>
                                    @foreach ($header_menus as $menu)
                                        @if ($menu->external_url == null)
                                            <li class="{{ request()->is($menu->slug) ? 'active' : '' }}">
                                                <a href="{{ route('page', $menu->slug) }}"
                                                    title="{{ $menu->title['en'] }}">{{ $menu->title['en'] }}</a>

                                                @if (count($menu->child_menu) > 0)
                                                    <ul>
                                                        @foreach ($menu->child_menu as $submenu)
                                                            <li>
                                                                <a href="{{ route('page', $submenu->slug) }}"
                                                                    title="{{ $submenu->title['en'] }}">{{ $submenu->title['en'] }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @else
                                            <li class="nav-item"><a href="{{ $menu->external_url }}"
                                                    title="{{ $menu->title }}">{{ $menu->title }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="right-toggle">
                            <button type="" class="bars" data-bs-toggle="modal">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </header>
        <!-- Header End -->

        @yield('content')



        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <div class="footer-content">
                            <div class="footer-logo">
                                <img src="{{ asset(@$website->logo_url ?? 'images/logo.png') }}"
                                    alt="{{ $website->name }} Logo">
                            </div>
                            <p>
                                {{ @$website->meta_description }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="footer-wrap footer-space">
                            <h3>Useful Links</h3>
                            <ul class="footer-links">
                                <li><a href="{{ url('/') }}" title="Home">Home</a></li>
                                @foreach ($footer_menus as $menu)
                                    @if ($menu->external_url != null)
                                        <li><a href="{{ $menu->external_url }}"
                                                title="{{ $menu->title['en'] }}">{{ $menu->title['en'] }}</a></li>
                                    @else
                                        <li><a href="{{ url($menu->slug) }}"
                                                title="{{ $menu->title['en'] }}">{{ $menu->title['en'] }}</a></li>
                                    @endif
                                    @if ($loop->iteration == 5)
                                    @break
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="footer-wrap footer-space1">
                            @if (isset($services))
                                <h3>Our Services</h3>
                                <ul class="footer-links">
                                    @foreach ($services as $slug => $value)
                                        <a href="{{ route('detailpage', ['type' => 'services', 'slug' => $slug]) }}"
                                            method="POST">
                                            @csrf
                                            <input type="text" name="type" value="services" style="display: none">
                                            <li><button title="{!! @$value !!}">{!! @$value !!}</button>
                                            </li>
                                        </a>
                                    @endforeach

                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="footer-wrap">
                            <h3>Quick Contact</h3>
                            <ul class="footer-contact">
                                <li>
                                    <div class="footer-contact-wrap">
                                        <div class="footer-contact-icon">
                                            <a href="{{ @$website->map_url }}"
                                                title="{{ @$website->address }}"
                                                target="_blank">
                                                <i class="fa-regular fa-map"></i>
                                            </a>
                                        </div>

                                        <div class="footer-contact-content">
                                            <a href="{{ @$website->map_url }}"
                                                title="{{ @$website->address }}"
                                                target="_blank">

                                                {{ $website->address }}
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="footer-contact-wrap">
                                        <div class="footer-contact-icon">
                                            <i class="far fa-envelope"></i>
                                        </div>
                                        <div class="footer-contact-content">
                                            <a
                                                href="mailto:{{ $website->email }}"><span>{{ $website->email }}</span></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="footer-contact-wrap">
                                        <div class="footer-contact-icon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <div class="footer-contact-content">
                                            <a
                                                href="tel:{{ $website->phone[0]['phone_number'] }}"><span>{{ $website->phone[0]['phone_number'] }}</span></a>
                                            <a
                                                href="tel:{{ $website->phone[1]['phone_number']  }}"><span>{{ $website->phone[1]['phone_number']  }}</span></a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer End -->

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <ul>
                    <li>
                        Copyright © 2021 Nectar Digit. All Right Reserved.</li>
                    <li>Design & Developed By : <a href="https://www.nectardigit.com/" target="_blank">Nectar Digit</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Footer Bottom End -->

        <!-- Scroll Top -->
        <div class="go-top">
            <div class="pulse">
                <i class="fa fa-chevron-up"></i>
            </div>
        </div>
        <!-- Scroll Top End -->
    </div>


    <script src="{{ asset('js/front.js') }}"></script>
    @stack('scripts')

</body>

</html>
