<?php
/*
	Created By	: 	Smita S. Kad.
	Date 		: 	11-07-2015
	Demo Name 	: 	Login Model.

	Updated By	:	Smita Kad.
	Update Date :	10-08-2015
*/
class Loginmodel extends CI_Model
{
/*-----------------------------------------------------------------------STAFF LOGIN START------------------------------------------------------------------------------*/
	public function validatelogin()
	{
		$username = $this->input->post('username');
        $password = $this->input->post('password');

		// encrypt password using md5 -	Ref - http://elmar-eigner.de/md5_encryption.html
		//$encrypt_password = md5($password);

		// encrypt password using helper function -
		$encrypt_password = encrypt($password);

        // Prep the query
        $this->db->where('s_username',$username);
        $this->db->where('s_password',$password);
		//$this->db->where('user_type','S');
		//$this->db->where('status','0');

        // Run the query
        $query = $this->db->get('staff_details');

        // Let's check if there are any results
        if($query->num_rows() == 1)
        {
            // If there is a user, then create session data
            $row = $query->row();

            $data = array(
							'userid'		=> $row->pk,
							'username' 		=> $row->s_username,
							'first_name'	=> $row->s_fname,
							'last_name'		=> $row->s_lname,
							'user_photo'	=> $row->staff_photo,
							'user_type' 	=> $row->user_type,

							'logged_in' 	=> TRUE
                    );

            $this->session->set_userdata($data);

            return TRUE;
        }

        // If the previous process did not validate, then return false.
        return FALSE;
    }
	// change password of staff
	function change_password()
	{
		$this->db->trans_start();

		//$data['password'] = md5($this->input->post('new_password'));

		$data['s_password'] = encrypt($this->input->post('new_password'));

		$this->db->where('pk',$this->session->userdata('userid'));
		$this->db->update('staff_details', $data);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}
/*-----------------------------------------------------------------------STAFF LOGIN END------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------PATIENT LOGIN START------------------------------------------------------------------------------*/
	public function p_validatelogin()
	{ //print_r($_POST); die;
		$username = $this->input->post('username');
        $password = $this->input->post('password');
		//echo $password; die;
		// encrypt password using md5 -	Ref - http://elmar-eigner.de/md5_encryption.html
		//$encrypt_password = md5($password);

		// encrypt password using helper function -
		$encrypt_password = $password;

        // Prep the query
        //$this->db->where('p_username',$username);

		$this->db->where('p_contact_no',$username);
        $this->db->where('p_password',$encrypt_password);
		//$this->db->where('user_type','S');
		$this->db->where('p_status','A');

        // Run the query
        $query = $this->db->get('contact_list');

        // Let's check if there are any results
        if($query->num_rows() == 1)
        {
            // If there is a user, then create session data
            $row = $query->row();

            $data = array(
							'userid'		=> $row->pk,
							'username' 		=> $row->p_username,
							'first_name'	=> $row->p_fname,
							'last_name'		=> $row->p_lname,
							//'user_photo'	=> $row->staff_photo,
							//'user_type' 	=> $row->user_type,

							'logged_in' 	=> TRUE
                    );

            $this->session->set_userdata($data);

            return TRUE;
        }

        // If the previous process did not validate, then return false.
        return FALSE;
    }
	// change password of Patient
	function p_change_password()
	{
		$this->db->trans_start();

		//$data['p_password'] = md5($this->input->post('new_password'));
		$data['p_password'] = encrypt($this->input->post('new_password'));

		$this->db->where('pk',$this->session->userdata('userid'));
		$this->db->update('contact_list', $data);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}
/*-----------------------------------------------------------------------PATIENT LOGIN END------------------------------------------------------------------------------*/
}
?>
