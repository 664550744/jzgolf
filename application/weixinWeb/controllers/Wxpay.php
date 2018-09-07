<?php
/**
 * Created by PhpStorm.
 * User: wangwenhua
 * Date: 2018/9/4
 * Time: 下午4:16
 */

class Wxpay extends CI_Controller
{

    public function  notify(){
        //$id = intval($this->uri->segment(3));
        //$pragrem = array('post'=>$_POST,'get'=>$_GET);
        /*
        $postData = '';
        if (file_get_contents("php://input")) {
            $postData = file_get_contents("php://input");
        }

        $myfile = fopen(WEBPATH . '/uploads/'.$id.".txt", "w") or die("Unable to open file!");

        fwrite($myfile, json_encode($postData));
        fclose($myfile);
        */


        $xml = '';
        if (file_get_contents("php://input")) {
            $xml = file_get_contents("php://input");
        }





        $this->load->config('wxpay_config');
        $wxconfig['appid']=$this->config->item('appid');
        $wxconfig['mch_id']=$this->config->item('mch_id');
        $wxconfig['apikey']=$this->config->item('apikey');
        $wxconfig['appsecret']=$this->config->item('appsecret');
        $wxconfig['sslcertPath']=$this->config->item('sslcertPath');
        $wxconfig['sslkeyPath']=$this->config->item('sslkeyPath');
        $this->load->library('Wechatpay',$wxconfig);
        libxml_disable_entity_loader(true);
        $array= json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);


        //log::debug($xml);
        //log::debug(json_encode($array));


        if($array!=null)
        {
            $out_trade_no = $array['out_trade_no'];
            $trade_no = $array['transaction_id'];
            $pay_log_path = WEBPATH . '/../pay_log/'.date("Y-m-d").'/';
            is_dir($pay_log_path) OR mkdir($pay_log_path, 0777, true);
            $myfile = fopen($pay_log_path.$out_trade_no.'.json', "w") or die("Unable to open file!");

            fwrite($myfile, json_encode($array));
            fclose($myfile);

            $this->load->model('Payorder_model');
            $payinfo=$this->Payorder_model->getData(array('out_trade_no'=>$out_trade_no));



            if (empty($payinfo)) {
                $this->load->model('Order_table_model');
                $this->Order_table_model->pay($out_trade_no);

                $data['transaction_id'] = $trade_no;
                $data['out_trade_no'] = $out_trade_no;
                $data['trade_type'] = $array['trade_type'];
                $data['total_fee'] = $array['total_fee'];
                $data['time_end'] = $array['time_end'];
                $data['fee_type'] = $array['fee_type'];
                $data['openid'] = $array['openid'];

                $rs=$this->Payorder_model->insert($data);
                if($rs>0)
                {//告知微信我成功了
                    $this->wechatpay->response_back();
                }else{//告知微信我失败了继续发
                    $this->wechatpay->response_back("FAIL");
                }
            }else{
                $this->wechatpay->response_back();
            }

        }





    }
}