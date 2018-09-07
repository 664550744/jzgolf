<?php
/**
 * Created by PhpStorm.
 * User: wangwenhua
 * Date: 2018/9/5
 * Time: 下午6:25
 */

class Order extends CI_Controller
{
    public function index()
    {
        $id = intval($this->uri->segment(3));
        echo '订单编号：'.$id;
    }
}