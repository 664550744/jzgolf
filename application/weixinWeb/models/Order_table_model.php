<?php
/**
 * Created by PhpStorm.
 * User: wangwenhua
 * Date: 2018/9/5
 * Time: 下午5:11
 */

class Order_table_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
    public function insert($orders,$goods,$u_id,$stock_num_info)
    {
        $this->db->trans_begin();
        for($i=0;$i<count($orders);$i++){
            $this->db->insert('order_table', $orders[$i]);
        }
        for($i=0;$i<count($goods);$i++){
            $this->db->insert('order_goods', $goods[$i]);
            //更新库存
            $stock_num_info_item = json_decode($stock_num_info[$i],1);
           // print_r($stock_num_info_item );
            $goods_selects = json_decode($goods[$i]["goods_selects"],1);
            $stock_num =intval($goods[$i]["num"]);
            $stock_num_new =0;
            for ($j=0;$j<count($stock_num_info_item);$j++){

                switch (count($goods_selects))
                {
                    case 1:
                        if($goods_selects[0]==$stock_num_info_item[$j]["k"][0]) {
                            $stock_num_info_item[$j]["v"] = $stock_num_info_item[$j]["v"]-$stock_num;
                        }
                        break;
                    case 2:
                        if($goods_selects[0]==$stock_num_info_item[$j]["k"][0]&&$goods_selects[1]==$stock_num_info_item[$j]["k"][1]) {
                            $stock_num_info_item[$j]["v"] = $stock_num_info_item[$j]["v"]-$stock_num;
                        }
                        break;
                    case 3:
                        if($goods_selects[0]==$stock_num_info_item[$j]["k"][0]&&$goods_selects[1]==$stock_num_info_item[$j]["k"][1]&&$goods_selects[2]==$stock_num_info_item[$j]["k"][2]) {
                            $stock_num_info_item[$j]["v"] = $stock_num_info_item[$j]["v"]-$stock_num;
                        }
                        break;

                }
                $stock_num_new +=intval($stock_num_info_item[$j]['v']);

            }


            $this->db->set('stock_num_info', json_encode($stock_num_info_item));
            $this->db->set('stock_num', $stock_num_new);
            $this->db->where('id', $goods[$i]["g_id"]);
            $this->db->update('goods');
        }

        $this->db->where('u_id', $u_id);
        $this->db->delete('cart');


        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return 0;
        }
        else
        {
            $this->db->trans_commit();
            return 1;
        }
    }
    public function pay($out_trade_no)
    {
        $this->db->set('state', 1);
        $this->db->where('p_num', $out_trade_no);
        $this->db->or_where('num ', $out_trade_no);
        $this->db->update('order_table');

    }

}