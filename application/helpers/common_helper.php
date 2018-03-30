<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// function to check user login -
function is_login()
{
	$CI =& get_instance();
	
	if(!$CI->session->userdata('logged_in'))
	{
		$CI->load->view('login/login');
		$CI->session->set_flashdata('message', array( 'title' => 'Login Required', 'content' => 'You Have Not Login. Please Login', 'type' => 'msg msg-error' ));
		return true;
	}
	else
	{
		return false;
	}
}

//******************** Encrypt & Decrypt Password *************************//
// Added By		: 	Bhagwan Sahane
// Added Date	:	31-08-2015
// Ref			:	http://stackoverflow.com/questions/15194663/encrypt-and-decrypt-md5

// function to encrypt pasword -
function encrypt($q)
{
    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
    return($qEncoded);
}

// function to decrypt pasword -
function decrypt($q)
{
    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
    return($qDecoded);
}
//******************** Encrypt & Decrypt Password *************************//
?>