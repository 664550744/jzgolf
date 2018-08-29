<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

	
	
	/**
	 * 商品分类
	 *
	 */
	public function category()
	{
		
		$this->load->library('fun');
	
		$this->load->model('Category_model');
		$result = $this->Category_model->get_data();
		$data=array();
		foreach ($result as $row)
		{
			$data[]=array('id'=>$row->id,'pid'=>$row->pid,'text'=>$row->text,'order'=>$row->order,'state'=>$row->state);
		}
		
		$data = $this->fun->tree($data);
		$result = array();
		$result[]=array('id'=>0,'text'=>"顶级分类");
		for($i=0;$i<count($data);$i++){
			$mum=0;
			if(isset($data[$i]['children'])){
				$mum=count($data[$i]['children']);
			}
			$result[]=array('id'=>$data[$i]['id'],'text'=>$data[$i]['text']);
			if(isset($data[$i]['children'])){
				for($j=0;$j<count($data[$i]['children']);$j++){
					$mum=0;
					if(isset($data[$i]['children'][$j]['children'])){
						$mum=count($data[$i]['children'][$j]['children']);
					}
					$result[]=array('id'=>$data[$i]['children'][$j]['id'],'text'=>$data[$i]['text']." -> ".$data[$i]['children'][$j]['text']);
					if(isset($data[$i]['children'][$j]['children'])){
						for($k=0;$k<count($data[$i]['children'][$j]['children']);$k++){
							$result[]=array('id'=>$data[$i]['children'][$j]['children'][$k]['id'],'text'=>$data[$i]['text']." -> ".$data[$i]['children'][$j]['text']." -> ".$data[$i]['children'][$j]['children'][$k]['text']);
						}
					}
				}
			}
			
		}
		print_r(json_encode(array('code'=>1,'data'=>$result)));
	}
	
	
}
