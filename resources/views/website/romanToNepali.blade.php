<!doctype html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Roman to Nepali Unicode Converter</title>
    <meta name="keywords" content="Unicode Nepali Devanagari Roman Typing Keyboard">
    <meta name="description" content="Roman to Unicode Converter.">
    <meta name="author" content="NepalKhabar">
    <meta name="ROBOTS" content="ALL">
    <meta name="Googlebot" content="index, follow">
    <meta name="distribution" content="Global">
    <meta name="document-type" content="web page">
    <meta name="resource-type" content="document">
    <link href="{{ asset('converter/romantonepali/css/uikit.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('converter/romantonepali/js/jquery.min.js') }}"></script>
    <script src="{{ asset('converter/romantonepali/js/uikit.min.js') }}"></script>
    <script src="{{ asset('converter/romantonepali/js/uikit-icons.min.js') }}"></script>
    <script language="JavaScript" src="{{ asset('converter/romantonepali/js/k.js') }}"></script>
    <script language="JavaScript" src="{{ asset('converter/romantonepali/js/j.js') }}"></script>
    <script language="JavaScript" src="{{ asset('converter/romantonepali/js/d.js') }}"></script>
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
                                <li><a href="{{ route('preetiToNepali') }}">Preeti to Nepali
                                        Unicode</a></li>
                                <li><a href="{{ route('nepaliToPreeti') }}">Nepali Unicode to Preeti</a></li>
                                <li class="uk-active"><a href="{{ route('romanToNepali') }}">Roman to Nepali
                                        Unicode</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="uk-section uk-section-default uk-section-small">

                    <div class="uk-container uk-container-center">

                        <form name="Form1">


                            <div class="uk-grid uk-grid-small">
                                <div class="uk-width-1-2@m">
                                    <textarea name="asciiArchive" class="uk-textarea uk-width-1-1"
                                        onclick="javascript:asciiArchiveClick();" onkeyup="javascript:editArchive();"
                                        placeholder="Type Roman Here..." rows="12"> </textarea>
                                    <textarea name="ascii" onblur="javascript:asciiBlur();"
                                        onclick="javascript:asciiClick();" onkeyup="javascript:beginConvert(event);"
                                        rows="1" style="display:none;">यहाँ टाईप गर्नुहोस् ।</textarea>
                                </div>
                                <div class="uk-width-1-2@m">
                                    <textarea class="uk-textarea uk-width-1-1" name="unicodeArchive" readonly
                                        rows="12"></textarea>
                                    <textarea id="unicode" name="unicode" readonly rows="1" size="70"
                                        style="display:none;"></textarea>
                                </div>
                            </div>

                            <input checked="checked" name="smartConverter_"
                                onclick="javascript:smartConverter(Form1.smartConverter_.checked);convert();"
                                style="display:none;" type="checkbox" />


                            <div class="uk-margin-top">
                                <div class="uk-grid uk-grid-small" uk-grid>
                                    <div>
                                        <input class="uk-button uk-button-secondary uk-width-1-1" name="clear"
                                            onclick="javascript:clearInput();" type="button" value="Clear" />
                                    </div>

                                    <div>
                                        <input class="uk-button uk-button-primary uk-width-1-1" disabled="disabled"
                                            name="convertNow" onclick="javascript:convertArchive();"
                                            title="If the text is too large, press this button to convert."
                                            type="button" value="Convert Now" />
                                    </div>
                                    <div>
                                        <input class="uk-button uk-button-primary uk-width-1-1" name="sAll"
                                            onclick="javascript:selectAll(Form1.unicodeArchive);"
                                            style="margin-left: 5px;"
                                            title="On Internet Explorer, it will perform the 'Copy' command, too. But not so on other browsers due to their limitations. For those, after selected, right click and select 'Copy' "
                                            type="button" value="Select All" />
                                    </div>
                                    <div>
                                        <select class="uk-select uk-width-1-1" name="htmlEncode"
                                            onchange="javascript:toggleHTML();">
                                            <option selected="selected" value="false">Readable Unicode</option>
                                            <option value="true">HTML Encoded Unicode</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div style="background:#222; color: #fff; padding:30px 0;">
            <p class="uk-text-center uk-margin-remove-bottom">&copy; {{ Date('Y') }} www.capitalnepal.com, All
                Rights Reserved.</p>


        </div>
    </div>
</body>

</html>
