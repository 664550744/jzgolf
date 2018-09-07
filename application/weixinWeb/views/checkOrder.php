<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: wangwenhua
 * Date: 2018/8/30
 * Time: 下午9:49
 */
$jsApiParameters = $parameters;//参数赋值
?>


<header class="m-navbar">
    <a href="<?php echo site_url('Welcome/cart');?>" class="navbar-item">
        <i class="back-ico"></i>
    </a>
    <div class="navbar-center"><span class="navbar-title"><?php echo $title; ?></span></div>
</header>
<div id="content" class="g-scrollview">
    <article class="m-list list-theme4">
    <div class="list-item">

        <div class="list-mes">
            <h3 class="list-title"><?php echo $address["name"];?>(<?php echo $address["tel"];?>) </h3>
            <div class="list-mes-item">
                <?php echo $address["city"].' '.$address["address"];?>
            </div>
        </div>

    </div>
    </article>
    <div style ="padding: .2rem;font-size: .3rem;color: #333;" >订单商品</div>
    <article class="m-list list-theme4">

        <div  v-for=' (item,index)  in dataList' class="list-item">
            <div class="list-img">
                <img src="/assets/img/goods_default.jpg" v-bind:data-url="item.img">
                <div v-if="item.stock_num<item.num" class="goodsTip">库存不足</div>
            </div>
            <div class="list-mes">
                <h3 class="list-title">{{item.name}}</h3>
                <div class="list-mes-item">
                    <div>
                        <span class="list-price"><em>¥</em>{{item.price}}</span>

                    </div>
                    <div>
                        {{item.goods_selects_text}}
                    </div>
                </div>
                <div class="cell-item">

                    <div class="cell-left">
                            购买数量: <span class="list-price">{{item.num}}</span>

                    </div>




                </div>
            </div>
        </div>


    </article>

    <div class="m-cell" style="margin-top: .2rem;">
        <div class="cell-item">
            <div class="cell-left">商品金额</div>
            <div class="cell-right"><span class="list-price"><em>¥</em> {{total.toFixed(2)}}</span></div>
        </div>
        <div class="cell-item">
            <div class="cell-left">运费</div>
            <div class="cell-right"><span class="list-price"><em>¥</em> {{freight.toFixed(2)}}</span></div>
        </div>
        <div class="cell-item">
            <div class="cell-left"></div>
            <div class="cell-right">总价：<span class="list-price"><em>¥</em> {{total.toFixed(2)}}</span></div>
        </div>
    </div>
    <div style="margin: auto .4rem">
        <button type="button" v-on:click="creatOrder()"class="btn-block btn-danger" >在线支付</button>
    </div>


</div>

<!-- 引入YDUI脚本 -->
<script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/ydui/build/js/ydui.js"></script>
<script type="text/javascript">
    var dialog;
    !function (win, $) {
        dialog = win.YDUI.dialog;
    }(window, jQuery);

    var vm =new Vue({
        el: '#page',
        data: {
            dataList: <?php print_r(json_encode($dataList)); ?>,
            total:0.00,
            freight:0.00
        },
        mounted: function () {
            this.initPage();
        },
        methods: {
            initPage:function(e){
                vm = this;
                $('#content').find('img').lazyLoad({binder: '#content'});
                var total =0;
                for(i=0;i<vm.dataList.length;i++){
                    total +=vm.dataList[i]["price"]*vm.dataList[i]["num"];
                }
                vm.total=total;
            },
            creatOrder:function () {
                $.ajax({
                    url: '<?php echo site_url("Ajax/addOrder");?>',
                    data:{num:'<?php echo $out_trade_no ?>'},
                    type:"POST",
                    dataType: "json",
                    beforeSend:function(){
                        dialog.loading.open('正在生成订单...');

                    },
                    complete: function () {
                        dialog.loading.close();/* 移除loading */


                    },
                    success:function(obj) {

                        console.log(obj)
                        if(obj.code==1){
                            //dialog.toast(obj.msg, 'success', 1000);
                            callpay();
                        }else{
                            dialog.toast(obj.msg, 'error', 1000);
                        }


                    }
                });
                
            }


        }
    })





</script>

</section>
</body>
<script type="text/javascript">
    //调用微信JS api 支付
    function jsApiCall()
    {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            <?php echo $jsApiParameters; ?>,
            function(res){
                WeixinJSBridge.log(res.err_msg);
                //alert(res.err_code+res.err_desc+res.err_msg);
                //if(res.err_msg == "get_brand_wcpay_request:ok" ){
                    location.href="<?php echo site_url('Order/index/?id='.$out_trade_no);?>";
                //}
            }
        );
    }


    function callpay()
    {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall();
        }
    }
</script>
</html>

<style>
    .goodsTip{
        position: absolute;
        width: 100%;
        text-align: center;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        color:#fff;
    }
    .list-img{position: relative;}
</style>