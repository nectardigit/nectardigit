<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="icon" type="" href="{{ asset('favicon.png') }}">
    <title>Subscriber Email</title>
</head>

<body style="font-family: 'Catamaran', sans-serif;margin:0;padding:20px;background:#ededed;">

    <div class="wrapper" style="max-width:700px;margin:auto;padding-left:20px;padding-right:20px;">
        <div class="email-wrapper"
            style="background:#fff;box-shadow: 0px 1px 3px 0px rgb(0 0 0 / 30%);border-radius: 3px;">
            <div class="title" style="padding:30px;">
                <h1
                    style="margin:0;line-height:normal;color:#155724;background:#d4edda;border:1px solid #c3e6cb;padding:10px 15px;font-size: 18px;font-weight: 600;line-height: 26px;border-radius:3px;text-align:center;">
                    Thank you for your subscription. Click <a href="{{env('APP_URL') ?? 'https://www.nectardigit.com/'}}" title="{{env('APP_NAME') ?? 'Necta Digit'}}"> Here </a>for more about us.</h1>
            </div>
            @if (isset($data))
                @foreach ($data as $key => $value)
                    @if ($key == '0')

                        <div class="banner">
                            <img src="{{ asset(@$value->featured_image) }}" alt="{{ @$value->title }}" width="100%"
                                style="height:350px;width:100%;object-fit:cover;">
                        </div>
                        <div class="banner-content" style="padding:30px 30px 0;">
                            <h2 style="margin-top:0;font-size:30px;line-height: 40px;">{{ @$value->title }}</h2>
                            <p style="margin-top:0;margin-bottom:20px;font-size: 18px;line-height: 26px;">
                                {!! limit_words(html_entity_decode(@$value->description), 50) !!}
                            </p>
                        </div>

                    @endif

                @endforeach
            @endif

            <div class="blog-wrap" style="padding:30px;padding-top:0;">
                <div class="blog-col"
                    style="display: flex;flex-wrap: wrap;margin-left: -10px;margin-right: -10px;justify-content: center;">
                    @if (isset($data))
                        @foreach ($data as $key => $value)
                            @if ($key > 0)

                                <div class="blog-list"
                                    style="padding-left: 10px;padding-right: 10px;width: 300px;margin-top:30px;">
                                 
                                    <a href="{{env('APP_URL').'/'.@$value->slug}}"  style="display:block;text-decoration:none;font-size:20px;line-height: 27px;color: #212121;font-weight: 600;">
                                        <img src="{{ asset(@$value->featured_image) }}" alt="{{ @$value->title }}"
                                                style="width:100%;height:200px;object-fit:cover;">
                                            <span style="display:block;margin-top:10px;"> {!! @$value->title !!}</span>
                                    </a>

                                </div>

                            @endif

                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>



    <script src="{{ asset('email_js/js/js/jquery-3.6.0.min.js') }}"></script>
</body>

</html>

</html>
