<?php
/**
 * Created by PhpStorm.
 * User: wangwenhua
 * Date: 2018/9/7
 * Time: 上午11:24
 */

class Payorder_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
    public function insert($data)
    {
        $r= $this->db->insert('payorder', $data);
        return $r;
    }

    public function getData($where)
    {
        $this->db->select("id");
        $query = $this->db->get_where('payorder', $where);
        $result = array();
        foreach ($query->result() as $row)
        {
            $result[]=$row->id;
        }
        return $result;
    }

}