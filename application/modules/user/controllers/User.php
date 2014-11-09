<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Membership_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'send_email'));
        $this->load->library('form_validation');
        $this->load->library('recaptcha');
        $this->lang->load('recaptcha');
    }

    /***********************/
    /*    Existing User   */
    /*********************/

    /**
     * Login view
     * @return View
     */
    public function getLogin()
    {
        $isAjax = true;
        if (! $isAjax) {
            $this->template->content->view('user/login');
            $this->template->publish();
        } else {
            return $this->load->view('user/login');
        }
    }

    /**
     * validate: validate login after input fields have met requirements
     */
    public function postLogin()
    {
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
            $this->form_validation->set_rules('recaptcha_response_field', 'captcha response field', 'required|check_captcha');
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

    /**
     *
     * reset: reset the password and send it to the member
     *
     * @param int $email the e-mail address that received the activation link
     * @param string $token the unique token that verifies this transaction
     *
     */
    public function getReset()
    {
        $this->template->body_id = 'membership';
        $this->template->content->view('reset_password', array());
        $this->template->publish();
    }

    public function postReset($email, $token)
    {
        $new_password = generateRandomString();
        $new_password = str_shuffle($new_password);

        $this->load->model('membership/reset_password_model');
        $data = $this->reset_password_model->verify_token(urldecode($email), $token);

        if (!empty($data['date_added'])) {
            $time_diff = strtotime("now") - strtotime($data['date_added']);
        }
        
        if (isset($time_diff) && $time_diff > Settings_model::$db_config['password_link_expires']) { // 12 hours password expired
            // link has expired
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('reset_password_link_expired') .'</p>');
            // remove token
            $this->reset_password_model->delete_token_data($token);
            redirect("/membership/reset_password");
            exit();
        } elseif (isset($data['token']) && $data['token'] == $token) {
            
            $this->reset_password_model->delete_token_data($token);

            if ($this->reset_password_model->update_password_and_nonce(urldecode($email), $new_password)) {

                $this->load->helper('send_email');
                $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));

                $this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
                $this->email->to(urldecode($email));
                $this->email->subject($this->lang->line('reset_password_subject'));
                $this->email->message($this->lang->line('email_greeting') ." ". $data['username'] . $this->lang->line('reset_password_message'). addslashes($new_password));

                $this->email->send();
                $this->session->set_flashdata('success', '<p>'. $this->lang->line('reset_password_success') .'</p>');
            }else{
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('reset_password_failed_db') .'</p>');
            }
        }else{
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('reset_password_failed_token') .'</p>');
        }
        redirect("/membership/reset_password");
    }



    /*****************/
    /*  New User     */
    /*****************/

    /**
     *
     * check: verify and activate account
     *
     * @param int $email the e-mail address that received the activation link
     * @param string $nonce the member nonce associated with the e-mail address
     *
     */
    public function getActivate($email = NULL, $nonce = NULL)
    {
        if (empty($email) || empty($nonce)) {
            redirect('/login');
        }
        
        $this->load->model('/activate_membership_model');
        
        if($this->activate_membership_model->activate_member(urldecode($email), $nonce)) {
            $content_data['success'] = $this->lang->line('reset_password_account_active');
        }else{
            $content_data['error'] = $this->lang->line('reset_password_link_expired');
        }

        $this->template->title($this->lang->line('resend_activation'));
        $this->process_partial('header', 'membership/header');
        $this->process_partial('footer', 'membership/footer');
        $this->process_template_build('membership/activate_membership', $content_data);


        $this->template->content->view('membership/login', $content);
        $this->template->publish();
    }

    /**
     *
     * send_link: resend activation link
     *
     *
     */
    public function resendActivationMail()
    {
        // form input validation
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('email', 'e-mail', 'trim|required|is_valid_email');
        $this->form_validation->set_rules('recaptcha_response_field', 'captcha response field', 'required|check_captcha');

        if (!$this->form_validation->run())
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/resend_activation');
            exit();
        }

        $this->load->model('database_tools_model');
        $data = $this->database_tools_model->get_data_by_email($this->input->post('email'));

        if ($data['active'])
        {
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('account_active') .'</p>');
            redirect('/resend_activation');
        }

        elseif (!empty($data['nonce']))
        {
            $this->load->model('membership/resend_activation_model');
            $this->resend_activation_model->update_last_login($data['username']);
            $this->load->helper('send_email');
            $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));
            $this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
            $this->email->to($this->input->post('email'));
            $this->email->subject($this->lang->line('resend_activation_subject'));
            $this->email->message($this->lang->line('email_greeting') ." ". $data['username'] . $this->lang->line('resend_activation_message') . base_url() ."membership/activate_membership/check/". urlencode($this->input->post('email')) ."/". $data['nonce']);
            if ($this->email->send()) {
                $this->session->set_flashdata('success', '<p>'. $this->lang->line('resend_activation_success') .'</p>');
            }
            redirect('/resend_activation');
        }

        else {
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('email_not_found') .'</p>');
        }

        $this->session->set_flashdata('email', $this->input->post('email'));
        redirect('/resend_activation');
    }
}

/* End of file User.php */
/* Location: ./application/modules/membership/controllers/ExistingUser.php */