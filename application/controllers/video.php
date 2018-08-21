<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Smita S. Kad.
	Date 		: 	18-08-2015
	Demo Name 	: 	Activity Program.
*/
class Video extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Activity Program--------------------------------------------------*/
	// Activity Program List
	function index()
	{
		$data['deleteaction'] =base_url().'video/delete';

		// WHERE condition -
		//$where = array('festival.is_deleted' => 0);

		// get data from table -
		//$data['rsfestival'] = $this->mastermodel->get_data('*', 'festival', $where, NULL, NULL, 0, NULL);

		$data['rsvideo'] = $this->db->query("SELECT * from exercise_video_master");
    $data['tags'] = $this->db->query("SELECT * from tag_master");
		$this->load->view('video/list',$data);
	}



	// Activity Program Add
	function add()
	{
		$data['saveaction'] = base_url()."festival/save";
    $data['religion_list'] = $this->db->query("SELECT * FROM religion where 1");	// order by patient_id

		$this->load->view('festival/add',$data);
	}


	// Activity Program Edit
	function edit($id)
	{
		$data['editaction'] = base_url()."video/update";
    $data['rsvideo'] = $this->db->query("SELECT * from exercise_video_master");
    $data['tags'] = $this->db->query("SELECT * from tag_master");

		// WHERE condition -
		$where = array('id' => $id);

		// get data from table -
		$data['rsvideo'] = $this->mastermodel->get_data('*', 'exercise_video_master', $where, NULL, NULL, 0, NULL);

		$this->load->view('video/edit',$data);
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


    $message = $data['message'];
    $data1 = array(
            'title' => $data['title'],
            'tag'		=> $data['tag'],
            'description'		=> $data['description']
        );



    $this->db->where('id', $data['id']);
                $this->db->update('exercise_video_master', $data1);

		$this->mastermodel->redirect(TRUE, 'video', 'video', 'Updated');
    }



    function delete($id)
  	{
  		 $this->db->where('id', $id);
           $this->db->delete('exercise_video_master');

  		// function used to redirect -
  		$this->mastermodel->redirect(TRUE, 'video', 'video', 'Deleted');

  	}
/*-----------------------------------------------------End Activity Program--------------------------------------------------*/
}
?>
