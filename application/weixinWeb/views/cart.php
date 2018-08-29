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
        					<span class="m-spinner" data-ydui-spinner="{input: '.J_Input', add: '.J_Add', minus: '.J_Del'}">
				                <a href="javascript:;" class="J_Del"></a>
				                <input type="text" v-bind:value="item.num" class="J_Input" placeholder=""/>
				                <a href="javascript:;" class="J_Add"></a>
				            </span>

        				</div>
        				<div class="cell-right">
							
				            <a href="javascript:;" class="btn btn-danger">删除</a>
				            
        				</div>
    
                    	

                    </div>
                </div>
            </div>
            
    	
        </article>
    <?php }?>

       
    </div>
    <!-- 引入YDUI脚本 -->
    <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/ydui/build/js/ydui.js"></script>
    <script> 
    	new Vue({
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
					}

				}
			})
                        
    </script>

