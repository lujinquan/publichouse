<?php
/*
分页处理工具
*/

namespace util;

class PageTool{
	protected $total = 0;// 总条数
	protected $perpage = 5;// 每页条数
	protected $page = 1;// 当前页数

	public function __construct($total, $page=false, $perpage=false){
		$this->total = $total;
		if($perpage){
			$this->perpage = $perpage;
		}
		if($page){
			$this->page = $page;
		}
	}
	/*
	获取每页条数
	*/
	public function getPerpage(){
		return $this->perpage;
	}
	/*
	创建分页导航
	*/
	public function show(){
		$cnt = ceil($this->total / $this->perpage);// 总页数
		if($this->page == -1)
			$this->page = $cnt;

		// 计算页码导航
		$nav = array();
		$nav[0] = '<li class="am-active"><a href="javascript:void(0)">' . $this->page . '</a></li>';
		for($left = $this->page - 1, $right = $this->page + 1; ($left >= 1 || $right <= $cnt) && (count($nav) < 7);){
			if($left >= 1){
				array_unshift($nav, '<li><a class="page_notice_index upload_file_index" id="'. $left . '" href="javascript:void(0)">' . $left . '</a></li>');
				$left--;
			}
			if($right <= $cnt){
				array_push($nav, '<li><a class="page_notice_index upload_file_index" id="' . $right . '" href="javascript:void(0)">' . $right . '</a></li>');
				$right++;
			}
		}
		if($this->page == 1){
			array_unshift($nav, '<li class="am-disabled"><a class="page_notice_index upload_file_index" id="'. $this->page .'" href="javascript:void(0)">&laquo;</a></li>');
			// array_unshift($nav, '<li class="am-disabled"><a class="page_notice_index upload_file_index" id="'. 1 .'" href="javascript:void(0)">' . '首页' . '</a></li>');
		}
		if($this->page > 1){
			array_unshift($nav, '<li><a class="page_notice_index upload_file_index" id="'. ($this->page-1) .'" href="javascript:void(0)">&laquo;</a></li>');
			// array_unshift($nav, '<li><a class="page_notice_index upload_file_index" id="'. 1 .'" href="javascript:void(0)">' . '首页' . '</a></li>');
		}
		if($this->page == $cnt){
			array_push($nav, '<li class="am-disabled"><a class="page_notice_index upload_file_index" id="'. -1 .'" href="javascript:void(0)">&raquo;</a></li>');
			// array_push($nav, '<li class="am-disabled"><a class="page_notice_index upload_file_index" id="'. '-1' .'" href="javascript:void(0)">' . '尾页' . '</a></li>');
		}
		if($this->page < $cnt){
			array_push($nav, '<li><a class="page_notice_index upload_file_index" id="'. ($this->page+1) .'" href="javascript:void(0)">&raquo;</a></li>');
			// array_push($nav, '<li><a class="page_notice_index upload_file_index" id="'. '-1' .'" href="javascript:void(0)">' . '尾页' . '</a></li>');
		}
		return implode("", $nav);
	}

}

/*$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageTool = new PageTool(100, $page, 10);
echo '<style>.pageCode, .page_now, .page_left, .page_first, .page_right, .page_last{margin: 20px;font-size: 20pt;}</style>';
echo $pageTool->show();*/
?>