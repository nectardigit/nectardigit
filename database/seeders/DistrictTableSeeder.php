<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tbl_district = array(
            array('id' => '1','dist_id' => '09','dist_name' => 'सुनसरी','province_id' => 1),
            array('id' => '2','dist_id' => '10','dist_name' => 'मोरङ्ग','province_id' => 1),
            array('id' => '3','dist_id' => '01','dist_name' => 'ताप्लेजुङ्ग','province_id' => 1),
            array('id' => '4','dist_id' => '02','dist_name' => 'पाँचथर','province_id' => 1),
            array('id' => '5','dist_id' => '03','dist_name' => 'इलाम','province_id' => 1),
            array('id' => '6','dist_id' => '04','dist_name' => 'झापा','province_id' => 1),
            array('id' => '7','dist_id' => '05','dist_name' => 'संखुवासभा','province_id' => 1),
            array('id' => '8','dist_id' => '06','dist_name' => 'तेह्रथुम','province_id' => 1),
            array('id' => '9','dist_id' => '07','dist_name' => 'भोजपुर','province_id' => 1),
            array('id' => '10','dist_id' => '08','dist_name' => 'धनकुटा','province_id' => 1),
            array('id' => '11','dist_id' => '11','dist_name' => 'सोलुखम्बु','province_id' => 1),
            array('id' => '12','dist_id' => '12','dist_name' => 'खोटाङ्ग','province_id' => 1),
            array('id' => '13','dist_id' => '13','dist_name' => 'उदयपुर','province_id' => 1),
            array('id' => '14','dist_id' => '14','dist_name' => 'ओखलढुङ्गा','province_id' => 1),
            array('id' => '15','dist_id' => '17','dist_name' => 'धनुषा','province_id' => 2),
            array('id' => '16','dist_id' => '33','dist_name' => 'बारा','province_id' => 2),
            array('id' => '17','dist_id' => '34','dist_name' => 'पर्सा','province_id' => 2),
            array('id' => '18','dist_id' => '15','dist_name' => 'सप्तरी','province_id' => 2),
            array('id' => '19','dist_id' => '16','dist_name' => 'सिराहा','province_id' => 2),
            array('id' => '20','dist_id' => '18','dist_name' => 'महोत्तरी','province_id' => 2),
            array('id' => '21','dist_id' => '19','dist_name' => 'सर्लाही','province_id' => 2),
            array('id' => '22','dist_id' => '32','dist_name' => 'रौतहट','province_id' => 2),
            array('id' => '23','dist_id' => '27','dist_name' => 'काठमाण्डौं','province_id' => 3),
            array('id' => '24','dist_id' => '28','dist_name' => 'ललितपुर','province_id' => 3),
            array('id' => '25','dist_id' => '35','dist_name' => 'चितवन','province_id' => 3),
            array('id' => '26','dist_id' => '31','dist_name' => 'मकवानपुर','province_id' => 3),
            array('id' => '27','dist_id' => '20','dist_name' => 'सिन्धुली','province_id' => 3),
            array('id' => '28','dist_id' => '21','dist_name' => 'रामेछाप','province_id' => 3),
            array('id' => '29','dist_id' => '22','dist_name' => 'दोलखा','province_id' => 3),
            array('id' => '30','dist_id' => '23','dist_name' => 'सिन्धुपाल्चोक','province_id' => 3),
            array('id' => '31','dist_id' => '25','dist_name' => 'धादिङ्ग','province_id' => 3),
            array('id' => '32','dist_id' => '26','dist_name' => 'नुवाकोट','province_id' => 3),
            array('id' => '33','dist_id' => '29','dist_name' => 'भक्तपुर','province_id' => 3),
            array('id' => '34','dist_id' => '30','dist_name' => 'काभ्रेपलान्चोक','province_id' => 3),
            array('id' => '35','dist_id' => '24','dist_name' => 'रसुवा','province_id' => 3),
            array('id' => '36','dist_id' => '47','dist_name' => 'कास्की','province_id' =>4),
            array('id' => '37','dist_id' => '76','dist_name' => 'नवलपरासी (बर्दघाट सुस्ता पूर्व)','province_id' =>4),
            array('id' => '38','dist_id' => '42','dist_name' => 'स्याङ्गजा','province_id' =>4),
            array('id' => '39','dist_id' => '43','dist_name' => 'तनहुँ','province_id' =>4),
            array('id' => '40','dist_id' => '44','dist_name' => 'गोरखा','province_id' =>4),
            array('id' => '41','dist_id' => '46','dist_name' => 'लम्जुङ्ग','province_id' =>4),
            array('id' => '42','dist_id' => '48','dist_name' => 'पर्वत','province_id' =>4),
            array('id' => '43','dist_id' => '49','dist_name' => 'बाग्लुङ्ग','province_id' =>4),
            array('id' => '44','dist_id' => '50','dist_name' => 'म्याग्दी','province_id' =>4),
            array('id' => '45','dist_id' => '45','dist_name' => 'मनाङ','province_id' =>4),
            array('id' => '46','dist_id' => '51','dist_name' => 'मुस्ताङ','province_id' =>4),
            array('id' => '47','dist_id' => '37','dist_name' => 'रूपन्देही','province_id' => 5),
            array('id' => '48','dist_id' => '60','dist_name' => 'दाङ्ग','province_id' => 5),
            array('id' => '49','dist_id' => '62','dist_name' => 'बाँके','province_id' => 5),
            array('id' => '50','dist_id' => '36','dist_name' => 'नवलपरासी (बर्दघाट सुस्ता पश्चिम)','province_id' => 5),
            array('id' => '51','dist_id' => '38','dist_name' => 'कपिलवस्तु','province_id' => 5),
            array('id' => '52','dist_id' => '39','dist_name' => 'अर्घाखाँची','province_id' => 5),
            array('id' => '53','dist_id' => '40','dist_name' => 'पाल्पा','province_id' => 5),
            array('id' => '54','dist_id' => '41','dist_name' => 'गुल्मी','province_id' => 5),
            array('id' => '55','dist_id' => '58','dist_name' => 'रोल्पा','province_id' => 5),
            array('id' => '56','dist_id' => '59','dist_name' => 'प्यूठान','province_id' => 5),
            array('id' => '57','dist_id' => '63','dist_name' => 'बर्दिया','province_id' => 5),
            array('id' => '58','dist_id' => '77','dist_name' => 'रूकुम (पूर्व)','province_id' => 5),
            array('id' => '59','dist_id' => '52','dist_name' => 'मुगु','province_id' =>6),
            array('id' => '60','dist_id' => '53','dist_name' => 'डोल्पा','province_id' =>6),
            array('id' => '61','dist_id' => '55','dist_name' => 'जुम्ला','province_id' =>6),
            array('id' => '62','dist_id' => '56','dist_name' => 'कालिकोट','province_id' =>6),
            array('id' => '63','dist_id' => '57','dist_name' => 'रूकुम (पश्चिम)','province_id' =>6),
            array('id' => '64','dist_id' => '61','dist_name' => 'सल्यान','province_id' =>6),
            array('id' => '65','dist_id' => '64','dist_name' => 'सुर्खेत','province_id' =>6),
            array('id' => '66','dist_id' => '65','dist_name' => 'जाजरकोट','province_id' =>6),
            array('id' => '67','dist_id' => '66','dist_name' => 'दैलेख','province_id' =>6),
            array('id' => '68','dist_id' => '54','dist_name' => 'हुम्ला','province_id' =>6),
            array('id' => '69','dist_id' => '67','dist_name' => 'कैलाली','province_id' => 7),
            array('id' => '70','dist_id' => '68','dist_name' => 'डोटी','province_id' => 7),
            array('id' => '71','dist_id' => '69','dist_name' => 'आछाम','province_id' => 7),
            array('id' => '72','dist_id' => '70','dist_name' => 'बाजुरा','province_id' => 7),
            array('id' => '73','dist_id' => '71','dist_name' => 'बझाङ','province_id' => 7),
            array('id' => '74','dist_id' => '72','dist_name' => 'दार्चुला','province_id' => 7),
            array('id' => '75','dist_id' => '73','dist_name' => 'बैतडी','province_id' => 7),
            array('id' => '76','dist_id' => '74','dist_name' => 'डडेलधुरा','province_id' => 7),
            array('id' => '77','dist_id' => '75','dist_name' => 'कञ्चनपुर','province_id' => 7)
        );
        \DB::table('districts')->insert($tbl_district);
 
    }
}
