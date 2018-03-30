<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('session');
		$this->load->helper('url');
		
		// check login -
		if(!$this->session->userdata('logged_in'))
		{ 
			redirect(base_url());
		}
		
		// set default time zone -
		date_default_timezone_set('Asia/Kolkata');
		
		$this->load->database();
		
  		$this->load->helper('common');
		$this->load->helper('message');
		$this->load->helper('file');
		$this->load->helper('dompdf');
		
  		$this->load->library('form_validation');
		$this->load->library('upload');
		
		// load master model -
		$this->load->model('mastermodel');
	}
	
	// function to check already exist in database using ajax - Date : 16-03-2015
	function is_exist()
	{   
		// get POST data -
		$field_name		= $_POST['field_name'];
		$field_value	= $_POST['field_value'];
		$table_name		= $_POST['table_name'];
		
		$left = array();
		$right = array();
		
		// get left & right of WHERE condition -
		$left = explode(',',$field_name);
		$right = explode(',',$field_value);
		
		$where = '';
		
		// prepare WHERE condition -
		foreach($left as $key => $value)
		{
			$where .= $value."= '".$right[$key]."'";
			
			if($key != count($left)-1)
			{
				$where .= " AND ";
			}
		}
		
		// define RESPONSE array -
		$response		= array();
		
		// set default FALSE, means NOT EXIST
		$response[0] = 0;
		
		// check in table -
		$res = $this->db->query("SELECT * FROM $table_name WHERE $where");
		
		if($res->num_rows() > 0)
		{
			// if exist, set TRUE
			$response[0] = 1;
		}
		
		// pass json response -
		header('Content-type: application/json');
		echo json_encode($response);
	}
	
	// function to get data from database using ajax - Date : 16-03-2015
	function get_data()
	{   
		// get POST data -
		$get_field		= $_POST['get_field'];
		$field_name		= $_POST['field_name'];
		$field_value	= $_POST['field_value'];
		$table_name		= $_POST['table_name'];
		$field_type		= $_POST['field_type'];
		
		// define 2 array's for WHERE condition -
		$left = array();
		$right = array();
		
		// get left & right of WHERE condition -
		$left = explode(',',$field_name);
		$right = explode(',',$field_value);
		
		$where = '';
		
		// prepare WHERE condition -
		foreach($left as $key => $value)
		{
			$where .= $value."= '".$right[$key]."'";
			
			if($key != count($left)-1)
			{
				$where .= " AND ";
			}
		}
		
		// define RESPONSE array -
		$response		= array();
		
		// get value(s) from table -
		$rs = $this->db->query("SELECT pk, $get_field FROM $table_name WHERE $where");
		
		if($rs->num_rows() > 0)
		{
			if($field_type == 'text')
			{		
				$response[] = $rs->row()->$get_field;
			}
			else
			{
				// prepare selectbox -
				$response[] = '<option value="">Please Select '.$get_field.' </option>';
				
				foreach($rs->result() as $row) :
					$response[] = '<option value="'.$row->pk.'">'.$row->$get_field.'</option>';
				endforeach;
			}
		}
		
		// pass json response -
		header('Content-type: application/json');
		echo json_encode($response);
	}
}