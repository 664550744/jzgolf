<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common {

	public function json($json_arr){
		print_r(json_encode($json_arr));
		exit();

	}

    /**
     * Notes:生成10位绝不重复订单号
     * User: wangwenhua
     * Date: 2018/9/5
     * Time: 下午3:13
     * qq: 664550744
     * e-mail:664550744@qq.com
     * @return string
     */
    public function order_number(){

        static $ORDERSN=array();                                        //静态变量
        $ors=date('ymd').substr(time(),-5).substr(microtime(),2,5);     //生成16位数字基本号
        if (isset($ORDERSN[$ors])) {                                    //判断是否有基本订单号
            $ORDERSN[$ors]++;                                           //如果存在,将值自增1
        }else{
            $ORDERSN[$ors]=1;
        }
        return $ors.str_pad($ORDERSN[$ors],2,'0',STR_PAD_LEFT);     //链接字符串

        //return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

}