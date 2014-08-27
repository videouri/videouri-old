<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_Members_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     *
     * get_members: get the members data
     *
     * @param int $limit db limit (members per page)
     * @param int $offset db offset (current page)
     * @param int $order_by db sort order
     * @param string $sort_order asc or desc
     * @param array $search_data search input
     * @return mixed
     *
     */

    public function get_members($limit = 0, $offset = 0, $order_by = "username", $sort_order = "asc", $search_data) {
        $fields = $this->db->list_fields('user');
        if (!in_array($order_by, $fields)) return array();
        if (!empty($search_data)) {
            !empty($search_data['username']) ? $data['username'] = $search_data['username'] : "";
            !empty($search_data['first_name']) ? $data['first_name'] = $search_data['first_name'] : "";
            !empty($search_data['last_name']) ? $data['last_name'] = $search_data['last_name'] : "";
            !empty($search_data['email']) ? $data['email'] = $search_data['email'] : "";
        }
        $this->db->select('user.id, user.username, user.email, user.first_name, user.last_name, user.date_registered, user.last_login, user.active, user.banned, user.login_attempts, role.name as role_name');
        $this->db->from('user');
        $this->db->join('role', 'role.id = user.role_id');
        !empty($data) ? $this->db->or_like($data) : "";
        $this->db->order_by($order_by, $sort_order);
        $this->db->limit($limit, $offset);

        $query = $this->db->get();
        
        if($query->num_rows() > 0) {
            return $query;
        }

        return false;
    }

    /**
     *
     * count_all_members: count all members in the table
     *
     *
     */
    
    public function count_all_members()
    {
        return $this->db->count_all_results('user');
    }

    /**
     *
     * update_member: update member data
     *
     * @param int $id the member id
     * @param string $username the member username
     * @param string $email the member e-mail address
     * @param string $first_name the member first name
     * @param string $last_name the member last name
     * @param bool $change_username do we want to change the username?
     * @param bool $change_email do we want to change the user e-mail?
     * @return mixed
     *
     */

    public function update_member($id, $username, $email, $first_name, $last_name, $change_username = false, $change_email = false) {
        // if there are more fields you can turn the data into an array. The reason I don't do this is because it's an extra array in controller List_members.

        $data = array(
                'id'            => $id,
                'first_name'    => $first_name,
                'last_name'     => $last_name);

        if ($change_username) {
            $data['username'] = $username;
        }
        if ($change_email) {
            $data['email'] = $email;
        }
        $this->db->where('id', $id);
        $this->db->update('user', $data);

        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    /**
     *
     * delete_member: count all members in the table
     *
     * @param int $id the member id
     * @return boolean
     *
     */

    public function delete_member($id) {
        $this->db->where('id', $id);
        $this->db->delete('user');
        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    /**
     *
     * get_username_by_id: return username by id
     *
     * @param int $id the member id
     * @return mixed
     *
     */

    public function get_username_by_id($id) {
        $this->db->select('username')->from('user')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() == 1) {
            $row = $query->row();
            return $row->username;
        }
        return "";
    }

    /**
     *
     * demote_member: demote member
     *
     * @param int $id the member id
     * @return boolean
     *
     */

    public function demote_member($id) {
        $data = array('role_id' => "2");
        $this->db->where('id', $id);
        $this->db->update('user', $data);
        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    /**
     *
     * promote_member: promote member
     *
     * @param int $id the member id
     * @return boolean
     *
     */

    public function promote_member($id) {
        $data = array('role_id' => "1");
        $this->db->where('id', $id);
        $this->db->update('user', $data);
        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    /**
     *
     * count_all_search_members: count all members when performing search
     *
     * @param string $username the member username
     * @param string $first_name the member first name
     * @param string $last_name the member last name
     * @param string $email the member e-mail address 
     * @return mixed
     *
     */

    public function count_all_search_members($search_data) {
        $data = array();
        !empty($search_data['username']) ? $data['username'] = $search_data['username'] : "";
        !empty($search_data['first_name']) ? $data['first_name'] = $search_data['first_name'] : "";
        !empty($search_data['last_name']) ? $data['last_name'] = $search_data['last_name'] : "";
        !empty($search_data['email']) ? $data['email'] = $search_data['email'] : "";

        $this->db->select('user.id, user.username, user.email, user.first_name, user.last_name, user.date_registered, user.last_login, role.name');
        $this->db->from('user');
        $this->db->join('role', 'role.id = user.role_id');
        !empty($data) ? $this->db->or_like($data) : "";
        $this->db->order_by("user.id", "asc");
        return $this->db->count_all_results();
    }

    /**
     *
     * toggle_ban: (un)ban member
     *
     * @param int $id the member id
     * @param bool $banned ban or unban?
     * @return boolean
     *
     */

    public function toggle_ban($id, $banned) {
        $data = array('banned' => ($banned ? false : true));
        $this->db->where('id', $id);
        $this->db->update('user', $data);
        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    /**
     *
     * toggle_active: (de)activate member
     *
     * @param int $id the member id
     * @param string $active activate or deactivate?
     * @return boolean
     *
     */

    public function toggle_active($id, $active) {
        $data = array('active' => ($active ? false : true));
        $this->db->where('id', $id);
        $this->db->update('user', $data);
        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    public function delete_checked($ids) {
        $this->db->where_in('id', $ids)->where('username != ', ADMINISTRATOR)->delete('user');
        return $this->db->affected_rows();
    }

    public function ban_checked($ids) {
        $this->db->where_in('id', $ids)->where('username != ', ADMINISTRATOR)->update('user', array('banned' => true));
        return $this->db->affected_rows();
    }

    public function unban_checked($ids) {
        $this->db->where_in('id', $ids)->where('username != ', ADMINISTRATOR)->update('user', array('banned' => false));
        return $this->db->affected_rows();
    }

    public function activate_checked($ids) {
        $this->db->where_in('id', $ids)->where('username != ', ADMINISTRATOR)->update('user', array('active' => true));
        return $this->db->affected_rows();
    }

    public function deactivate_checked($ids) {
        $this->db->where_in('id', $ids)->where('username != ', ADMINISTRATOR)->update('user', array('active' => false));
        return $this->db->affected_rows();
    }

}

/* End of file list_members_model.php */
/* Location: ./application/models/adminpanel/list_members_model.php */