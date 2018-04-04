<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//use \PhpThumbFactory;

include APPPATH . "third_party/phpthumb/src/ThumbLib.inc.php";

class Common
{
    /**
     * function resizes the uploaded profile image into 2 thumbnails
     *          creates folder named as the users id @public/images/profile AND
     *          saves the thumnails @public/images/profile/{user-id}
     */    
    public static function createProfilePhotoThumbnails($source_file, $data = false, $resizeDimensions, $destination_path, $destination_filename, $extension)
    {
/*        if(!file_exists($destination_path)) {
            mkdir($destination_path);
        }*/

        //resize the image to the size which was used while cropping the image

        try {
            $thumbnail = PhpThumbFactory::create($source_file);
            if($data !== false) {
                $thumbnail->resize($data['image-w'], $data['image-h']);
                $thumbnail->crop($data['image-x'], $data['image-y'], $data['crop-w'], $data['crop-h']);
            }

            foreach ($resizeDimensions as $dimension) {
                $thumbnail->resize($dimension[0], $dimension[1]);
                $thumbnail->save($destination_path.DIRECTORY_SEPARATOR.$destination_filename);
            }
        } catch (Exception $e) {
            
        }
        
        return 1;
    }
    
    public static function getBigProfilePhotoName($profile_photo)
    {
        $pos = strrpos($profile_photo, '.');
        return substr($profile_photo, 0, $pos)."_".env('PROFILE_PHOTO_BIG_THUMB_WIDTH')."-".env('PROFILE_PHOTO_BIG_THUMB_HEIGHT').substr($profile_photo, $pos);
    }
    
    public static function getSmallProfilePhotoName($profile_photo)
    {
        $pos = strrpos($profile_photo, '.');
        return substr($profile_photo, 0, $pos)."_".env('PROFILE_PHOTO_SMALL_THUMB_WIDTH')."-".env('PROFILE_PHOTO_SMALL_THUMB_HEIGHT').substr($profile_photo, $pos);        
    }
    
    public static function getCurlRequest($url, $user_pwd = null, $post = null, $verifyPeer = false, $httpHeaders = null, $getrawdata = false)
    {
        // create a new cURL resource
        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        
        if($user_pwd != null)
            curl_setopt($ch, CURLOPT_USERPWD, $user_pwd);
        
        if(!is_null($post)){
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        }

        if(!is_null($httpHeaders)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders);
            curl_setopt($ch, CURLOPT_COOKIEJAR, "/tmp/cookie.txt");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        }

        if($verifyPeer)
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        
        if($getrawdata){
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
        }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);//prevents curl form printing data in the browser
        
        // execute the call
        $result = curl_exec($ch);

        // close cURL resource, and free up system resources
        curl_close($ch);
        
        if($getrawdata)
            return $result;
        else 
            return json_decode($result);
        
    }

    /**
     * generates encrypted token using mcrypt function
     * string to encrypt is $email_time()
     * @param String $email
     * @return array $result
     */
    public static function getEncryptedToken($email)
    {
        // Create the initialization vector for added security.
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);        
        $result['token'] = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, env('SECRET_KEY_256'), $email.'_'.time(), MCRYPT_MODE_CBC, $iv));
        $result['iv'] = base64_encode($iv);

        return $result;
    }

    /**
     * calculates age from date of birth
     * @param date $dob
     * @return int $age
     */
    public static function getAge($dob)
    {
        $from = new \DateTime(date('Y-m-d', strtotime(str_replace('/', '-', $dob))));
        $to = new \DateTime('today');
        $age = $from->diff($to)->y;

        return $age;
    }

    public static function randomString($length = 8)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass); //turn the array into a string
    }

    public static function generateUniqueNumericId($table, $column, $length, $prefix)
    {
        $unique_id = $prefix . self::getRandomNumber($length);

        $result = DB::table($table)->where($column, $unique_id)->first();
        while(!is_null($result)) {
            $unique_id = $prefix . self::getRandomNumber($length, $prefix);
            $result = DB::table($table)->where($column, $unique_id)->first();
        }

        return $unique_id;
    }

    public static function generateReferralCode($table, $column, $length, $prefix)
    {
        $referral_code = $prefix . self::getRandomNumber($length) . self::getRandomCharacter();

        $result = DB::table($table)->where($column, $referral_code)->first();
        while (!is_null($result)) {
            $referral_code = $prefix . self::getRandomNumber($length) . self::getRandomCharacter();
            $result = DB::table($table)->where($column, $referral_code)->first();
        }
        return $referral_code;
    }

    public static function getRandomNumber($length)
    {
        $random_number = '';
        for($i = 0; $i < $length; $i++) {
            $random_number .= rand(0, 9);
        }

        return $random_number;
    }

    public static function getRandomCharacter()
    {
        $chars = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $random_number = rand(0,25);
        return $rand_char = $chars[$random_number];
    }

    public static function generateUniqueOrderId($prefix = 'MDZ')
    {
        return $prefix.strtoupper(substr(uniqid(sha1(time())),0,6));
    }    

    public static function readMore($str,$minch,$maxch,$minln,$maxln)//(http|https?|ssh|ftp):\/\/[^\s"]+/
    {
        $string = trim($str);
        $string = nl2br($string);  
        $tempminch = $minch;
        $string2 = trim($string);
        $urlCount = 0;
        //replace url's in string with anchor tag
        //$string = preg_replace('/\b(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]/i', '<a class="linksInText" href="$0" target="_blank">$0</a>&nbsp;', $string);                
        
        $urlreg = "/(((www)\.{1})|(((ftp|http|https)\:\/\/)((www)\.{1})?)|((email)\.{1}))((([a-zA-Z0-9_]*\.{1})+([a-z]{2,6}))+(\.{1}[a-z]{2,4})?){1,}(\/[a-zA-Z0-9_.+!*(),;?:\/@&~=%-]*(\.{1}[a-z]{2,3})?(\/{1})?)?|(^\r\n\t)/";        
        $stpos = 0;
        $j = 0;

        if(preg_match_all($urlreg, $string2, $url))
        {
            $string = '';
            $urlCount = count($url[0]);
            $minuslength = 0;
            foreach($url[0] as $value)
            {
                if($j != ($urlCount - 1))
                {
                    $t = (strpos($string2,$value,$stpos) + strlen($value)) - $minuslength;
                    $string1 = substr($string2,$stpos,$t);                    
                }
                else                 
                    $string1 = substr($string2,$stpos); //last match

                $minuslength = $minuslength + strlen($string1); //accumulate length of each string
                $stpos = strpos($string2,$value,$stpos) + strlen($value); //update the new starting position

                if(!(substr($value,0,8) == 'https://' || substr($value,0,7) == 'http://')) //check for http and non-http links
                    $href = 'http://'.trim($value); 
                else
                    $href = trim($value);

                $chUrl = "<a class='linksInText' href=".$href." target='_blank'>".$value."</a>";
                $string = $string.str_replace($value,$chUrl,$string1); //concatenate string portions with the concatenating variable $mi
                
                if($j == 0)
                    $offset = strpos($string2,$value);
                
                if($offset < $tempminch)
                {
                    if($j < 4) //only for first four url links
                        $minch = $minch + 57 + (strlen($value) * 2); //increase the length of minimum characters
                    elseif($j > 4 && $j < 7) //only for the next first four url links
                        $maxch = $maxch + 57 + (strlen($value) * 2);         
                }
                $j++;
            } 
        }
       
        //count the number of new line characters in the post
        $v = preg_split('/<br>/',trim($string));
        $linecount = count($v);

        if($linecount > $minln)
        {           
            $result['textshow'] = implode("<br/>",array_slice($v,0,$minln));
            
            if($linecount > $maxln)
            { 
                $result['textshow'].= "<br/>";
                $result['texthide'] = implode("<br/>",array_slice($v,$minln));
                $result['readmoreflag'] = 1;
            }
            else
            {
                $result = self::readmoreUsingCharacters($string, $maxch, $minch, $urlCount);
            }                           
        } 
        else //if(strlen(trim($string)) > $minch)
        {       
            $result = self::readmoreUsingCharacters($string, $maxch, $minch, $urlCount);
        }
        
        //$result['textshow'] = $this->mailtoObfuscation($result['textshow']);
        //$result['texthide'] = $this->mailtoObfuscation($result['texthide']);
        return $result;
    }

    public static function readmoreUsingCharacters($string,$maxch,$minch,$urlCount)
    {
        if(strlen(trim($string)) > $minch)
        {                                    
            $startpos = 0;           
            $i = 0;
            $texthidepos = $minch;
            
            if($urlCount > 0) //check condition to find if the string contains atleast one url
            {
                while($i < $urlCount)
                {
                    $currenturlstartpos = strpos($string,'<a class="linksInText"',$startpos); //get the starting offset of the current url
                    $currenturlendpos = strpos($string,'</a>',$startpos); //get the ending offset of the current url
                    $startpos = $currenturlendpos + 4;  // update the starting position to the end position of current url
 
                    if($currenturlstartpos < $minch && $currenturlendpos > $minch) //check if the current url's starting offset is < min chara-
                    {                                                              //ter count and ending offset is greater than min character count
                        $result['textshow'] = substr($string,0,($currenturlendpos + 4));
                        $texthidepos = $currenturlendpos + 4;                        
                        break;
                    }
                    else
                    {
                        $result['textshow'] = substr($string,0,$minch);
                        $texthidepos = $minch;
                    }
                    
                    $i++;
                }
            }
            else
            {
                $result['textshow'] = substr($string,0,$texthidepos);
            }
                //now check condition to find if the string contains characters more the maximum number of characters
                if(strlen($string) > $maxch)
                {
                    $result['texthide'] = substr($string,$texthidepos);
                    $result['readmoreflag'] = 1;                                               
                }
                else
                {
                    $result['textshow'] = $string;
                    $result['texthide'] = null;
                    $result['readmoreflag'] = 0;
                }
        }
        else
        {
            $result['textshow'] = $string;
            $result['texthide'] = null;
            $result['readmoreflag'] = 0;      
        }        
        
        return $result;
    }

    public static function trimDrFromName($name)
    {
        $name = preg_replace('/^(dr)[\.]?[\s]?/i', '', $name);
        return ucwords(strtolower($name));
    }

    public static function getCountryIsdCodes()
    {
        return [
            "Afghanistan" => "93",
            "Albania" => "355",
            "Algeria" => "213",
            "American Samoa" => "1-684",
            "Andorra" => "376",
            "Angola" => "244",
            "Anguilla" => "1-264",
            "Antarctica" => "672",
            "Antigua and Barbuda" => "1-268",
            "Argentina" => "54",
            "Armenia" => "374",
            "Aruba" => "297",
            "Australia" => "61",
            "Austria" => "43",
            "Azerbaijan" => "994",
            "Bahamas" => "1-242",
            "Bahrain" => "973",
            "Bangladesh" => "880",
            "Barbados" => "1-246",
            "Belarus" => "375",
            "Belgium" => "32",
            "Belize" => "501",
            "Benin" => "229",
            "Bermuda" => "1-441",
            "Bhutan" => "975",
            "Bolivia" => "591",
            "Bosnia and Herzegovina" => "387",
            "Botswana" => "267",
            "Brazil" => "55",
            "British Indian Ocean Territory" => "246",
            "British Virgin Islands" => "1-284",
            "Brunei" => "673",
            "Bulgaria" => "359",
            "Burkina Faso" => "226",
            "Burundi" => "257",
            "Cambodia" => "855",
            "Cameroon" => "237",
            "Canada" => "1",
            "Cape Verde" => "238",
            "Cayman Islands" => "1-345",
            "Central African Republic" => "236",
            "Chad" => "235",
            "Chile" => "56",
            "China" => "86",
            "Christmas Island" => "61",
            "Cocos Islands" => "61",
            "Colombia" => "57",
            "Comoros" => "269",
            "Cook Islands" => "682",
            "Costa Rica" => "506",
            "Croatia" => "385",
            "Cuba" => "53",
            "Curacao" => "599",
            "Cyprus" => "357",
            "Czech Republic" => "420",
            "Democratic Republic of the Congo" => "243",
            "Denmark" => "45",
            "Djibouti" => "253",
            "Dominica" => "1-767",
            "Dominican Republic" => "1-809",
            "East Timor" => "670",
            "Ecuador" => "593",
            "Egypt" => "20",
            "El Salvador" => "503",
            "Equatorial Guinea" => "240",
            "Eritrea" => "291",
            "Estonia" => "372",
            "Ethiopia" => "251",
            "Falkland Islands" => "500",
            "Faroe Islands" => "298",
            "Fiji" => "679",
            "Finland" => "358",
            "France" => "33",
            "French Polynesia" => "689",
            "Gabon" => "241",
            "Gambia" => "220",
            "Georgia" => "995",
            "Germany" => "49",
            "Ghana" => "233",
            "Gibraltar" => "350",
            "Greece" => "30",
            "Greenland" => "299",
            "Grenada" => "1-473",
            "Guam" => "1-671",
            "Guatemala" => "502",
            "Guernsey" => "44-1481",
            "Guinea" => "224",
            "Guinea-Bissau" => "245",
            "Guyana" => "592",
            "Haiti" => "509",
            "Honduras" => "504",
            "Hong Kong" => "852",
            "Hungary" => "36",
            "Iceland" => "354",
            "India" => "91",
            "Indonesia" => "62",
            "Iran" => "98",
            "Iraq" => "964",
            "Ireland" => "353",
            "Isle of Man" => "44-1624",
            "Israel" => "972",
            "Italy" => "39",
            "Ivory Coast" => "225",
            "Jamaica" => "1-876",
            "Japan" => "81",
            "Jersey" => "44-1534",
            "Jordan" => "962",
            "Kazakhstan" => "7",
            "Kenya" => "254",
            "Kiribati" => "686",
            "Kosovo" => "383",
            "Kuwait" => "965",
            "Kyrgyzstan" => "996",
            "Laos" => "856",
            "Latvia" => "371",
            "Lebanon" => "961",
            "Lesotho" => "266",
            "Liberia" => "231",
            "Libya" => "218",
            "Liechtenstein" => "423",
            "Lithuania" => "370",
            "Luxembourg" => "352",
            "Macao" => "853",
            "Macedonia" => "389",
            "Madagascar" => "261",
            "Malawi" => "265",
            "Malaysia" => "60",
            "Maldives" => "960",
            "Mali" => "223",
            "Malta" => "356",
            "Marshall Islands" => "692",
            "Mauritania" => "222",
            "Mauritius" => "230",
            "Mayotte" => "262",
            "Mexico" => "52",
            "Micronesia" => "691",
            "Moldova" => "373",
            "Monaco" => "377",
            "Mongolia" => "976",
            "Montenegro" => "382",
            "Montserrat" => "1-664",
            "Morocco" => "212",
            "Mozambique" => "258",
            "Myanmar" => "95",
            "Namibia" => "264",
            "Nauru" => "674",
            "Nepal" => "977",
            "Netherlands" => "31",
            "Netherlands Antilles" => "599",
            "New Caledonia" => "687",
            "New Zealand" => "64",
            "Nicaragua" => "505",
            "Niger" => "227",
            "Nigeria" => "234",
            "Niue" => "683",
            "North Korea" => "850",
            "Northern Mariana Islands" => "1-670",
            "Norway" => "47",
            "Oman" => "968",
            "Pakistan" => "92",
            "Palau" => "680",
            "Palestine" => "970",
            "Panama" => "507",
            "Papua New Guinea" => "675",
            "Paraguay" => "595",
            "Peru" => "51",
            "Philippines" => "63",
            "Pitcairn" => "64",
            "Poland" => "48",
            "Portugal" => "351",
            "Puerto Rico" => "1-787",
            "Qatar" => "974",
            "Republic of the Congo" => "242",
            "Reunion" => "262",
            "Romania" => "40",
            "Russia" => "7",
            "Rwanda" => "250",
            "Saint Barthelemy" => "590",
            "Saint Helena" => "290",
            "Saint Kitts and Nevis" => "1-869",
            "Saint Lucia" => "1-758",
            "Saint Martin" => "590",
            "Saint Pierre and Miquelon" => "508",
            "Saint Vincent and the Grenadines" => "1-784",
            "Samoa" => "685",
            "San Marino" => "378",
            "Sao Tome and Principe" => "239",
            "Saudi Arabia" => "966",
            "Senegal" => "221",
            "Serbia" => "381",
            "Seychelles" => "248",
            "Sierra Leone" => "232",
            "Singapore" => "65",
            "Sint Maarten" => "1-721",
            "Slovakia" => "421",
            "Slovenia" => "386",
            "Solomon Islands" => "677",
            "Somalia" => "252",
            "South Africa" => "27",
            "South Korea" => "82",
            "South Sudan" => "211",
            "Spain" => "34",
            "Sri Lanka" => "94",
            "Sudan" => "249",
            "Suriname" => "597",
            "Svalbard and Jan Mayen" => "47",
            "Swaziland" => "268",
            "Sweden" => "46",
            "Switzerland" => "41",
            "Syria" => "963",
            "Taiwan" => "886",
            "Tajikistan" => "992",
            "Tanzania" => "255",
            "Thailand" => "66",
            "Togo" => "228",
            "Tokelau" => "690",
            "Tonga" => "676",
            "Trinidad and Tobago" => "1-868",
            "Tunisia" => "216",
            "Turkey" => "90",
            "Turkmenistan" => "993",
            "Turks and Caicos Islands" => "1-649",
            "Tuvalu" => "688",
            "U.S. Virgin Islands" => "1-340",
            "Uganda" => "256",
            "Ukraine" => "380",
            "United Arab Emirates" => "971",
            "United Kingdom" => "44",
            "United States" => "1",
            "Uruguay" => "598",
            "Uzbekistan" => "998",
            "Vanuatu" => "678",
            "Vatican" => "379",
            "Venezuela" => "58",
            "Vietnam" => "84",
            "Wallis and Futuna" => "681",
            "Western Sahara" => "212",
            "Yemen" => "967",
            "Zambia" => "260",
            "Zimbabwe" => "263",            
        ];
    }

    public static function generateRoutesExportFile($filename)
    {
        $content = "<?php\n\nreturn array(\n";

        foreach (\Route::getRoutes() as $route) {
            if(!is_null($route->getName())) {
                $content .= "\t'".$route->getName()."'=>'".$route->getPath()."',\n";
            }
        }

        $content .= ");";
        file_put_contents(public_path().DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$filename, $content);

        return 1;
    }

    public static function getPostSmallDescriptionFromContent($content, $max_length)
    {
        $striped = substr(preg_replace("/&#?[a-z0-9]{2,8};/i", "", strip_tags($content)), 0, $max_length);
        $striped .= strlen($content) > $max_length ? '...' : '';

        return $striped;
    }

    public static function isMobile()
    {
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
            return true;
        } else {
            return false;
        }

        // header('Location: http://detectmobilebrowser.com/mobile');
    }

    public static function getIndianStates()
    {
        return  array (
                     'AP' => 'Andhra Pradesh',
                     'AR' => 'Arunachal Pradesh',
                     'AS' => 'Assam',
                     'BR' => 'Bihar',
                     'CT' => 'Chhattisgarh',
                     'GA' => 'Goa',
                     'GJ' => 'Gujarat',
                     'HR' => 'Haryana',
                     'HP' => 'Himachal Pradesh',
                     'JK' => 'Jammu & Kashmir',
                     'JH' => 'Jharkhand',
                     'KA' => 'Karnataka',
                     'KL' => 'Kerala',
                     'MP' => 'Madhya Pradesh',
                     'MH' => 'Maharashtra',
                     'MN' => 'Manipur',
                     'ML' => 'Meghalaya',
                     'MZ' => 'Mizoram',
                     'NL' => 'Nagaland',
                     'OR' => 'Odisha',
                     'PB' => 'Punjab',
                     'RJ' => 'Rajasthan',
                     'SK' => 'Sikkim',
                     'TN' => 'Tamil Nadu',
                     'TR' => 'Tripura',
                     'UK' => 'Uttarakhand',
                     'UP' => 'Uttar Pradesh',
                     'WB' => 'West Bengal',
                    );
    }

    public static function formatVenueMediaCount($mediaArr)
    {
      $photos = 0;
      $videos = 0;

      foreach($mediaArr as $media)
      {
        if($media['media_type'] == 'photo')
        {
          $photos++;
        }

        if($media['media_type'] == 'video')
        {
          $videos++;
        }
      }

      return 'Photos: '.$photos;
    }

    public static function formatVenueCategories($categories)
    {
      $categoryArr = [];
      $categoryString = '';

      if(empty($categories))
      {
        return 'None';
      }

      foreach($categories as $cat)
      {
        $categoryArr[] = $cat['name'];
      }


      return implode(', ',$categoryArr);
    }

    public static function isEmpty($arr, $return = '-')
    {
      if(empty($arr))
      {
        return $return;
      }
      else
      {
        return $arr;
      }
    }

    public static function getStateNameFromAbbr($state_abbr)
    {
        $state_array = \Common::getIndianStates();

        return $state_array[strtoupper($state_abbr)];
    }
}