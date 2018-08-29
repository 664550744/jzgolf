<?php 

class Users_business_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
	public function get_data($username)
    {
        $query = $this->db->get_where('users_business',  array('username' => $username));
        return $query->result();
    }
	
}
?>
