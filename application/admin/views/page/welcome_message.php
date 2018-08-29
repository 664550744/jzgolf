<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>金钟商城-后台管理</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/X-admin/css/font.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/X-admin/css/xadmin.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/admin/X-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/admin/X-admin/js/xadmin.js"></script>

</head>
<body>
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo"><a href="<?php echo site_url();?>">金钟商城-后台管理</a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>
        
        <ul class="layui-nav right" lay-filter="">
          <li class="layui-nav-item">
            <a href="javascript:;"><?php echo $username; ?></a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <dd><a href="<?php echo site_url("Welcome/login");?>">退出</a></dd>
            </dl>
          </li>
          <li class="layui-nav-item to-index"><a href="/">前台首页</a></li>
        </ul>
        
    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
     <!-- 左侧菜单开始 -->
    <div class="left-nav">
      <div id="side-nav">
        <ul id="nav">
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6b4;</i>
                    <cite>商品目录</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                
                    <li>
                        <a _href="<?php echo site_url("Welcome/category");?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>商品分类</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="<?php echo site_url("Welcome/goods");?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>商品管理</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="<?php echo site_url("Welcome/brand");?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>品牌管理</cite>
                        </a>
                    </li>
                    <li>
                        
                        <a href="javascript:;">
                            <i class="iconfont">&#xe6eb;</i>
                            <cite>商品属性</cite>
                            <i class="iconfont nav_right">&#xe697;</i>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a _href="<?php echo site_url("Welcome/goods_attribute_option");?>">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>商品属性</cite>
                                    
                                </a>
                            </li >
                            <li>
                                <a _href="<?php echo site_url("Welcome/goods_attribute");?>">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>属性组</cite>
                                    
                                </a>
                            </li>
                            
                            
                        </ul>
                    
                    </li>
                    <li>
                        <a _href="<?php echo site_url("Welcome/goods_select");?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>选项管理</cite>
                        </a>
                    </li>
                    <li>
                        <a _href="unicode.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>商品评论</cite>
                        </a>
                    </li>
                    
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6b8;</i>
                    <cite>会员管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="member-list.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>会员列表</cite>
                            
                        </a>
                    </li >
                    <li>
                        <a _href="member-del.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>会员删除</cite>
                            
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont">&#xe70b;</i>
                            <cite>会员管理</cite>
                            <i class="iconfont nav_right">&#xe697;</i>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a _href="xxx.html">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>会员列表</cite>
                                    
                                </a>
                            </li >
                            <li>
                                <a _href="xx.html">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>会员删除</cite>
                                    
                                </a>
                            </li>
                            <li>
                                <a _href="xx.html">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>等级管理</cite>
                                    
                                </a>
                            </li>
                            
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>订单销售</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="order-list.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>订单管理</cite>
                        </a>
                    </li >
					<li>
                        <a _href="order-list.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>商品退换</cite>
                        </a>
                    </li >
                </ul>
            </li>
            
            
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe726;</i>
                    <cite>管理员管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="admin-list.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>管理员列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="admin-role.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>角色管理</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="admin-cate.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>权限分类</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="admin-rule.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>权限管理</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6ce;</i>
                    <cite>系统统计</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="echarts1.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>拆线图</cite>
                        </a>
                    </li >
                    
                </ul>
            </li>
            
        </ul>
      </div>
    </div>
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
          <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
          </ul>
          <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='<?php echo site_url("Welcome/home");?>' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
          </div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
    <!-- 底部开始 -->
    <div class="footer">
        <div class="copyright">Copyright ©2017 深圳朗杰信息技术有限公司 All Rights Reserved</div>  
    </div>
    <!-- 底部结束 -->
   
</body>
</html>
<script type="text/javascript"> 
	function openLogin(){
		window.location.href="<?php echo site_url('Welcome/login');?>";	
	}

</script>