<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link rel="stylesheet" href="<?php echo base_url();?>assets/wx/css/index.css" />
    

    <section class="g-scrollview" id="J_List">

        <div class="m-slider" data-ydui-slider>
            <div class="slider-wrapper">
                <div class="slider-item">
                    <a href="#">
                        <img src="/assets/wx/img/banner-1.jpg">
                    </a>
                </div>
                <div class="slider-item">
                    <a href="#">
                        <img src="/assets/wx/img/banner-2.jpg">
                    </a>
                </div>
                <div class="slider-item">
                    <a href="#">
                        <img src="/assets/wx/img/banner-1.jpg">
                    </a>
                </div>
                <div class="slider-item">
                    <a href="#">
                        <img src="/assets/wx/img/banner-2.jpg">
                    </a>
                </div>
            </div>
            <div class="slider-pagination"></div>
        </div>

        <div class="m-grids-4" >
            <a href="<?php echo site_url('Welcome/categoryGoods/0');?>" class="grids-item">
                <div class="grids-txt"><span><img src="/assets/img/goods_default.jpg" data-url="/assets/wx/img/cat-1.png" class="cat-item" alt=""></span></div>
            </a>
            <a href="<?php echo site_url('Welcome/categoryGoods/1');?>" class="grids-item">
                <div class="grids-txt"><span><img src="/assets/img/goods_default.jpg" data-url="/assets/wx/img/cat-2.png" class="cat-item" alt=""></span></div>
            </a>
            <a href="<?php echo site_url('Welcome/categoryGoods/2');?>" class="grids-item">
                <div class="grids-txt"><span><img src="/assets/img/goods_default.jpg" data-url="/assets/wx/img/cat-3.png" class="cat-item" alt=""></span></div>
            </a>
            <a href="<?php echo site_url('Welcome/categoryGoods/3');?>" class="grids-item">
                <div class="grids-txt"><span><img src="/assets/img/goods_default.jpg" data-url="/assets/wx/img/cat-4.png" class="cat-item" alt=""></span></div>
            </a>
            <a href="<?php echo site_url('Welcome/categoryGoods/4');?>" class="grids-item">
                <div class="grids-txt"><span><img src="/assets/img/goods_default.jpg" data-url="/assets/wx/img/cat-5.png" class="cat-item" alt=""></span></div>
            </a>
            <a href="<?php echo site_url('Welcome/categoryGoods/5');?>" class="grids-item">
                <div class="grids-txt"><span><img src="/assets/img/goods_default.jpg" data-url="/assets/wx/img/cat-6.png" class="cat-item" alt=""></span></div>
            </a>
            <a href="<?php echo site_url('Welcome/categoryGoods/6');?>" class="grids-item">
                <div class="grids-txt"><span><img src="/assets/img/goods_default.jpg" data-url="/assets/wx/img/cat-7.png" class="cat-item" alt=""></span></div>
            </a>
            <a href="<?php echo site_url('Welcome/categoryGoods/7');?>" class="grids-item">
                <div class="grids-txt"><span><img src="/assets/img/goods_default.jpg" data-url="/assets/wx/img/cat-8.png" class="cat-item" alt=""></span></div>
            </a>
        </div>

        
            <div id="J_ListContent" class="m-list list-theme1"></div>
        

    </section>

<script id="J_ListHtml" type="text/html">
    {{each list as data}}
    <a href="<?php echo site_url('Goods/goodsDetail/');?>{{data.id}}" class="list-item">
        <div class="list-img" >
            <img src="/assets/img/goods_default.jpg" data-url="{{data.img}}" style="padding: 20px;">
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
        
        $('img.cat-item').lazyLoad();

        // 根据实际情况自定义获取数据方法
        var page = 1, pageSize = 10;
        var loadMore = function (callback) {
            $.ajax({
                url: '<?php echo site_url("Goods/index");?>',
                //url: 'http://list.ydui.org/getdata.php?type=backposition',
                dataType: 'json',
                data: {
                    page: page,
                    pagesize: pageSize
                },
                success: function (ret) {
                    
                    typeof callback == 'function' && callback(ret);
                }
            });
        };

        $('#J_List').infiniteScroll({
            binder: '#J_List',
            pageSize: pageSize,
            initLoad: true,
            loadingHtml: '<img src="/assets/img/loading.svg"/>',
            loadListFn: function () {
                var def = $.Deferred();

                loadMore(function (listArr) {

                    var html = template('J_ListHtml', {list: listArr});
                    $('#J_ListContent').append(html).find('img').lazyLoad({binder: '#J_List'});

                    def.resolve(listArr);

                    ++page;
                });

                return def.promise();
            }
        });
    }();
</script>