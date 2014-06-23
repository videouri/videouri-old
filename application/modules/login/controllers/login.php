<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller
{

	public function session($provider)
    {

        if( ! $provider)
        {
            redirect(base_url());
        }

        $provider = $this->oauth2->provider($provider, array(
            'id' => '277719198954055',
            'secret' => '3db8914da19351f8ea8686e813df0947',
        ));

        if ( ! $this->input->get('code'))
        {
            // By sending no options it'll come back here
            $provider->authorize();
        }
        else
        {
            // Howzit?
            try
            {
                $token = $provider->access($_GET['code']);

                $user = $provider->get_user_info($token);

                // Here you should use this information to A) look for a user B) help a new user sign up with existing data.
                // If you store it all in a cookie and redirect to a registration page this is crazy-simple.
                echo "<pre>Tokens: ";
                var_dump($token);

                echo "\n\nUser Info: ";
                var_dump($user);
            }

            catch (OAuth2_Exception $e)
            {
                show_error('That didnt work: '.$e);
            }

        }

    }
}

/* End of file login.php */
/* Location: ./application/modules/login/controllers/login.php */