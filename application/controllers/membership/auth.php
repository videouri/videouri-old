<?php
class Auth extends Membership_Controller {

    public function __construct() {
        parent::__construct();
        if (Settings_model::$db_config['disable_all'] == 1 || Settings_model::$db_config['login_enabled'] == 0) {
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('site_disabled') .'</p>');
            redirect('/membership/login');
            exit();
        }
    }

    /**
     *
     * _load_config: private function used to load provider specific config from DB
     *
     *
     */

    private function _load_config($provider) {
        $this->db->select('key, secret')->from('oauth_providers')->where(array('name' => $provider, 'enabled' => true));
        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            return $q->row();
        }

        return false;
    }

    /**
     *
     * oauth: oauth 1 functionality - when GET is empty behavior is different
     *
     *
     */

    public function oauth($provider_name) {

        /* https://github.com/philsturgeon/codeigniter-oauth */

        // load lib
        $this->load->library('oauth/OAuth');

        // get config
        $config = $this->_load_config($provider_name);

        // check for disabled
        if (!$config) {
            $this->session->set_flashdata('error', '<p>'. ucfirst($provider_name) . $this->lang->line('oauth_disabled') .'</p>');
            redirect('membership/login');
        }

        // Create a consumer from the config
        $consumer = $this->oauth->consumer(array(
            'key' => $config->key,
            'secret' => $config->secret,
        ));

        // Load the provider
        $provider = $this->oauth->provider($provider_name);

        // Create the URL to return the user to
        $callback = site_url('membership/auth/oauth/'. $provider->name);

        if ( ! $this->input->get_post('oauth_token'))
        {
            // Add the callback URL to the consumer
            $consumer->callback($callback);

            // Get a request token for the consumer
            $token = $provider->request_token($consumer);

            // Store the token
            $this->session->set_userdata('oauth_token', base64_encode(serialize($token)));

            // Get the URL to the login page
            $url = $provider->authorize($token, array(
                'oauth_callback' => $callback,
            ));

            // Send the user off to login
            try{
                redirect($url);
            }catch (Exception $e) {
                $this->session->set_flashdata('error', '<p>'. $e->getMessage()) .'</p>';
                redirect('membership/login');
            }
        }
        else
        {
            if ($this->session->userdata('oauth_token'))
            {
                // Get the token from storage
                $token = unserialize(base64_decode($this->session->userdata('oauth_token')));
            }else{
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('oauth_invalid_token') .'</p>');
                redirect('membership/login');
            }

            if ( ! empty($token) AND $token->access_token !== $this->input->get_post('oauth_token'))
            {
                // Delete the token, it is not valid
                $this->session->unset_userdata('oauth_token');

                // Send the user back to the beginning
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('oauth_invalid_token') .'</p>');
                redirect('membership/login');
            }

            // Get the verifier
            $verifier = $this->input->get_post('oauth_verifier');

            // Store the verifier in the token
            $token->verifier($verifier);

            // Exchange the request token for an access token
            $token = $provider->access_token($consumer, $token);

            // We got the token, let's get some user data
            $user = $provider->get_user_info($consumer, $token);


            // Here you should use this information to A) look for a user B) help a new user sign up with existing data.

            $this->load->model('membership/oauth_model');

            // do save and act accordingly
            $result = $this->oauth_model->validate_provider($provider_name, $token, $user, "oauth");

            if ($result == "banned") {
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('you_are_banned') .'</p>');
                redirect('membership/login');

            }elseif ($result == "not_active") {
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('not_active') .'</p>');
                redirect('membership/login');

            }elseif ($result == "update") {
                $this->session->set_flashdata('success', '<p>'. $this->lang->line('login_welcome') .'</p>');
                redirect('private/'. Settings_model::$db_config['home_page']);

            }elseif ($result == "redirect") {
			
				// if email is empty redirect to extra reg page, else redirect to private home

                $this->session->set_flashdata('success', '<p>'. $this->lang->line('oauth_return_message') .'</p>');
                redirect('membership/oauth_register');
            }elseif ( ! $result) {
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('oauth_unable_to_save') .'</p>');
                redirect('membership/login');
            }
        }
    }

    /**
     *
     * oauth: oauth 2 functionality - when GET is empty behavior is different
     *
     *
     */

    public function oauth2($provider_name)
    {
        /* https://github.com/philsturgeon/codeigniter-oauth2 */

        // get config
        $config = $this->_load_config($provider_name);

        // check for disabled
        if (!$config) {
            $this->session->set_flashdata('error', "<p>". ucfirst($provider_name) ." ". $this->lang->line('oauth_disabled') ."</p>");
            redirect('membership/login');
        }

        $this->load->library('oauth2/OAuth2');

        $provider = $this->oauth2->provider($provider_name, array(
            'id' => $config->key,
            'secret' => $config->secret,
        ));

        if ( ! $this->input->get('code'))
        {
            // By sending no options it'll come back here
            $provider->authorize();
        }
        else
        {
            // There's a return code detected in GET
            try
            {
                // validate code and get user info
                $token = $provider->access($_GET['code']);
                $user = $provider->get_user_info($token);

                $this->load->model('membership/oauth_model');

                // do save and act accordingly
                $result = $this->oauth_model->validate_provider($provider_name, $token, $user, "oauth2");

                if ($result == "banned") {
                    $this->session->set_flashdata('error', '<p>'. $this->lang->line('you_are_banned') .'</p>');
                    redirect('membership/login');

				}elseif ($result == "not_active") {
					$this->session->set_flashdata('error', '<p>'. $this->lang->line('not_active') .'</p>');
					redirect('membership/login');

                }elseif ($result == "update") {
                    $this->session->set_flashdata('success', '<p>'. $this->lang->line('login_welcome') .'</p>');
                    redirect('private/'. Settings_model::$db_config['home_page']);

                }elseif ($result == "redirect") {
                    $this->session->set_flashdata('success', '<p>'. $this->lang->line('oauth_return_message') .'</p>');
                    redirect('membership/oauth_register');
                }elseif ( ! $result) {
                    $this->session->set_flashdata('error', '<p>'. $this->lang->line('oauth_unable_to_save') .'</p>');
                    redirect('membership/login');
                }
            }

            catch (OAuth2_Exception $e)
            {
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('oauth_unable_to_log_on') .'</p>');
                redirect('membership/login');
            }
        }
    }

}