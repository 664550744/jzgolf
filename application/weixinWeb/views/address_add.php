<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: wangwenhua
 * Date: 2018/8/31
 * Time: 上午10:37
 */
?>
<header class="m-navbar">
    <a href="javascript:window.history.back()" class="navbar-item">
        <i class="back-ico"></i>
    </a>
    <div class="navbar-center"><span class="navbar-title"><?php echo $title; ?></span></div>
</header>
<section class="g-scrollview" id="J_List">
    <div class="m-cell">
        <div class="cell-item">
            <div class="cell-left">收货人：</div>
            <div class="cell-right">

                <input type="text" class="cell-input" v-model="name" v-bind:value="name" placeholder="请输入收货人姓名" autocomplete="off">
            </div>
        </div>
        <div class="cell-item">
            <div class="cell-left">手机号：</div>
            <div class="cell-right"><input type="number" v-model="tel" v-bind:value="tel" pattern="[0-9]*" class="cell-input" placeholder="请输入手机号" autocomplete="off" /></div>
        </div>

        <div class="cell-item">
            <div class="cell-left">所在地区：</div>
            <div class="cell-right cell-arrow"> <input type="text" readonly id="J_Address" placeholder="请选择收货地址" style="border: none;background: transparent;"></div>
        </div>
        <div class="cell-item">
            <div class="cell-left">详细地址：</div>
            <div class="cell-right">
                <textarea class="cell-textarea" v-model="address" v-bind:value="address" placeholder="请输入详细地址"></textarea>
            </div>
        </div>

    </div>

    <div style="padding-top: 10px;padding-bottom: 10px;">
        <a href="javascript:;" v-on:click="addressCheck"  style="margin: 0 auto;color: #fff;border-radius: 20px; width: 80%;display: block;"  class="btn btn-danger">确定</a>

    </div>




</section>
<!-- 引入YDUI脚本 -->
<script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/ydui/build/js/ydui.js"></script>
<script src="<?php echo base_url();?>assets/ydui/ydui.citys.js"></script>
<script>


    var dialog;
    !function (win, $) {
        dialog = win.YDUI.dialog;
    }(window, jQuery);

    var vm =new Vue({
        el: '#page',
        data: {
            name:'',
            tel:'',
            province:'',
            city:'',
            area:'',
            address:''
        },
        mounted: function () {

        },
        methods: {

            addressCheck:function (e) {

                var name = $.trim(vm.name);
                if(name.length<2){
                    dialog.toast('姓名至少输入2个字', 'none', 1000);
                    return false;
                }
                if(name.length>8){
                    dialog.toast('姓名不能超过8个字', 'none', 1000);
                    return false;
                }
                //手机号正则
                var phoneReg = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;
                //电话
                var phone = $.trim(vm.tel);
                if (!phoneReg.test(phone)) {

                    dialog.toast('请输入有效的手机号码！', 'none', 1000);
                    return false;
                }

                if(vm.province<1){
                    dialog.toast('请选择所在地区', 'none', 1000);
                    return false;
                }
                var address = $.trim(vm.address);
                if(address.length<4){
                    dialog.toast('详细地址至少输入4个字', 'none', 1000);
                    return false;
                }
                if(address.length>50){
                    dialog.toast('姓名不能超过50个字', 'none', 1000);
                    return false;
                }
                this.addAddressPost(name,phone,vm.province+" "+vm.city+" "+vm.area,vm.address);

            },
            addAddressPost:function (name,tel,city,address) {
                $.ajax({
                    url: '<?php echo site_url("Ajax/addAddress");?>',
                    data:{name:name,tel:tel,city:city,address:address},
                    type:"POST",
                    dataType: "json",
                    beforeSend:function(){
                        dialog.loading.open('正在添加收货地址...');

                    },
                    complete: function () {
                        dialog.loading.close();/* 移除loading */


                    },
                    success:function(obj) {


                        if(obj.code==1){
                            dialog.toast(obj.msg, 'success', 2000);
                            setTimeout(function () {
                                if(obj.redirect_url>5){
                                    location.href=obj.redirect_url
                                }else{
                                    window.history.back();
                                }

                            }, 2000);

                        }else{
                            dialog.toast(obj.msg, 'error', 1000);
                        }


                    }
                });

            }


        }
    })

    var $address = $('#J_Address');

    $address.citySelect();

    $address.on('click', function () {
        $address.citySelect('open');
    });

    $address.on('done.ydui.cityselect', function (ret) {
        /* 省：ret.provance */
        /* 市：ret.city */
        /* 县：ret.area */
        vm.province = ret.provance;
        vm.city = ret.city;
        vm.area = ret.area;
        $(this).val(ret.provance + ' ' + ret.city + ' ' + ret.area);
    });
</script>
