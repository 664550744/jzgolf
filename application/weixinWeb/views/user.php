	<style>
		#user_info_bg{
			background-image: url("/assets/wx/img/user_info_bg.png");
			height: 180px;
			-webkit-background-size: 100% 100%;
			background-size: 100% 100%;
			background-repeat: no-repeat;
			padding-top: 50px;
			text-align: center;
			color: #fff;
			font-size: 20px;
			font-weight: bold;
			line-height: 40px;
		}
		#photo{width: 80px;height: 80px;border-radius: 40px;display: block;margin:  auto ;border: 1px solid #ddd;}
	</style>
    <div class="g-scrollview">
    	<div id="user_info_bg">
    		<img id="photo" src="<?php echo $_SESSION['photo']; ?>" alt="">
    		<div><?php echo $_SESSION['alias']; ?>(ID:<?php echo $_SESSION['ID']; ?>)</div>
    	</div>
       
    </div>