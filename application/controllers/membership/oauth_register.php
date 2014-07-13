<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oauth_register extends Membership_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        if ($this->session->userdata('provider') == "") {
			$this->session->set_flashdata('error', '<p>'. $this->lang->line('oauth_session_not_found') .'</p>');
            redirect('membership/login');
        }
    }

    public function index() {
        $this->template->set_theme(Settings_model::$db_config['active_theme']);
        $this->template->set_layout('main');
        $this->template->title('Social logon');
        $this->process_partial('header', 'membership/header');
        $this->process_partial('footer', 'membership/footer');
        $this->process_template_build('membership/oauth_register');
    }

    /**
     *
     * register: add new user after successful OAuth registration.
     *
     */

    public function register() {

        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('username', 'username', 'trim|required|max_length[16]|min_length[6]|is_valid_username|is_existing_unique_field[user.username]');

        if ($this->session->userdata('email') == "") {
            $this->form_validation->set_rules('email', 'e-mail', 'trim|required|max_length[255]|is_valid_email|is_existing_unique_field[user.email]');
        }

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('membership/oauth_register');
            exit();
        }

		// get email based on session or $_POST
        $email = $this->session->userdata('email') != "" ? $this->session->userdata('email') : ($this->input->post('email') != "" ? $this->input->post('email') : "");

		// email cannot be empty: in case something goes wrong above
		if (empty($email)) {
		$this->session->set_flashdata('error', '<p>'. $this->lang->line('oauth_email_required') .'</p>');
			redirect('membership/login');
		}

        $this->load->model('membership/oauth_model'); // update email only and make active
		$nonce = md5(uniqid(mt_rand(), true));
		$array = array(
			'nonce'				=> $nonce,
			'username' 			=> $this->input->post('username'),
			'email' 			=> $email,
			'active'            => ($this->session->userdata('email') == "" ? false : true),
			'oauth_provider_id'	=> ($this->session->userdata('oauth_provider_id') != "" ? $this->session->userdata('oauth_provider_id') : NULL),
			'oauth_uid' 		=> ($this->session->userdata('oauth_uid') != "" ? $this->session->userdata('oauth_uid') : NULL),
			'oauth_name'        => ($this->session->userdata('oauth_name') != "" ? $this->session->userdata('oauth_name') : NULL),
            'oauth_location'    => ($this->session->userdata('oauth_location') != "" ? $this->session->userdata('oauth_location') : NULL),
            'oauth_token'       => ($this->session->userdata('oauth_token') != "" ? $this->session->userdata('oauth_token') : NULL),
            'oauth_secret'      => ($this->session->userdata('oauth_secret') != "" ? $this->session->userdata('oauth_secret') : NULL),
            'oauth_summary'     => ($this->session->userdata('oauth_summary') != "" ? $this->session->userdata('oauth_summary') : NULL),
            'oauth_profile_url' => ($this->session->userdata('oauth_profile_url') != "" ? $this->session->userdata('oauth_profile_url') : NULL)
		);

		// add the new user to the database
        if ($this->oauth_model->insert_social_userdata($array)) {
		
			// active? if yes log in, otherwise send activation link
			if ($array['active']) {
				// set session data
				$this->session->set_userdata('logged_in', true);
				$this->session->set_userdata('username', $this->input->post('username'));
				$this->session->set_userdata('role_id', 2);
				$this->session->set_userdata('is_oauth', $this->session->userdata('provider'));
				$this->session->set_flashdata('success', '<p>'. $this->lang->line('logged_in_with') . $this->session->userdata('provider') .'</p>');
                // send activation email
                $this->load->helper('send_email');
                $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));
                $this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
                $this->email->to($array['email']);
                $this->email->subject($this->lang->line('oauth_success_message'));
                $this->email->message($this->lang->line('oauth_register_email'));
                $this->email->send();
                redirect('membership/login');
			}else{
				// not active, redirect to login page
				// send activation email
				$this->load->helper('send_email');
				$this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));
				$this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
				$this->email->to($array['email']);
				$this->email->subject($this->lang->line('membership_subject'));
				$this->email->message($this->lang->line('email_greeting') . " ". $this->input->post('username') . $this->lang->line('membership_message'). base_url() ."membership/activate_membership/check/". urlencode($array['email']) ."/". $nonce);
				$this->email->send();
				$this->session->set_flashdata('success', '<p>'. $this->lang->line('membership_success') .'</p>');
				$this->session->set_flashdata('success', '<p>'. $this->lang->line('oauth_validation_request') .'</p>');
				redirect('membership/login');
			}

        }else{
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('oauth_database_insert_failed') .'</p>');
			redirect('membership/login');
        }
		
		// unset session data used to keep track of user data
		$userobj = array(
            'email'             => "",
			'active'            => "",
			'provider'			=> "",
            'oauth_uid'         => "",
            'oauth_name'        => "",
            'oauth_location'    => "",
            'oauth_token'       => "",
            'oauth_secret'      => "",
            'oauth_summary'     => "",
            'oauth_profile_url' => "",
			'oauth_provider_id' => ""
        );
		$this->session->unset_userdata($userobj);
		
        redirect('private/'. Settings_model::$db_config['home_page']);
    }

}