<?php
/**
 * Created by PhpStorm.
 * User: wangwenhua
 * Date: 2018/8/31
 * Time: 上午10:42
 */

class Address_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function getData($u_id)
    {

        $query = $this->db->get_where("address",array("u_id"=>$u_id));

        $result = array();
        foreach ($query->result() as $row)
        {
            $result[] = array('id' => $row->id,'u_id' => $row->u_id,'name' => $row->name,'tel' => $row->tel,'city' => $row->city,'address' => $row->address);

        }
        return $result;
    }
    public function insert($data)
    {
        $r= $this->db->insert('address', $data);
        return $r;
    }
}