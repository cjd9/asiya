<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	: 	Smita S. Kad.
	Date 		: 	08-07-2015
	Demo Name 	: 	Dashboard.
*/
class Dashboard extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Dashboard--------------------------------------------------*/
	function index()
	{
		 $this->load->view('include/header'); 

		 $this->load->view('include/left'); 
		$current_staff_id = $this->session->userdata("userid");

		$treatment = $this->db->query("SELECT month(date_of_treatment) as month,treatment_fees FROM treatment WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0 ORDER BY patient_id")->result_array();
		//print_r($data['rspatient']->result_array()); die;
		$fee_total  = 0;
		$treatment_total = '';
		for($i=1; $i<=12; $i++){
			$count = 0;
			$fee_total  = 0;

			$t[$i] = $count;
			$fee[$i] = $fee_total;
			foreach($treatment as $row){
				 if($row['month'] == $i){
				 	$count = $count + 1;

				 	$fee_total += $row['treatment_fees'];
				 	$treatment_total = $count;
				 	$t[$i] = $count;
				 	$fee[$i]= $fee_total;

				 }

			}
		}


		$arr1['name']= '"treatment"';
		$arr1['data']= '['.str_replace('"', '', implode(",",$t)).']';
		

		$arr2['name']= '"fee"';
		$arr2['data']= '['.str_replace('"', '', implode(",",$fee)).']';
				// echo json_encode($arr); die;

		$data['json'] = json_encode($arr1).','.json_encode($arr2); 
		$data['json'] = str_replace('"', '', $data['json']);
		$data['json'] = str_replace("", '"', $data['json']);
		//echo $data['json']; die;


		$this->load->view('dashboard/dashboard',$data);

		 $this->load->view('include/footer'); 

	}
/*-----------------------------------------------------Start Dashboard--------------------------------------------------*/
}
?>