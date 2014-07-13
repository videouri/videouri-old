<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Membership_Controller {

    public function __construct()
    {
        parent::__construct();
        // pre-load
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('recaptcha');
        $this->lang->load('recaptcha');
    }

    function index() {	
        $this->template->set_theme(Settings_model::$db_config['active_theme']);
        $this->template->set_layout('main');
        $this->template->title('login');
        $this->process_partial('header', 'membership/header');
        $this->process_partial('footer', 'membership/footer');
        $this->process_template_build('membership/login');
    }

    /**
     *
     * validate: validate login after input fields have met requirements
     *
     *
     */
    public function validate() {
        if ((Settings_model::$db_config['disable_all'] == 1 || Settings_model::$db_config['login_enabled'] == 0) && $this->input->post('username') != ADMINISTRATOR) {
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('site_disabled') .'</p>');
            redirect('/membership/login');
            exit();
        }

        // form input validation
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('username', 'username', 'trim|required|max_length[16]');
        $this->form_validation->set_rules('password', 'password', 'trim|required|max_length[64]');
        if ($this->session->userdata('login_attempts') > 5) {
            if (Settings_model::$db_config['recaptcha_enabled'] == true) {
                $this->form_validation->set_rules('recaptcha_response_field', 'captcha response field', 'required|check_captcha');
            }
        }

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/membership/login');
            exit();
        }

        // database validation
        $this->load->model('membership/login_model');
        $data = $this->login_model->validate_login($this->input->post('username'), $this->input->post('password'));

        if ($data == "banned") { // check banned
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('access_denied') .'</p>');
            redirect('/membership/login');
        }elseif (is_array($data)) {
            if ($data['active'] == 0) { // check active
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('activate_account') .'</p>');
                redirect('/membership/login');
            }else{
                $this->load->helper('cookie');
                if ($this->input->post('remember_me') && !get_cookie('unique_token') && Settings_model::$db_config['remember_me_enabled'] == true) {
                    setcookie("unique_token", $data['nonce'] . substr(uniqid(mt_rand(), true), -10) . $data['cookie_part'], time() + Settings_model::$db_config['cookie_expires'], '/', $_SERVER['SERVER_NAME'], false, false);
                }

                // set session data
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('username', $data['username']);
                $this->session->set_userdata('role_id', $data['role_id']); // used to grant access to the adminpanel section
                // reset login attempts to 0
                $this->login_model->reset_login_attempts($data['username']);
                $this->session->unset_userdata('login_attempts');
                redirect('private/'. Settings_model::$db_config['home_page']);
            }
        }else{
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('login_incorrect') .'</p>');
            $this->session->set_userdata('login_attempts', $data);
            redirect('/membership/login');
        }
    }


}

/* End of file login.php */
/* Location: ./application/controllers/membership/login.php */