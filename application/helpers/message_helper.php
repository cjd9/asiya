<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function flash_message()
{
	// Create CI instance -
	$CI =& get_instance();
	
	// get flash message array set from controller -
	$flashmsg = $CI->session->flashdata('message');
	
	$html='';
	
	if($flashmsg['type'] == "s")	// for success
	{
		$html="<div class='alert alert-success' role='alert'><button type='button' class='close' data-dismiss='alert'>x</button>" ; 
	}
	else	// for error
	{
		$html="<div class='alert alert-danger' role='alert'><button type='button' class='close' data-dismiss='alert'>x</button>";
	}
	
	$html = $html.'<span><strong>';
	$html = $html.$flashmsg['content']."</strong></span></div>";
	
	return $html;
}