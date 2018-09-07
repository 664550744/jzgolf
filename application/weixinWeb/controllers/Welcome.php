<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	    /*

		$userSess = array(
				'user_id'  => "55",
				'token_id'   => "690b8965ec924ea578511567de573038",
                'wxopenid'   => "o3wKqw35msXXKY61U0DdiunS7S3k",
				'alias'     => ".",
				'photo'     => "http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKgymXKcicqZe2Vhwmt4RE5JcLNnxeX685ZGDrkJ5AOYjT7rq7FHwJibKV7hE8luoqWI5QaxyyibxUUQ/132",
				'ID'     => "96905",
				'login' => TRUE
			);

		$this->session->set_userdata($userSess);

*/
		
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->model('Cart_model');
		$num = $this->Cart_model->getNum($this->session->userdata('user_id'));
		$this->load->view('header.html');
		$this->load->view('welcome_message');
		$this->load->view('footer.html',array('menuAct' => 0,'num'=>$num));
	}
	public function category()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->model('Cart_model');
		$num = $this->Cart_model->getNum($this->session->userdata('user_id'));
		$this->load->view('header.html');
		$this->load->view('category');
		$this->load->view('footer.html',array('menuAct' => 1,'num'=>$num));
	}
	public function cart()
	{
		$this->load->library('login');
		$this->login->isLogin(); 
		$this->load->model('Cart_model');
		$r = $this->Cart_model->getData($this->session->userdata('user_id'));
		$num = $this->Cart_model->getNum($this->session->userdata('user_id'));

		$this->load->view('header.html');
		$this->load->view('cart',array('dataList'=>$r));
		$this->load->view('footer.html',array('menuAct' => 2,'num'=>$num));
	}
	public function user()
	{
		$this->load->library('login');
		$this->login->isLogin();  
		$this->load->model('Cart_model');
		$num = $this->Cart_model->getNum($this->session->userdata('user_id'));
		$this->load->view('header.html');
		$this->load->view('user');
		$this->load->view('footer.html',array('menuAct' => 3,'num'=>$num));
	}

	public function categoryGoods()
	{
		$this->load->library('login');
		$this->login->isLogin();  
		$this->load->model('Cart_model');
		$num = $this->Cart_model->getNum($this->session->userdata('user_id'));
		
		$cat = intval($this->uri->segment(3));
		$title = array('一号木','球道木','铁杆','推杆','穿戴','配件','套杆','二手区');
		$this->load->view('header.html');
		$this->load->view('category_goods',array('title' => $title[$cat],'cat'=>$cat ));
		$this->load->view('footer.html',array('num'=>$num));
	}

	public function checkOrder(){

        $this->load->library('login');
        $this->login->isLogin();
        $this->load->model('Address_model');
        $address = $this->Address_model->getData($this->session->userdata('user_id'));
        if(empty($address)){
            $redirect_url = site_url(uri_string());
            $userSess = array(
                'redirect_url'  => $redirect_url
            );

            $this->session->set_userdata($userSess);
            redirect(site_url('User/addressAdd'));
        }

        $address[0]["tel"] = substr_replace($address[0]["tel"],'****',3,4);

        $this->load->model('Cart_model');
        $r = $this->Cart_model->getData($this->session->userdata('user_id'));
        if(empty($r)){
            $redirect_uri =site_url('Welcome/cart');

            header("Location: $redirect_uri");
        }
        $total_fee=0.00;
        for ($i=0;$i<count($r);$i++){
            $total_fee+=$r[$i]["price"]*$r[$i]["num"];
        }



        $this->load->config('wxpay_config');
        $wxconfig['appid']=$this->config->item('appid');
        $wxconfig['mch_id']=$this->config->item('mch_id');
        $wxconfig['apikey']=$this->config->item('apikey');
        $wxconfig['appsecret']=$this->config->item('appsecret');
        $wxconfig['sslcertPath']=$this->config->item('sslcertPath');
        $wxconfig['sslkeyPath']=$this->config->item('sslkeyPath');
        //由于此类库构造函数需要传参，我们初始化类库就传参数给他吧
        $this->load->library('Wechatpay',$wxconfig);

        //商户交易单号
        $this->load->library('common');
        $out_trade_no=$this->common->order_number();
        $openid=$this->session->userdata('wxopenid');
        

        //$openid="o3wKqw35msXXKY61U0DdiunS7S3k";

        //$out_trade_no = "sdkphp".date("YmdHis");
        $total_fee= 0.01;
        $param['body']="金钟高尔夫 商城商品";
        $param['attach']="1000";
        $param['detail']="金钟高尔夫-".$out_trade_no;
        $param['out_trade_no']=$out_trade_no;
        $param['total_fee']=$total_fee*100;
        $param["spbill_create_ip"] =$_SERVER['REMOTE_ADDR'];
        $param["time_start"] = date("YmdHis");
        $param["time_expire"] =date("YmdHis", time() + 600);
        $param["notify_url"] = site_url("Wxpay/notify/");
        $param["trade_type"] = "JSAPI";
        $param["openid"] = $openid;
        //统一下单，获取结果，结果是为了构造jsapi调用微信支付组件所需参数
        $result=$this->wechatpay->unifiedOrder($param);


        //如果结果是成功的我们才能构造所需参数，首要判断预支付id

        if (isset($result["prepay_id"]) && !empty($result["prepay_id"])) {
            //调用支付类里的get_package方法，得到构造的参数
            $data['parameters']=json_encode($this->wechatpay->get_package($result['prepay_id']));
            $data['notifyurl']=$param["notify_url"];
            $data['fee']=$total_fee;


        }

        $data['title']="确认订单";
        $data['address']=$address[0];
        $data['dataList']=$r;
        $data['out_trade_no']=$out_trade_no;



        $this->load->view('header.html');
        $this->load->view('checkOrder',$data);



    }

    public function wxPay(){
        $xml = '<xml><appid><![CDATA[wxe2963362fb41fb4e]]></appid><attach><![CDATA[1000]]></attach><bank_type><![CDATA[CFT]]></bank_type><cash_fee><![CDATA[1]]></cash_fee><fee_type><![CDATA[CNY]]></fee_type><is_subscribe><![CDATA[Y]]></is_subscribe><mch_id><![CDATA[1470991902]]></mch_id><nonce_str><![CDATA[juc8fmr4pbed09ihs7t5zwn1yolgq3ak]]></nonce_str><openid><![CDATA[o3wKqw35msXXKY61U0DdiunS7S3k]]></openid><out_trade_no><![CDATA[180907926803109701]]></out_trade_no><result_code><![CDATA[SUCCESS]]></result_code><return_code><![CDATA[SUCCESS]]></return_code><sign><![CDATA[EAF2D496F3B26D3147856A75E916E561]]></sign><time_end><![CDATA[20180907115806]]></time_end><total_fee>1</total_fee><trade_type><![CDATA[JSAPI]]></trade_type><transaction_id><![CDATA[4200000174201809078626279822]]></transaction_id></xml>';//要发送的xml
        $url = site_url("Wxpay/notify/");//接收XML地址
        //$header = 'Content-type: text/xml';//定义content-type为xml
        $header[] = "Content-type: text/xml"; // 改为数组解决
        $ch = curl_init(); //初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//设置链接
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置是否返回信息
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//设置HTTP头
        curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);//POST数据
        $response = curl_exec($ch);//接收返回信息
        if(curl_errno($ch)){//出错则显示错误信息
            print curl_error($ch);
        }
        curl_close($ch); //关闭curl链接
        echo $response;//显示返回信息
    }
	
	
	
}
