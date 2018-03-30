<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	: 	Smita S. Kad.
	Date 		: 	22-08-2015
	Demo Name 	: 	Patient Dashboard.
*/
class P_dashboard extends MY_Controller
{
	function P_dashboard()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Patient Dashboard--------------------------------------------------*/
	function index()
	{
		$this->load->view('p_dashboard/dashboard');
	}
/*-----------------------------------------------------End Patient Dashboard--------------------------------------------------*/
}
?>