<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Php_mailer
{

    private $apiKey   = "a299a5ea-f430-4557-bb62-fbb8acf2f8a2";
    private $userName = "dclyde14@gmail.com";

    public function __construct($userName=NULL,$apiKey=NULL)
    {
        if($userName != NULL) $this->userName = $userName;
        if($apiKey != NULL)   $this->apiKey = $apiKey;
    }

//    function index()
//    {
//        $params['csvFilePath'] = $_SERVER['DOCUMENT_ROOT'].'/Downloads/test1.csv';
//        $params['csvFileName'] = 'test1.csv';
////        $params['from'] = 'help@samco.in';
////        $params['fromName'] = 'Samco';
//        //$params['subject'] = 'Elastic email HTML Template test mail';
//        $params['templateName'] = 'award-ceremony-04-04-16';
//
////        $params['bodyHTML'] = '';
////        $params['bodyText'] = '';
////        $params['attachments'] = array(
////            array('filePath'=> $_SERVER['DOCUMENT_ROOT'].'/Downloads/test1.csv','fileName'=>'testattachment1.csv'),
////            array('filePath'=> $_SERVER['DOCUMENT_ROOT'].'/Downloads/test1.csv','fileName'=>'testattachment2.csv')
////        );
//
//        $res = $this->mailMerge($params);
//
//        echo $res;
//    }

   function sendMail_test()
   {
       $params['from'] = 'dclyde14@gmail.com';
       $params['fromName'] = 'Clyde';
       $params['to'] = 'dclyde27@gmail.com';
       $params['subject'] = 'Elastic Test mail';
       $params['bodyHTML'] = '<br><br><br><p>Test mail from Elastic email</p>';
			$res = $this->sendElasticEmail( $params['to'], $params['subject'], 'test text', $params['bodyHTML'], $params['from'], $params['fromName'],false);

       print_r( $res);

   }

    /**
	 * Uploading attachments
	 * @param string $content Content of the file to upload
	 * @param string $fileName
	 */
//	function uploadAttachment($content, $fileName)
//	{
//		$res = "";
//		$header = "PUT /attachments/upload?username=".urlencode($this->userName)."&api_key=".urlencode($this->apiKey)."&file=".urlencode($fileName)." HTTP/1.0\r\n";
//		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
//		$header .= "Content-Length: " . strlen($content) . "\r\n\r\n";
//		$fp = @fsockopen("ssl://api.elasticemail.com", 443, $errno, $errstr, 30);
//		if(!$fp)
//		{
//			return "ERROR. Could not open connection";
//		}
//		else
//		{
//			fputs ($fp, $header.$content);
//			while (!feof($fp))
//			{
//				$res .= fread ($fp, 1024);
//			}
//			fclose($fp);
//		}
//                $res = explode("\r\n\r\n", $res, 2);
//                return ((isset($res[1])) ? $res[1] : '');
//	}

    function uploadAttachment($filepath, $filename)
    {
        $data = http_build_query(array('username' => urlencode($this->userName),'api_key' => urlencode($this->apiKey),'file' => urlencode($filename)));
        $file = file_get_contents($filepath);
        $result = '';

        $fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);

        if ($fp){
            fputs($fp, "PUT /attachments/upload?".$data." HTTP/1.1\r\n");
            fputs($fp, "Host: api.elasticemail.com\r\n");
            fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            fputs($fp, "Content-length: ". strlen($file) ."\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $file);
            while(!feof($fp)) {
                $result .= fgets($fp, 128);
            }
        } else {
            return array(
                'status'=>false,
                'error'=>$errstr.'('.$errno.')',
                'result'=>$result);
        }
        fclose($fp);
        $result = explode("\r\n\r\n", $result, 2);
//        return array(
//            'status' => true,
//            'attachId' => isset($result[1]) ? $result[1] : ''
//        );
        return ((isset($result[1])) ? $result[1] : '');
    }

    function sendElasticEmail($to, $subject, $body_text, $body_html, $from, $fromName, $attachments)
    {

				$apikey = $this->apiKey ;
					$username = $this->userName ;
				
        $res = "";

        $data = "username=".$username;
        $data .= "&api_key=".$apikey;
        $data .= "&from=".urlencode($from);
        $data .= "&from_name=".urlencode($fromName);
        $data .= "&to=".urlencode($to);
        $data .= "&subject=".urlencode($subject);
        if($body_html)
          $data .= "&body_html=".urlencode($body_html);
        if($body_text)
          $data .= "&body_text=".urlencode($body_text);

        if($attachments)
          $data .= "&attachments=".urlencode($attachments);

        $header = "POST /mailer/send HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
        $fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);
				print_r($fp);
        if(!$fp)
          return "ERROR. Could not open connection";
        else {
          fputs ($fp, $header.$data);
          while (!feof($fp)) {
            $res .= fread ($fp, 1024);
          }
          fclose($fp);
        }
        return $res;
    }

//$attach = uploadAttachment("./test.jpg", "test.jpg");
//echo sendElasticEmail("test@test.com", "My Subject", "My Text", "My HTML", "you@yourdomain.com", "Your Name", $attach['attachId']);




	/**
	 * Sending simple email
	 * @param string $from
	 * @param string $fromName
	 * @param string $to
	 * @param string $subject
	 * @param string $bodyText
	 * @param string $bodyHTML
	 */
	function mandrill_send($params)
	{
            $res = "";
            $data = "username=".urlencode($this->userName);
            $data .= "&api_key=".urlencode($this->apiKey);
            $data .= "&from=".urlencode($params['from'][0]);
            $data .= "&from_name=".urlencode($params['from'][1]);

//            if (!function_exists('array_column')) {
//                $email_ids = $this->get_array_column($params['to'], 'email_id');
//            } else {
//                $email_ids = array_column($params['to'], 'email_id');
//            }

            foreach($params['to'] as $to_arr)
            {
                $email_ids[] = $to_arr[0];
            }

            $semi_colon_seperated_to_emails = implode(';',$email_ids);
            $data .= "&to=".urlencode($semi_colon_seperated_to_emails);
            $data .= "&subject=".urlencode($params['subject']);


            if(!empty($params['templateName']))
            {
                $data .= "&template=".$params['templateName'];
            }
            else
            {
                if($params['message']) $data .= "&body_html=".urlencode($params['message']);
                if($params['bodyText']) $data .= "&body_text=".urlencode($params['bodyText']);

            }

            if(!empty($params['channel']))
            {
                $data .= "&channel=".urlencode($params['channel']);
            }

            if(!empty($params['merge_vars']))
            {
                foreach ($params['merge_vars'] as $key => $value) {
                    $data .= "&merge_".$key."=".urlencode($value);
                }
            }

            if(!empty($params['attachment']))
            {
                $attachIDs = [];
                foreach($params['attachment'] as $attachment)
                {
                    $attachment_explode = explode('/',$attachment[0]);
                    $filename = $attachment_explode[count($attachment_explode)-1];
                    $attachIDs[] = $this->uploadAttachment($attachment[0], $filename);
                }

                $attachIDList = implode(';', $attachIDs);
                $data .= "&attachments=".urlencode($attachIDList);
            }

            $header = "POST /mailer/send HTTP/1.0\r\n";
            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
            $fp = @fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);
            if(!$fp)
            {
                    return "ERROR. Could not open connection";
            }
            else
            {
                    fputs ($fp, $header.$data);
                    while (!feof($fp))
                    {
                            $res .= fread ($fp, 1024);
                    }
                    fclose($fp);
            }
            return $res;
	}



	/**
	 * Sending emails with Elastic MailMerge
	 * @param string $csv Content of the CSV File to send
	 * @param string $from
	 * @param string $fromName
	 * @param string $subject
	 * @param string $bodyText
	 * @param string $bodyHTML
	 */
	function mailMerge($params)
	{
            //$csvName = $params['csvName']; //mailmerge.csv
            $attachID = $this->uploadAttachment($params['csvFilePath'], $params['csvFileName']);

            $res = "";
            $data = "username=".urlencode($this->userName);
            $data .= "&api_key=".urlencode($this->apiKey);
            $data .= "&from=".urlencode($params['from']);
            $data .= "&from_name=".urlencode($params['fromName']);
            $data .= "&subject=".urlencode($params['subject']);
            $data .= "&data_source=".urlencode($attachID);
            if(!empty($params['bodyHTML']))
                $data .= "&body_html=".urlencode($params['bodyHTML']);
            if(!empty($params['bodyText']))
                $data .= "&body_text=".urlencode($params['bodyText']);
            if(!empty($params['channel']))
                $data .= "&channel=".urlencode($params['channel']);

            $data .= "&template=".$params['templateName'];

            if(!empty($params['attachments']))
            {
                $attachIDs = [];
                foreach($params['attachments'] as $attachment)
                {
                    $attachIDs[] = $this->uploadAttachment($attachment['filePath'], $attachment['fileName']);
                }

                $attachIDList = implode(';', $attachIDs);
                $data .= "&attachments=".urlencode($attachIDList);
            }

            $header = "POST /mailer/send HTTP/1.0\r\n";
            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
            $fp = @fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);

            if(!$fp)
            {
                    return "ERROR. Could not open connection";
            }
            else
            {
                fputs ($fp, $header.$data);
                while (!feof($fp))
                {
                        $res .= fread ($fp, 1024);
                }
                fclose($fp);
            }

            return $res;
	}

        function get_array_column($array, $field)
        {
            $arr = array();
            if (!empty($array)) {
                foreach ($array as $k => $v) {
                    $arr[] = $v[$field];
                }
                return $arr;
            } else {
                return $arr;
            }
        }
}

# Demo :
//require_once 'BaseElasticEmail.php';
//$ee = new BaseElasticEmail();
//
//$csv  = '"ToMail","Title","FirstName","LastName"'."\n";
//$csv .= '"smith@example.com","Mr","Alexander","Smith"'."\n";
//$csv .= '"dupon@example.com","Miss","Sarah","Dupon"'."\n";
//
//$text = 'Hello {Title} {LastName}, your first name is {FirstName}.'
//
//$res = $ee->mailMerge($csv, "demo@example.com", "Demo", "Demo Mail Merge", $text);
//var_dump($res);






/* End of file elastic_email.php */
/* Location: ./application/controllers/elastic_email.php */
