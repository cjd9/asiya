<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Smita S. Kad.
	Date 		: 	18-08-2015
	Demo Name 	: 	Activity Program.
*/
class Festival extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Activity Program--------------------------------------------------*/
	// Activity Program List
	function index()
	{
		$data['deleteaction'] =base_url().'festival/delete';

		// WHERE condition -
		//$where = array('festival.is_deleted' => 0);

		// get data from table -
		//$data['rsfestival'] = $this->mastermodel->get_data('*', 'festival', $where, NULL, NULL, 0, NULL);

		$data['rsfestival'] = $this->db->query("SELECT * from religious_festivals where is_deleted = 0");
		$this->load->view('festival/list',$data);
	}

	function import()
	{
		$data['deleteaction'] =base_url().'festival/delete';

		// WHERE condition -
		//$where = array('festival.is_deleted' => 0);

		// get data from table -
		//$data['rsfestival'] = $this->mastermodel->get_data('*', 'festival', $where, NULL, NULL, 0, NULL);

		$data['rsfestival'] = $this->db->query("SELECT * from religious_festivals where is_deleted = 0");
		$this->load->view('festival/import',$data);
	}

	// Activity Program Add
	function add()
	{
		$data['saveaction'] = base_url()."festival/save";
    $data['religion_list'] = $this->db->query("SELECT * FROM religion where 1");	// order by patient_id

		$this->load->view('festival/add',$data);
	}

	function import_cal()
	{
		if(!empty($_FILES['ical']['name']))
		{
			// config array for file -
			$config['upload_path']		= './ical/';	// folder name to store files -
			$config['allowed_types'] 	= '*';							// file type to be supported
			$config['max_size']			= '50000';						// maximum file size to upload

			// function to upload multiple files -
			$result = $this->mastermodel->upload_file('ical', $_FILES, $config);
			$file = $result[0][0];

		}

		include ( FCPATH.'/iCalEasyReader.php' );
		$ical = new iCalEasyReader();
		$file = FCPATH."/ical/".$file;
		$lines = $ical->load( file_get_contents($file ) );
		//print_r($lines);

		foreach($lines['VEVENT'] as $hol){
			if($hol['DTSTART']>=date('Ymd')){
				$arr['festival_name'] = $hol['SUMMARY'];
				$arr['date'] = date('Y-m-d', strtotime($hol['DTSTART']));
				$res = $this->mastermodel->add_data('religious_festivals', $arr);
				if(count($res)>0){
					$ret = TRUE;
				}
				else{
					$ret = FALSE;
				}

			}

    }
 			$this->mastermodel->redirect($ret, 'festival', 'festival', 'Added');





	}

	// Activity Program Edit
	function edit($festival_id)
	{
		$data['editaction'] = base_url()."festival/update";
    $data['religion_list'] = $this->db->query("SELECT * FROM religion where 1");	// order by patient_id

		// WHERE condition -
		$where = array('festival_id' => $festival_id, 'is_deleted' => 0);

		// get data from table -
		$data['rsfestival'] = $this->mastermodel->get_data('*', 'religious_festivals', $where, NULL, NULL, 0, NULL);

		$this->load->view('festival/edit',$data);
	}

	// Activity Program View
	function view($festival_id)
	{
		// WHERE condition -
    $data['editaction'] = base_url()."festival/update";
    $data['religion_list'] = $this->db->query("SELECT * FROM religion where 1");	// order by patient_id

		// WHERE condition -
		$where = array('festival_id' => $festival_id, 'is_deleted' => 0);

		// get data from table -
		$data['rsfestival'] = $this->mastermodel->get_data('*', 'religious_festivals', $where, NULL, NULL, 0, NULL);

		$this->load->view('festival/edit_new',$data);
	}

	// Activity Program Store Data to the DB
	function save()
    {
		// get form data -
		$data = $_POST;
  //  print_r($data); die;
		//var_dump($_FILES);

		// convert date format in form data -

		$data['date'] = $this->mastermodel->date_convert($data['date'],'ymd');

		// get evaluation id -

		$message = $data['message'];

		// save no. of xray report files -

			$data1 = array(
              'festival_name' => $data['festival_name'],
							'date'		=> $data['date'],
							'message'		=> $message,
							'religion_id' => implode(",",$data['religion_id'])
					);

			$res = $this->mastermodel->add_data('religious_festivals', $data1);


		if(empty($res))
		{
			$result = FALSE;
		}
		else
		{
			$result = TRUE;
		}

		// function used to redirect -
		$this->mastermodel->redirect($result, 'festival', 'festival', 'Added');
	}

	// Activity Program Update Data to the DB
	function update()
    {
		// get form data -
		$data = $_POST;

      //print_r($data); die;

		// convert date format in form data -
    $data['date'] = $this->mastermodel->date_convert($data['date'],'ymd');


	;
    $message = $data['message'];
    $data1 = array(
            'festival_name' => $data['festival_name'],
            'date'		=> $data['date'],
            'message'		=> $message,
            'religion_id' => implode(",",$data['religion_id'])
        );



		$where = array('festival_id' => $data['festival_id']);

		// remove patient id from array -
		unset($data['festival_id']);

		// WHERE condition -
		//$where = array('pk' => $data['edit_pk']);	// give name for edit record id field on form as 'edit_pk'

		// remove edit id from array -
		unset($data1['edit_pk']);

		$result = $this->mastermodel->update_data('religious_festivals', $where, $data1);

		// function used to redirect -
		$this->mastermodel->redirect($result, 'festival', 'festival', 'Updated');
    }

	// function to delete Activity file -
	function delete_festival_file()
	{
		$data['is_deleted'] 		= 1;

		$data['deleted_by_user']	= $this->session->userdata("userid");
		$data['date_deleted'] 		= date("Y-m-d h:i:s");

		// update details -
		$this->db->where('pk', $_POST['id']);
		$res = $this->db->update('festival', $data);

		if($res)
		{
			echo $_POST['id'];	// send delete id as response
		}
		else
		{
			echo 0;
		}
	}

	// Activity Program Delete Data to the DB
	function delete($festival_id)
	{ die;
		// WHERE condition -
		//$where = array('pk' => $pk);

		$result = $this->mastermodel->delete_data('religious_festivals', "festival_id = '$festival_id'");

		// function used to redirect -
		$this->mastermodel->redirect($result, 'festival', 'festival', 'Deleted');

	}
/*-----------------------------------------------------End Activity Program--------------------------------------------------*/
}
?>
