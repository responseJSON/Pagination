<?php
class Pagination {

	/*
	 * Set varibale
	 */
	private $url = null;
	private $page = 1;
	private $perpage = 10;
	private $prev = 1;
	private $next = 2;
	private $total_record = 0;
	private $response = null;
	private $html = null;

	/*
	 * Set properties for create class
	 */
	public function __construct($datas = array()) {
		$this->url = isset($datas['url']) ? $datas['url'] : $this->url;
		$this->page = isset($datas['page']) ? (int) $datas['page'] : $this->page;
		$this->perpage = isset($datas['perpage']) ? (int) $datas['perpage'] : $this->perpage;
		$this->total_record = isset($datas['total_record']) ? (int) $datas['total_record'] : $this->total_record;
		$this->prev = isset($datas['prev']) ? (int) $datas['prev'] : $this->prev;
		$this->next = isset($datas['next']) ? (int) $datas['next'] : $this->next;
	}

	/*
	 * Set get pagination
	 */
	public function get() {
		$this->html = null;

		if ($this->total_page() > 1) {
			$this->html .= '<ul class="pagination pagination-sm custom-pagination">';

			if(($this->page > $this->prev) + 1) {
				$this->html .= '<li><a href="'.$this->url.'?page=1'.$this->parameters().'"><i class="fa fa-angle-double-left"></i></a></li>';
				$this->html .= '<li><a href="'.$this->url.'?page='.($this->page - 1).$this->parameters().'"><i class="fa fa-angle-left"></i></a>';
			}

			for($i=$this->start(); $i<=$this->display(); $i++){
				if($i == (int) $this->page){
					$this->html .= '<li class="active"><a href="#'.$i.'/">'.$i.'</a></li>';
				}else{
					$this->html .= '<li><a href="'.$this->url.'?page='.$i.$this->parameters().'">'.$i.'</a></li>';
				}
			}

			if($this->total_page() > $this->display()){
				$this->html .= '<li><a href="'.$this->url.'?page='.((int) $this->page + 1).$this->parameters().'"><i class="fa fa-angle-right"></i></a></li>';
				$this->html .= '<li><a href="'.$this->url.'?page='.$this->total_page().$this->parameters().'"><i class="fa fa-angle-double-right"></i></a></li>';
			}

			$this->html .= '</ul>';
		}

		return $this->html;
	}

	/*
	 * Set page active
	 */
	public function page_active() {
		return $this->page;
	}

	/*
	 * Set total page
	 */
	public function total_page() {
		return ceil((int) $this->total_record / (int) $this->perpage);
	}

	/*
	 * Set start page
	 */
	private function start() {
		return ((int) $this->page - (int) $this->prev) < 1 ? 1 : (int) $this->page - (int) $this->prev;
	}

	/*
	 * Set display page
	 */
	private function display() {
		$this->response = null;
		$this->response = $this->start() + (int) $this->prev + (int) $this->next;

		if($this->response > $this->total_page()) {
			$this->response = $this->total_page();
		}

		return $this->response;
	}

	/*
	 * Set parameters in url
	 */
	private function parameters() {
		$this->response = null;

		if (isset($_GET)) {
			foreach ($_GET as $key=>$val) {
				if ($key != 'page') {
					$this->response .= '&amp;'.$key.'='.$val;
				}
			}
		}

		return $this->response;
	}
}
