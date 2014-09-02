<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 用户
 * @version 1.0.0 12-10-22 下午9:31
 * @author 张浩
 */

class Rp extends CI_Controller {
	private $_data;

	public function __construct() {
		parent::__construct();
		$this->load->model('base_mdl', 'base');
	}

	/**
	 * 默认方法
	 */
	public function index() {
		$furl = "http://www.juemei.cc/html/list/PiaCdJCbHHaammbaC.html";
		$e = file_get_contents($furl);
		$sites = $this->config->item('sites');
		foreach($sites as $k=>$v) {
			$imgArr = array();
			$ret = $this->base->get_data('pageUrl', array('siteId'=>$k, 'state'=>0))->result_array();
			foreach($ret as $row) {
				$content = file_get_contents($row['pageUrl']);
				$reg = "/<div id=\"viewimgbox\"><img src=\"(.*?)\".*<div class=\"showpage\">(.*?)<\/div>/";
				//$reg = "/<div id=\"viewimgbox\"><img src=\"(.*?)\".*<div class=\"showpage\"><a href=\"([^<>]+)\">上一组<\/a><em>1<\/em><href=\"(.*?)\">\d{1,2}<\/a>/";
				preg_match($reg, $content, $match);
				$imgArr[] = $match[1];

				if(isset($match[2])) {
					$reg = "/<a href=\'.*?\'>(\d{1,2})<\/a>/";
					preg_match_all($reg, $match[2], $match2);
					
					if($match2) {
						foreach ($match2 as $value) {
							
						}
					}
				}
				debug($match);
			}
		}


	}

}