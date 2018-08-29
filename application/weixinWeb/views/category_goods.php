<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link rel="stylesheet" href="<?php echo base_url();?>assets/wx/css/index.css" />
    <header class="m-navbar">
        <a href="<?php echo site_url();?>" class="navbar-item">
        <i class="back-ico"></i>
    </a>
        <div class="navbar-center"><span class="navbar-title"><?php echo $title; ?></span></div>
    </header>

    <section class="g-scrollview" id="J_List">

        
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

        // 根据实际情况自定义获取数据方法
        var page = 1, pageSize = 10;
        var loadMore = function (callback) {
            $.ajax({
                url: '<?php echo site_url("Goods/categoryGoods");?>',
                //url: 'http://list.ydui.org/getdata.php?type=backposition',
                dataType: 'json',
                data: {
                    page: page,
                    pagesize: pageSize,
                    type: <?php echo $cat;?>
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