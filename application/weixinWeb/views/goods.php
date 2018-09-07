<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>金钟高尔夫商城</title>
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <!-- 引入YDUI样式 -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/ydui/build/css/ydui.css" />
    <!-- 引入YDUI自适应解决方案类库 -->
    <script src="<?php echo base_url();?>assets/ydui/build/js/ydui.flexible.js"></script>
    <!-- 引入YDUI脚本 -->
    <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/ydui/build/js/ydui.js"></script>

    <script src="<?php echo base_url();?>assets/wx/js/template.js"></script>
    <script src="<?php echo base_url();?>assets/admin/js/vue.min.js"></script>
    <script src="<?php echo base_url();?>assets/admin/js/vue-resource.min.1.5.1.js"></script>

</head>
<body>
    <style> .m-navbar{background: #F5F5F5;}</style>
<section class="g-flexview" id="page">
    <header class="m-navbar">
        <a href="javascript:window.history.back()" class="navbar-item">
            <i class="back-ico"></i>
        </a>
        <div class="navbar-center"><span class="navbar-title"><?php echo $name; ?></span></div>
        <a href="<?php echo site_url('Welcome/cart');?>" class="navbar-item">
            <span class="navbar-icon">
            <i class="icon-shopcart-outline"></i>
        </span>


        </a>

        
    </header>
    <div class="g-scrollview" id="J_List">
       <div class="m-slider" data-ydui-slider>
            <div class="slider-wrapper">
                <?php 
                    for ($i=0; $i <count($imgs) ; $i++) {
                        ?>

                         <div class="slider-item">
                            <a href="#">
                                <img src="/assets/img/goods_default.jpg" data-url="<?php echo($imgs[$i]) ?>" class="cat-item">
                            </a>
                        </div>

                        <?php
                    }
                ?>
               
                
            </div>
            <div class="slider-pagination"></div>
        </div>
        <div class="m-grids-2" style="margin-top: 10px;">
            <div class="grids-item">
                
                <div class="m-cell">
                    <div class="cell-item">
                        <div class="cell-left">价格：</div>
                        <div class="cell-left"><span style="color: red">¥{{price+addPrice}}</span>元</div>
                        <div class="cell-right"></div>
                    </div>
                    
                </div>
            </div>
            <div class="grids-item">
                
                <div class="m-cell">
                    <div class="cell-item">
                        <div class="cell-left">库存：</div>
                        <div class="cell-left"><span style="color: red">{{stock_num}}</span></div>
                        <div class="cell-right"></div>
                    </div>
                    
                </div>
            </div>
            
            
        </div>
        <div  style="padding-top: 10px;">
            
                <div class="m-cell">
                    <div class="cell-item" v-for=' (item,index)  in goods_select'>
                        <div class="cell-left">{{item.v}}:</div>
                        <div class="cell-left">
                            <div> 
                                <div v-for=' (it,i)  in item.list' class="select_item_btns"    v-bind:data-index='index' v-bind:data-i='i'>
                                    <div class="select_item">{{it[0]}}</div>
                                </div>
                            
                                
                            </div>
                            
                                

                        </div>
                        <div class="cell-right"></div>
                    </div>

            </div>  
        </div>
        <div class="m-tab" data-ydui-tab style="padding-top: 10px;"><!-- 这里添加data-ydui-tab就可以啦 -->
            <ul class="tab-nav">
                <li class="tab-nav-item tab-active"><a href="javascript:;">规格属性</a></li>
                <li class="tab-nav-item"><a href="javascript:;">详情</a></li>
                
            </ul>
            <div class="tab-panel">
                <div class="tab-panel-item tab-active">
                    <div class="m-cell">
                        <div class="cell-item">
                            <div class="cell-left">名称：</div>
                            <div class="cell-left"><?php echo $name; ?></div>
                            <div class="cell-right"></div>
                        </div>
                        
                    </div>
                    <div class="m-cell">
                        <div class="cell-item">
                            <div class="cell-left">品牌：</div>
                            <div class="cell-left"><?php echo $brand; ?></div>
                            <div class="cell-right"></div>
                        </div>
                        
                    </div>
                    <div  v-for=' (item,index)  in goods_attribute' class="m-cell">
                        <div class="cell-item">
                            <div class="cell-left">{{item.k}}：</div>
                            <div class="cell-left">{{item.v}}</div>
                            <div class="cell-right"></div>
                        </div>
                        
                    </div>

                </div>
                <div class="tab-panel-item" style="padding: 0">
                    <div id="content"><img  style="display: block; margin: 50px auto;" src="/assets/img/loading.svg"/></div>
                </div>
                
            </div>
        </div>

       

    </div>

    <footer class="m-tabbar">
        
      
      <a href="javascript:addcart();" id="addcartBtn" style="margin: 0 auto;color: #fff;border-radius: 20px; width: 80%;"  class="btn btn-danger">加入购物车</a>
            
            
        
        
    </footer>
</section>
    <!-- 引入YDUI脚本 -->
    <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/ydui/build/js/ydui.js"></script>
   
<script>
   
  var isSetClass=false;
  var isPost=false;
  var dialog;
    !function (win, $) {
         dialog = win.YDUI.dialog;
        
        $('img.cat-item').lazyLoad();
        $.ajax({
                url: '<?php echo site_url("Goods/content/").$id;?>',
                //url: 'http://list.ydui.org/getdata.php?type=backposition',
                dataType: 'html',
                
                success: function (html) {
                    $('#content').html(html).find('img').lazyLoad({binder: '#J_List'});;
                    
                }
            });

        // 根据实际情况自定义获取数据方法
        //$('.select_item_btns').addClass("select_item_");
        //
        

       
    }(window, jQuery);

    var goods_select  = eval(<?php print_r(
                                json_encode($goods_select)) ; ?> );
    var stock_num_info  = eval(<?php print_r(
                                json_encode($stock_num_info)) ; ?> );
    var goods_attribute  = eval( <?php print_r(
                                json_encode($goods_attribute)) ; ?> );
     var checkSelect =  new Array(goods_select.length);
     for (var i = 0; i < goods_select.length; i++) {
         checkSelect[i]=-1;
     }
    
     var vm = new Vue({
                            el: '#page',
                            data: {
                                addPrice:0,
                                price: <?php echo $price; ?>
                                ,stock_num: <?php echo $stock_num; ?>
                                ,is_new: <?php echo $is_new; ?>
                                ,goods_select:goods_select
                                ,stock_num_info: stock_num_info
                                ,goods_attribute: goods_attribute
                               
                            }
                        }) ;
     $(function(){
         $('.select_item_btns').click(function(e){
            if(!isSetClass){
                $(".select_item_btns").each(function(){
                    $(this).addClass("select_item_"+$(this).data('index'));
                  });
                isSetClass = true;
            }
            $(".select_item_"+$(this).data('index')).removeClass("check_btn");
            $(this).addClass("check_btn")
            checkSelect[$(this).data('index')]=$(this).data('i');
             initPricrStock();
        })
     })

     function initPricrStock(){
        var addPrice = 0;
        var stock_num_arr = stock_num_info;
        for (var i = 0; i <checkSelect.length; i++) {
            if (checkSelect[i]!=-1) {
                addPrice+=parseInt(vm.goods_select[i]["list"][checkSelect[i]][1]);
                var stock_num_arr_n=[]; 
                for (var j = 0; j <stock_num_arr.length; j++) {
                    if(stock_num_arr[j]["k"][i]==checkSelect[i]){
                       stock_num_arr_n.push(stock_num_arr[j]); 
                    }
                    
                }
                stock_num_arr = stock_num_arr_n;
            }
        }
        //console.log(stock_num_arr);
        vm.addPrice = addPrice;
        var stock_num = 0;
        for (var j = 0; j <stock_num_arr.length; j++) {
               stock_num +=  parseInt(stock_num_arr[j]['v']);
        }
        vm.stock_num = stock_num;
     }
     function addcart(){
        if(isPost){return;}
       var goods_select_text = "";
        for (var i = 0; i <checkSelect.length; i++) {
            if (checkSelect[i]==-1) {
                
                dialog.toast('请选择'+vm.goods_select[i]["v"], 'none', 2000);
                return;
            }
            if(goods_select_text.length>0){
                goods_select_text += "|"+vm.goods_select[i]["list"][checkSelect[i]][0];
            }else{
                goods_select_text = vm.goods_select[i]["list"][checkSelect[i]][0];
            }
        }
        if (vm.stock_num<1) {
            dialog.toast('当前商品库存不足！无法加入购物车', 'error', 2000);
                return;
        }
        $("#addcartBtn").removeClass("btn-danger").addClass("btn-disabled");
        isPost = true;
        postGoodsToCart(goods_select_text);
     }
     function postGoodsToCart(goods_select_text){
        $.ajax({
            url: '<?php echo site_url("Ajax/addcart");?>',
            data:{g_id:'<?php echo $id;?>',goods_selects_text:goods_select_text,goods_selects:JSON.stringify(checkSelect),price:parseInt(vm.price)+parseInt(vm.addPrice) },
            type:"POST",
            dataType: "json",
            beforeSend:function(){
                dialog.loading.open('正在添加到购物车中...');
            
            },
            complete: function () {
                dialog.loading.close();/* 移除loading */
                
                setTimeout(function () {
                   $("#addcartBtn").removeClass("btn-disabled").addClass("btn-danger");
                    isPost =false;
                }, 2000);
            },
            success:function(obj) {

                if(obj.code==1){
                    dialog.toast(obj.msg, 'success', 1000);
                }else{
                    dialog.toast(obj.msg, 'error', 1000);
                }


            }
        });
     }
     
</script>
</body>
</html>
<style> 
    .grids-item,.m-cell{margin: 0px;padding: 0px;}
    .select_item{background: #fff;border: 1px solid #F5F5F5;padding: 5px;text-align: center;min-width: 100px;}
    .disable_btn>.select_item{background: #F5F5F5;}
    .check_btn>.select_item{border: 1px solid #ff8400;background-color: #fff;background-image: url('/assets/wx/img/goods_select_btn.png');
background-repeat: no-repeat;
background-size: 16px;
background-position: 100% 100%;}
.select_item_btns{
padding: 0 10px; float: left;
margin: 10px 0;
}


</style>
