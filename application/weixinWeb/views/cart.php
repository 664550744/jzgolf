	<style>
		#empty-box{display: block;width: auto;margin:50px auto;}
	</style>
	<header class="m-navbar">
       
        <div class="navbar-center"><span class="navbar-title">购物车</span></div>
    </header>
    <div id="app" class="g-scrollview">
    	<?php if(count($dataList)==0){?>
    	<div style="text-align: center;color: #888;">
    		<img id="empty-box" src="/assets/wx/img/cart-icon.png" alt="">
    		购物车，暂无商品
    	</div>
    	<?php }else{ ?>
    	<article class="m-list list-theme4">
    		
    		<div  v-for=' (item,index)  in dataList' class="list-item">
                <div class="list-img">
                    <img src="/assets/img/goods_default.jpg" v-bind:data-url="item.img">
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
        					<span class="m-spinner" >
				                <a href="javascript:;" v-on:click="numreduce(item.id,item.num,index)" class="J_Del"></a>
				                <input type="text" v-model="dataList[index].num"  v-bind:value="item.num" class="J_Input" placeholder=""/>
				                <a href="javascript:;" v-on:click="numadd(item.id,item.num,index)" class="J_Add"></a>
				            </span>

        				</div>
        				<div class="cell-right">
							
				            <a href="javascript:;" v-on:click="dele(item.id,index)" class="btn btn-danger">删除</a>
				            
        				</div>
    
                    	

                    </div>
                </div>
            </div>
            
    	
        </article>
            <div style="padding-top: 10px;padding-bottom: 10px;">
                <a href="<?php echo site_url('Welcome/checkOrder');?>"  style="margin: 0 auto;color: #fff;border-radius: 20px; width: 80%;display: block;"  class="btn btn-danger">去结算</a>

            </div>

        <?php }?>

       
    </div>
    <!-- 引入YDUI脚本 -->
    <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/ydui/build/js/ydui.js"></script>
    <script>
        var dialog;
        !function (win, $) {
            dialog = win.YDUI.dialog;
        }(window, jQuery);

        var vm =new Vue({
			  el: '#app',
			  data: {
			    dataList: <?php print_r(json_encode($dataList)); ?>
			  },
				mounted: function () {
					this.initPage();
				},
				methods: {
					initPage:function(e){
						$('#app').find('img').lazyLoad({binder: '#app'});
					},
                    dele:function (id,index) {
                        var vm = this;
                        dialog.confirm('', '您确定要删除这个商品吗？', function () {
                            $.ajax({
                                url: '<?php echo site_url("Ajax/deleteCart");?>',
                                data:{id:id},
                                type:"POST",
                                dataType: "json",
                                beforeSend:function(){
                                    dialog.loading.open('正在删除购物车中的商品...');

                                },
                                complete: function () {
                                    dialog.loading.close();/* 移除loading */


                                },
                                success:function(obj) {


                                    if(obj.code==1){
                                        dialog.toast(obj.msg, 'success', 1000);
                                       vm.dataList.splice(index,1);


                                    }else{
                                        dialog.toast(obj.msg, 'error', 1000);
                                    }


                                }
                            });

                        });
                    },
                    goShoping:function (e) {


                    },
                    numreduce:function (id,num,index) {
                        num--;

                        if(num<1){
                            dialog.toast('库存不能小于1', 'none', 1000);
                            return;
                        }
                        this.postCartNum(id,num,index);

                    },
                    numadd:function (id,num,index) {
                        num++;
                        this.postCartNum(id,num,index);
                    },
                    postCartNum:function (id,num,index) {
                        $.ajax({
                            url: '<?php echo site_url("Ajax/numCart");?>',
                            data:{id:id,num:num},
                            type:"POST",
                            dataType: "json",
                            beforeSend:function(){
                                dialog.loading.open('正在购物车中的商品数量...');

                            },
                            complete: function () {
                                dialog.loading.close();/* 移除loading */


                            },
                            success:function(obj) {


                                if(obj.code==1){
                                    vm.dataList[index]["num"]=num;
                                    //dialog.toast(obj.msg, 'success', 1000);

                                }else{
                                    dialog.toast(obj.msg, 'error', 1000);
                                }


                            }
                        });

                    }

				}
			})




                        
    </script>

