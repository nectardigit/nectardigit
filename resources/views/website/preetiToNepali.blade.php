<!doctype html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Preeti to Nepali Unicode Converter</title>
    <meta name="keywords" content="Unicode Nepali Devanagari Roman Typing Keyboard">
    <meta name="description" content="Roman to Unicode Converter.">
    <meta name="author" content="NepalKhabar">
    <meta name="ROBOTS" content="ALL">
    <meta name="Googlebot" content="index, follow">
    <meta name="distribution" content="Global">
    <meta name="document-type" content="web page">
    <meta name="resource-type" content="document">
    <link href="{{ asset('converter/preetitouni/css/uikit.min.css') }}" rel="stylesheet" />
    <link href="#" rel="shortcut icon" type="image/x-icon" />
    <script src="{{ asset('converter/preetitouni/js/jquery.min.js') }}"></script>
    <script src="{{ asset('converter/preetitouni/js/uikit.min.js') }}"></script>
    <script src="{{ asset('converter/preetitouni/js/uikit-icons.min.js') }}"></script>
    <script language="JavaScript" src="{{ asset('converter/preetitouni/js/preeti.js') }}"></script>
    <style>
        h1#site-title {

            text-align: center;
            font-size: 58px;
            font-weight: 600;
            margin: 10px 0 0 0;
        }

        h1#site-title a {
            text-decoration: none;
            color: #222222;
        }

        h1#site-title a:hover {
            color: #657086 !important;
        }
        input[type='button'] {
            background-color: #017EC4;
        }
    </style>
</head>

<body>
    <div class="uk-container-center">
        <div>
            <div class="uk-card-header">
                <h1 id="site-title" class="logo text-logo">
                    <a href="https://capitalnepal.com" target="_blank" itemprop="url" rel="home">
                        क्यापिटल नेपाल
                        <p style="font-size:11px">Version : 2.0</p>
                    </a>
                </h1>
            </div>
            <div class="uk-padding-remove-top" style="min-height: 600px;">
                <nav class="uk-navbar-container uk-light" uk-navbar style="background: #08132f;">
                    <div class="uk-navbar-center">
                        <div>
                            <ul class="uk-navbar-nav">
                                <li  class="uk-active"><a href="{{ route('preetiToNepali') }}">Preeti to Nepali Unicode</a></li>
                                <li><a href="{{ route('nepaliToPreeti') }}">Nepali Unicode to Preeti</a></li>
                                <li><a href="{{ route('romanToNepali') }}">Roman to Nepali
                                        Unicode</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="uk-section uk-section-default uk-section-small">

                    <div class="uk-container uk-container-center">

                        <form>
                            <div class="uk-grid uk-grid-small">
                            <div class="uk-width-1-2@m"><textarea class="textarea_unicode uk-textarea uk-width-1-1"  id="legacy_text" name="TextToConvert" rows="12" style="font-family:Preeti; font-size:20px;"></textarea></div>

                            <div class="uk-width-1-2@m"><textarea class="textarea_unicode uk-textarea uk-width-1-1"  id="unicode_text" name="ConvertedText" rows="12" style="font-size:20px;"></textarea></div>
                            </div>


                            <div class="uk-text-center unicode_roman">

                            <div class="unicode_cap_1 uk-margin-top"><input accesskey="c" class="uk-button uk-button-primary uk-width-1-1" id="converter" name="converter" onclick="convert_to_unicode();" title="Click here to convert preeti to nepali unicode" type="button" value="Click here to convert preeti to unicode" /></div>
                            </div>

                            </form>
                    </div>
                </div>
            </div>
        </div>
        <div style="background:#222; color: #fff; padding:30px 0;">
            <p class="uk-text-center uk-margin-remove-bottom">&copy; {{ Date('Y') }} www.capitalnepal.com, All Rights Reserved.</p>


        </div>
    </div>
</body>

</html>
