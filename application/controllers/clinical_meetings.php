<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Smita S. Kad.
	Date 		: 	11-08-2015
	Demo Name 	: 	Clinical Meetings.
*/
class Clinical_meetings extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Clinical Meetings --------------------------------------------------*/
	// Clinical Meetings List
	function index()
	{
		$data['deleteaction'] =base_url().'clinical_meetings/delete';

		// WHERE condition -
		$where = array('clinical_meetings.is_deleted' => 0);

		// get data from table -
		$data['rsclinical_meetings'] = $this->mastermodel->get_data('*', 'clinical_meetings', $where, NULL, NULL, 0, NULL);

		$this->load->view('clinical_meetings/list',$data);
	}

	// Clinical Meetings Add
	function add()
	{
		$data['saveaction'] = base_url()."clinical_meetings/save";

		$this->load->view('clinical_meetings/add',$data);
	}

	// Clinical Meetings Edit
	function edit($pk)
	{
		$data['editaction'] = base_url()."clinical_meetings/update";

		// WHERE condition -
		$where = array('pk' => $pk);

		// get data from table -
		$data['rsclinical_meetings'] = $this->mastermodel->get_data('*', 'clinical_meetings', $where, NULL, NULL, 0, NULL);

		$this->load->view('clinical_meetings/edit',$data);
	}

	// Clinical Meetings View
	function view($pk)
	{
		// WHERE condition -
		$where = array('pk' => $pk);

		// get data from table -
		$data['rsclinical_meetings'] = $this->mastermodel->get_data('*', 'clinical_meetings', $where, NULL, NULL, 0, NULL);

		$this->load->view('clinical_meetings/view',$data);
	}

	// Clinical Meetings Store Data to the DB
	function save()
    {
		// get form data -
		$data = $_POST;

		// var_dump($_POST);
		// var_dump($_FILES);

		$data['clinical_meetings_file'] = '';

		if(!empty($_FILES['clinical_meetings_file']['name']))
		{
			// config array for file -
			$config['upload_path']		= './clinical_meetings_file/';	// folder name to store files -
			$config['allowed_types'] 	= '*';							// file type to be supported
			$config['max_size']			= '50000';						// maximum file size to upload

			// function to upload multiple files -
			$result = $this->mastermodel->upload_file('clinical_meetings_file', $_FILES, $config);
			$clinical_meetings_file = $result[0][0];

			$data['clinical_meetings_file'] = $clinical_meetings_file;
		}
		//$data['expiry_date'] = $this->mastermodel->date_convert($data['expiry_date'],'ymd');
		$data['meeting_date'] = $this->mastermodel->date_convert($data['meeting_date'],'ymd');

		// convert date format in form data -
		//$data['expiry_date'] = $this->mastermodel->date_convert($data['expiry_date'],'ymd');

		$result = $this->mastermodel->add_data('clinical_meetings', $data);

		// function used to redirect -
		$this->mastermodel->redirect(TRUE, 'clinical_meetings', 'clinical_meetings/add', 'Added');
	}

	// Clinical Meetings Update Data to the DB
	function update()
    {
		// get form data -
		$data = $_POST;

		//print_r($_FILES);

		if(!empty($_FILES['clinical_meetings_file']['name']))
		{
			// config array for file -
			$config['upload_path']		= './clinical_meetings_file/';	// folder name to store files -
			$config['allowed_types'] 	= '*';					// file type to be supported
			$config['max_size']			= '50000';				// maximum file size to upload

			// function to upload multiple files -
			$result = $this->mastermodel->upload_file('clinical_meetings_file', $_FILES, $config);

			$clinical_meetings_file = $result[0][0];

			$data['clinical_meetings_file'] = $clinical_meetings_file;
		}

		// convert date format in form data -
		//$data = $this->mastermodel->date_format($data);

		// WHERE condition -
		$where = array('pk' => $data['edit_pk']);	// give name for edit record id field on form as 'edit_pk'

		// remove edit id from array -
		unset($data['edit_pk']);

		$result = $this->mastermodel->update_data('clinical_meetings', $where, $data);

		// function used to redirect -
		$this->mastermodel->redirect($result, 'clinical_meetings', 'clinical_meetings/edit/'.$_POST['edit_pk'], 'Updated');
    }

	// Clinical Meetings Delete Data to the DB
	function delete($pk)
	{
		// WHERE condition -
		//$where = array('pk' => $pk);

		$result = $this->mastermodel->delete_data('clinical_meetings', 'pk = '.$pk);

		// function used to redirect -
		$this->mastermodel->redirect($result, 'clinical_meetings', 'clinical_meetings', 'Deleted');

	}
/*-----------------------------------------------------End Exercise Program--------------------------------------------------*/
}
?>
