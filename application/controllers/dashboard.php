<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	: 	Smita S. Kad.
	Date 		: 	08-07-2015
	Demo Name 	: 	Dashboard.
*/
class Dashboard extends MY_Controller
{
	function Dashboard()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Dashboard--------------------------------------------------*/
	function index()
	{
		 $this->load->view('include/header'); 

		 $this->load->view('include/left'); 
		$this->load->view('dashboard/dashboard');

		 $this->load->view('include/footer'); 

	}
/*-----------------------------------------------------Start Dashboard--------------------------------------------------*/
}
?>