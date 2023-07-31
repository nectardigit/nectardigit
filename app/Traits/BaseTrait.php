<?php
namespace App\Traits ;

use App\Models\AppSetting;

/**
 *
 */
trait BaseTrait
{
    public $_website;
    public $settings;
    public $locale ;
    public function get_web()
    {
        $website = cache()->remember('sitesetting', 60 * 60 * 24, function () {
            return AppSetting::select('*')->orderBy('created_at', 'desc')->first();
        });
        $this->settings = $website;
        // return $this->_website = $website;
        $this->locale = @$website->website_content_format == 'Nepali' || @$website->website_content_format == 'Both'  ? 'np' : 'en';
         return  $this->_website = @$website->website_content_format ?? 'Nepali';
        //   dd( $this->_website);
    }
}
