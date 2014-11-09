<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     *
     * validate_login: check login data against database information
     *
     * @param string $username the username to be validated
     * @param string $password the password to be validated
     * @return mixed
     *
     */
    public function validate_login($username, $password)
    {
        $this->db->select('username, password, date_registered, nonce, role_id, active, banned, login_attempts');
        $this->db->from('user');
        $this->db->where('username', $username);
        $this->db->limit(1);

        $query = $this->db->get();

        if($query->num_rows() == 1) {
           $row = $query->row();

            // check for password match based on password_helper.php
            if ($row->banned == 1) {
               return "banned";
            }

            elseif (hash_password($password, $row->nonce) == $row->password) {
               $array['username'] = $row->username;
               $array['date_registered'] = $row->date_registered;
               $array['role_id'] = $row->role_id;
               $array['active'] = $row->active;
               $array['nonce'] = $row->nonce;
               // update last login on successful login
               $array['cookie_part'] = $this->_update_last_login($username);
               return $array;
            }

            else {
               // login attempts +1 because login failed
               $this->_increase_login_attempts($username);
               return ($row->login_attempts + 1);
           }
        }

        return false;
    }

    /**
     *
     * _update_last_login: update the last time the member logged in
     *
     * @param string $username the username to be validated
     * @return boolean
     *
     */
    private function _update_last_login($username)
    {
        $cookie_part = md5(uniqid(mt_rand(), true));
        $this->db->set('last_login', 'NOW()', FALSE);
        $this->db->where('username', $username);
        $this->db->update('user', array('cookie_part' => $cookie_part));

        if ($this->db->affected_rows() == 1) {
            return $cookie_part;
        }

        return false;
    }

    /**
     *
     * _increase_login_attempts: add +1 to login attempts for member
     *
     * @param string $username the username to be validated
     * @return boolean
     *
     */
    private function _increase_login_attempts($username)
    {
        $this->db->set('login_attempts', 'login_attempts + 1', FALSE);
        $this->db->where('username', $username);
        $this->db->update('user');

        if ($this->db->affected_rows() == 1) {
            return true;
        }

        return false;
    }

    /**
     *
     * reset_login_attempts: bring login attempts back to 0
     *
     * @param string $username the username to be validated
     * @return boolean
     *
     */
    public function reset_login_attempts($username)
    {
        $this->db->where('username', $username);
        $this->db->update('user', array('login_attempts' => 0));
    }

}

/* End of file login_model.php */
/* Location: ./application/models/membership/login_model.php */