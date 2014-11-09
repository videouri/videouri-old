<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Private_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        // set content data
        $content_data['welcome'] = "Welcome, ". $this->session->userdata('username') ."!";
        $content_data['explanation'] = "This page is the default page where members will arrive when logging in. Off course,
        this can be easily changed via the admin panel - site settings section.";
        $content_data['features_list'] = array(
            "highly secure password algorithm with salt and key in a 128-long encrypted variable",
            "separate password and username retrieval",
            "resend activation link",
            "jQuery as well as PHP field validation",
            "3 ways to configure mail setup: PHP mail(), sendmail and SMTP",
            "database sessions and site settings",
            "cookies that remember login",
            "members can edit their profile",
            "simple roles system",
            "theming",
            "export members list to e-mail in delimited text file",
            "backup database to e-mail in sql file",
            "clear session data option",
            "highly configurable site options",
            "focus is on easy to understand, quick and clean coding"
        );

        $this->template->set_layout('main');
        $this->template->title('home page');
        $this->process_partial('header', 'private/header');
        $this->process_partial('footer', 'private/footer');
        $this->process_template_build('private/homepage', $content_data);
    }

}

/* End of file home.php */
/* Location: ./application/controllers/private/home.php */