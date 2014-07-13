<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends Private_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');

        if ($this->session->userdata('is_oauth') == true) {
            redirect('private/oauth_profile');
        }
    }

    public function index() {
        // set content data
        $this->load->model('private/profile_model');
        $content_data = $this->profile_model->get_profile();

        $this->template->set_theme(Settings_model::$db_config['active_theme']);
        $this->template->set_layout('main');
        $this->template->title($this->lang->line('my_profile'));
        $this->process_partial('header', 'private/header');
        $this->process_partial('footer', 'private/footer');
        $this->process_template_build('private/profile', $content_data);
    }

    /**
     *
     * update_account: change member info
     *
     *
     */

    public function update_account() {
        // form input validation
        if ($this->input->post('id') != strval(intval($this->input->post('id')))) { // because we use the new is_existing_unique_field_by_id we have to check whether the id is an integer
            redirect('private/oauth_profile');
        }
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('first_name', 'first name', 'trim|required|max_length[40]|min_length[2]');
        $this->form_validation->set_rules('last_name', 'last name', 'trim|required|max_length[60]|min_length[2]');
        $this->form_validation->set_rules('email', 'email', 'trim|max_length[255]|is_valid_email|is_existing_unique_field_by_id[user.email.'. $this->input->post('id') .']');
        $this->form_validation->set_rules('password', 'password', 'trim|required|is_member_password');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('private/profile');
            exit();
        }

        $this->load->model('private/profile_model');
        $this->profile_model->set_profile($this->input->post('first_name'), $this->input->post('last_name'), $this->input->post('email'));
        $this->session->set_flashdata('success', '<p>'. $this->lang->line('account_updated') .'</p>');
        redirect('private/profile');
        exit();
    }

    /**
     *
     * update_password: change member password
     *
     *
     */

    public function update_password() {
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('current_password', 'current password', 'trim|required|max_length[64]|is_member_password');
        $this->form_validation->set_rules('new_password', 'new password', 'trim|required|max_length[64]|min_length[9]|matches[new_password_again]|is_valid_password');
        $this->form_validation->set_rules('new_password_again', 'new password again', 'trim|required|max_length[64]|min_length[9]');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('pwd_error', validation_errors());
            redirect('private/profile');
            exit();
        }

        $this->load->model('private/profile_model');
        if ($this->profile_model->set_password($this->input->post('new_password'))) {
            if ($this->input->post('send_copy') != "") {
                $this->load->helper('send_email');
                $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));
                $this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
                $this->email->to($this->input->post('email'));
                $this->email->subject($this->lang->line('profile_subject'));
                $this->email->message($this->lang->line('email_greeting') ." ". $this->session->userdata('username') . $this->lang->line('profile_message') . addslashes($this->input->post('new_password')));
                $this->email->send();
            }
            $this->session->set_flashdata('pwd_success', '<p>'. $this->lang->line('profile_success') .'</p>');
        }
        redirect('private/profile');
    }
	
	/**
     *
     * delete_account: delete all user data!
     *
     */
	
	public function delete_account() {
		if ($this->session->userdata('username') == ADMINISTRATOR) {
			$this->session->set_flashdata('error', '<p>Not allowed to delete administrator account.</p>');
			redirect('private/profile'); 
		}
		
		$this->load->model('private/profile_model');
		if ($this->profile_model->delete_membership()) {
			redirect("/membership/logout"); // logout controller destroys session and cookies
		}
		$this->session->set_flashdata('error', '<p>Failed to remove your profile.</p>');
		redirect('private/profile');
	}

}

/* End of file profile.php */
/* Location: ./application/controllers/private/profile.php */