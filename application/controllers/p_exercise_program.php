<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Smita S. Kad.
	Date 		: 	06-08-2015
	Demo Name 	: 	Patient Exercise Program.
*/
class P_exercise_program extends MY_Controller
{
	function P_exercise_program()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Exercise Program--------------------------------------------------*/
	// Exercise Program List
	function index()
	{
		// get current login user -
		$current_patient_id = $this->session->userdata("userid");

		// get current date -
		$current_date = date("Y-m-d");

		// get exercise program details of those patient assign to login staff -
		$data['rsexercise_program'] = $this->db->query("SELECT DISTINCT(exercise_id), patient_id, date_of_upload, expiry_date FROM exercise_program WHERE patient_id IN (SELECT patient_id FROM contact_list WHERE pk = $current_patient_id) AND expiry_date >= '$current_date' AND is_deleted = 0");

		$this->load->view('p_exercise_program/list',$data);
	}

	// Exercise Program View
	function view($exercise_id)
	{
		// WHERE condition -
		// WHERE condition -
	$data['editaction'] = base_url()."exercise_program/update";

		$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);

		// WHERE condition -
		$where = array('exercise_id' => $exercise_id, 'exercise_program.is_deleted' => 0);

		// get data from table -
		$data['rsexercise_program'] = $this->mastermodel->get_data('*', 'exercise_program', $where, NULL, NULL, 0, NULL);
					 $data['video_list'] = $this->db->query("SELECT DISTINCT tag FROM exercise_video_master ")->result_array();

		$html='';
			$selected_vids = $this->db->query("SELECT * FROM exercise_meta where exercise_id = '".$exercise_id."' and (CURDATE() BETWEEN exercise_start_date AND exercise_end_date)");

			foreach($selected_vids->result_array() as $vid){
			 $html .= '<div class="col-xs-12 col-sm-12 col-md-3 " style="margin-top: 15px;">

					 <div class="outer-containerl img-thumbnail">
							 <div class="inner-container" >
									 <div class="video-overlay"></div>

									 <a href="'. $vid["vid_link"].'"> LINK</a><br><br>
										<label  id="delete_video" value="'. $vid["vid_name"].'"> '. $vid["vid_name"].'</label><br>

									 <video id="player" class="img-thumbnail" src="/exercise_program_file/'. $vid["vid_name"].'"  width="300" height="200"></video>
							 </div>
								 <div class = "form-control">
									<label class="control-label" for="">Start Date:</label> <input type="text" class="form-control datepicker" disabled value="'.$vid["exercise_start_date"].'"  name="video['.$vid["id"].'][exercise_start_date]" placeholder="dd-mm-yyyy" >
									<label class="control-label" for="">End Date:</label> <input type="text" class="form-control datepicker" disabled value="'.$vid["exercise_end_date"].'" name="video['.$vid["id"].'][exercise_end_date]" placeholder="dd-mm-yyyy" >

									 <label class="control-label" for="">No of Reps:</label>  <input type="number" disabled name="edit_video['.$vid["id"].'][reps]" value="'.$vid["reps"].'" class= "form-control" placeholder="No Of reps">
									 <label class="control-label" for="">No of Sets:</label>     <input type="number" disabled name="edit_video['.$vid["id"].'][sets]" value="'.$vid["sets"].'" class= "form-control" placeholder="No Of sets">
									 <label class="control-label" for="">Hold Time:</label>     <input type="number" disabled disabled name="edit_video['.$vid["id"].'][hold_time]" value="'.$vid["hold_time"].'" class= "form-control" placeholder="Hold Time">
									 <input type = "hidden" disabled name ="edit_video['.$vid["id"].'][vid_name]" value="'.$vid["vid_name"].'">
										<input type = "hidden" disabled name ="edit_video['.$vid["id"].'][insert_id]" value="'.$vid["id"].'">

								 </div>
						 </div>
				 </div>';
				}

				$data['html'] = $html;
		$this->load->view('p_exercise_program/edit_new',$data);
	}
/*-----------------------------------------------------End Exercise Program--------------------------------------------------*/
}
?>
