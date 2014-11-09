<?php defined('BASEPATH') OR exit('No direct script access allowed');

class NewUser extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'send_email'));
        $this->load->library('form_validation');
        $this->load->library('recaptcha');
        $this->lang->load('recaptcha');
    }

    /**
     *
     * check: verify and activate account
     *
     * @param int $email the e-mail address that received the activation link
     * @param string $nonce the member nonce associated with the e-mail address
     *
     */
    public function activateMembership($email = NULL, $nonce = NULL)
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
        if (Settings_model::$db_config['recaptcha_enabled'] == true) {
            $this->form_validation->set_rules('recaptcha_response_field', 'captcha response field', 'required|check_captcha');
        }

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