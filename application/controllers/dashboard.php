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
				 	$fee[$i]= $fee_total/1000;

				 }

			}
		}


		$arr1['name']= '"Total treatment"';
		$arr1['data']= '['.str_replace('"', '', implode(",",$t)).']';


		$arr2['name']= '"Total fee(in thousands)"';
		$arr2['data']= '['.str_replace('"', '', implode(",",$fee)).']';
				// echo json_encode($arr); die;
		//		$data['json'] = json_encode($arr1).','.json_encode($arr2);

		$data['json'] = json_encode($arr2);
		$data['json'] = str_replace('"', '', $data['json']);
		$data['json'] = str_replace("", '"', $data['json']);
		$data['json'] =  preg_replace('/\\\\/', '"', $data['json']);
		//echo $data['json']; die;
		$staff_id 				= $this->session->userdata('userid');
		$today = date('Y-m-d');
		$bday = date('m-d');
		$tomorrow = date("Y-m-d", strtotime("+1 day"));
		$data['birthday_today'] = $this->db->query("SELECT * FROM contact_list WHERE DATE_FORMAT(p_dob, '%m-%d') = '$bday' and is_deleted = 0")->result_array();
		$data['festival_today'] = $this->db->query("SELECT * FROM religious_festivals WHERE date= '$today' and is_deleted = 0")->result_array();

		$data['today_appointment'] = $this->db->query("SELECT * FROM appointment_schedule JOIN time_slot_master ON time_slot_master.pk = appointment_schedule.time_slot_id WHERE date_of_appointment = '$today' AND staff_id = $staff_id  AND is_deleted = 0")->result_array();
		$data['tomorrow_appointment'] = $this->db->query("SELECT * FROM appointment_schedule JOIN time_slot_master ON time_slot_master.pk = appointment_schedule.time_slot_id WHERE date_of_appointment = '$tomorrow' AND staff_id = $staff_id  AND is_deleted = 0")->result_array();


		$this->load->view('dashboard/dashboard',$data);

		 $this->load->view('include/footer');

	}
/*-----------------------------------------------------Start Dashboard--------------------------------------------------*/
}
?>
