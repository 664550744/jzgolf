<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fun {

    public function tree($tree, $rootId = 0)
    {
		$return = array(); 
	  foreach($tree as $leaf) { 
		if($leaf['pid'] == $rootId) { 
		  foreach($tree as $subleaf) { 
			if($subleaf['pid'] == $leaf['id']) { 
			  $leaf['children'] = $this->tree($tree, $leaf['id']); 
			  break; 
			} 
		  } 
		  $return[] = $leaf; 
		} 
	  } 
	  return $return; 
    }

    /*
	* array unique_rand( int $min, int $max, int $num )
	* 生成一定数量的不重复随机数
	* $min 和 $max: 指定随机数的范围
	* $num: 指定生成数量
	*/
	function unique_rand($min, $max, $num) {
		//初始化变量为0
		$count = 0;
			//建一个新数组
		$return = array();
			while ($count < $num) {
			//在一定范围内随机生成一个数放入数组中
		$return[] = mt_rand($min, $max);
			//去除数组中的重复值用了“翻翻法”，就是用array_flip()把数组的key和value交换两次。这种做法比用 array_unique() 快得多。
		$return = array_flip(array_flip($return));
			//将数组的数量存入变量count中
		$count = count($return);
			}
			//为数组赋予新的键名
		shuffle($return);
			return $return;
	}

	/**
	* 生成缩略图
	* @param  $path 原图的本地路径
	* @return null 创建一个 原图_thumb.扩展名 的文件
	*
	*/

	public function dealthumb($path){
	    $config['image_library'] = 'gd2';
	    $config['source_image'] = $path;
	    $config['create_thumb'] = TRUE;
	    //生成的缩略图将在保持纵横比例 在宽度和高度上接近所设定的width和height
	    $config['maintain_ratio'] = TRUE;
	    $config['width'] = 80;
	    $config['height'] = 80;
	    $this->load->library('image_lib', $config);
	    $this->image_lib->resize();
	    $this->image_lib->clear();
	}
	
	
}