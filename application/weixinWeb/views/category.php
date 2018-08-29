<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<header class="m-navbar">
        <div class="navbar-center"><span class="navbar-title">分类</span></div>
    </header>

    <section  class="g-scrollview" >

        <div class="m-scrolltab" data-ydui-scrolltab>
            <div class="scrolltab-nav">
                <a href="javascript:;" class="scrolltab-item">
                    <div class="scrolltab-icon"><i class="demo-icons-category1"></i></div>
                    <div class="scrolltab-title">一号木</div>
                </a>
                <a href="javascript:;" class="scrolltab-item">
                    <div class="scrolltab-icon"><i class="demo-icons-category2"></i></div>
                    <div class="scrolltab-title">球道木</div>
                </a>
                <a href="javascript:;" class="scrolltab-item">
                    <div class="scrolltab-icon"><i class="demo-icons-category3"></i></div>
                    <div class="scrolltab-title">铁杆</div>
                </a>
                <a href="javascript:;" class="scrolltab-item">
                    <div class="scrolltab-icon"><i class="demo-icons-category4"></i></div>
                    <div class="scrolltab-title">推杆</div>
                </a>
                <a href="javascript:;" class="scrolltab-item">
                    <div class="scrolltab-icon"><i class="demo-icons-category5"></i></div>
                    <div class="scrolltab-title">穿戴</div>
                </a>
                <a href="javascript:;" class="scrolltab-item">
                    <div class="scrolltab-icon"><i class="demo-icons-category6"></i></div>
                    <div class="scrolltab-title">配件</div>
                </a>
                <a href="javascript:;" class="scrolltab-item">
                    <div class="scrolltab-icon"><i class="demo-icons-category7"></i></div>
                    <div class="scrolltab-title">套杆</div>
                </a>
                <a href="javascript:;" class="scrolltab-item">
                    <div class="scrolltab-icon"><i class="demo-icons-category8"></i></div>
                    <div class="scrolltab-title">二手区</div>
                </a>
            </div>
            <div class="scrolltab-content" id="J_List">
                <div class="scrolltab-content-item">
                    <strong class="scrolltab-content-title">一号木</strong>
                    <div id="itmes-0" class="m-list list-theme1"></div>
                </div>
                <div class="scrolltab-content-item">
                    <strong class="scrolltab-content-title">球道木</strong>
                    <div id="itmes-1" class="m-list list-theme1"></div>
                </div>
                <div class="scrolltab-content-item">
                    <strong class="scrolltab-content-title">铁杆</strong>
                    <div id="itmes-2" class="m-list list-theme1"> </div>
                </div>
                <div class="scrolltab-content-item">
                    <strong class="scrolltab-content-title">推杆</strong>
                    <div id="itmes-3" class="m-list list-theme1"></div>
                </div>
                <div class="scrolltab-content-item">
                    <strong class="scrolltab-content-title">穿戴</strong>
                    <div id="itmes-4" class="m-list list-theme1"></div>
                </div>
                <div class="scrolltab-content-item">
                    <strong class="scrolltab-content-title">配件</strong>
                    <div id="itmes-5" class="m-list list-theme1"></div>
                </div>
                <div class="scrolltab-content-item">
                    <strong class="scrolltab-content-title">套杆</strong>
                    <div id="itmes-6" class="m-list list-theme1"></div>
                </div>
                <div class="scrolltab-content-item">
                    <strong class="scrolltab-content-title">二手区</strong>
                    <div id="itmes-7" class="m-list list-theme1"></div>
                </div>
            </div>
        </div>

    </section>
    <script id="J_ListHtml" type="text/html">
    {{each list as data}}
    <a href="<?php echo site_url('Goods/goodsDetail/');?>{{data.id}}" class="list-item">
        <div class="list-img" >
            <img src="/assets/img/goods_default.jpg" class="lazy" data-url="{{data.img}}" style="padding: 20px;">
        </div>
        <div class="list-mes">
            <h3 class="list-title">{{data.name}}</h3>
            <div class="list-mes-item">
                <div>
                    <span class="list-price"><em>¥</em>{{data.price}}</span>
                    <span class="list-del-price">¥{{data.price_market}}</span>
                </div>
            </div>
        </div>
    </a>
    {{/each}}
</script>
<script src="<?php echo base_url();?>assets/wx/js/template.js"></script>
    <script src="<?php echo base_url();?>assets/admin/js/vue.min.js"></script>
    <script src="<?php echo base_url();?>assets/admin/js/vue-resource.min.1.5.1.js"></script>
<script>
!function () {

        // 根据实际情况自定义获取数据方法
        
            $.ajax({
                url: '<?php echo site_url("Goods/category");?>',
                dataType: 'json',
                data: {},

                success: function (ret) {
                    var html='';
                    for(i=0;i<ret.length;i++){
                        html = template('J_ListHtml', {list: ret[i]});
                        $('#itmes-'+i).append(html).find('img');
                    }
                        
                     $("img.lazy").lazyLoad({binder: '#J_List'});
                     
                }
            });
        

        
    }(); 

    
</script>
