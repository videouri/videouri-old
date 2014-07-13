<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oauth_profile extends Private_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');

        if ($this->session->userdata('is_oauth') == false) { // you can only get here when oauth session variable is set
            redirect('private/profile');
        }
    }

    public function index() {
        // set content data
        $this->load->model('private/profile_model');
        $content_data = $this->profile_model->get_oauth_profile();

        $this->template->set_theme(Settings_model::$db_config['active_theme']);
        $this->template->set_layout('main');
        $this->template->title($this->lang->line('my_profile'));
        $this->process_partial('header', 'private/header');
        $this->process_partial('footer', 'private/footer');
        $this->process_template_build('private/oauth_profile', $content_data);
    }

    /**
     *
     * update_profile: update oauth profile changes
     *
     */

    public function update_profile() {
        // form input validation
        if ($this->input->post('id') != strval(intval($this->input->post('id')))) { // because we use the new is_existing_unique_field_by_id we have to check whether the id is an integer
            redirect('private/oauth_profile');
        }
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('first_name', 'first name', 'trim|required|max_length[40]|min_length[2]');
        $this->form_validation->set_rules('last_name', 'last name', 'trim|required|max_length[60]|min_length[2]');
        $this->form_validation->set_rules('email', 'email', 'trim|max_length[255]|is_valid_email|is_existing_unique_field_by_id[user.email.'. $this->input->post('id') .']');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('private/oauth_profile');
            exit();
        }

        $this->load->model('private/profile_model');

        $this->profile_model->set_profile($this->input->post('first_name'), $this->input->post('last_name'), $this->input->post('email'));
        $this->session->set_flashdata('success', '<p>'. $this->lang->line('account_updated') .'</p>');
        redirect('private/oauth_profile');
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