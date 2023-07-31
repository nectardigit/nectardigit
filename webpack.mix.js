const mix = require("laravel-mix");
mix.webpackConfig(webpack => {
    return {
        plugins: [
            new webpack.ProvidePlugin(
                {
                    $: "jquery",
                    jQuery: "jquery",
                    "window.jQuery": "jquery"
                },
                {
                    AOS: "aos"
                }
            )
        ]
    };
});
mix.js("resources/js/front.js", "public/js");
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |

 */

mix.postCss("resources/css/main.css", "public/assets/front/css/front.css", []);
