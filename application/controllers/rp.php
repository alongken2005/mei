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

		$sites = $this->config->item('sites');
		foreach($sites as $k=>$v) {
			$imgArr = array();
			$ret = $this->base->get_data('pageUrl', array('siteId'=>$k, 'state'=>0))->result_array();
			foreach($ret as $row) {	
				$reg = "/<img src=\'(\/uploads\/allimg\/.*?\.jpg)\' id=\'bigimg\'/";

				$content = file_get_contents($row['pageUrl']);
				$pageUrl = pathinfo($row['pageUrl']);
				$url = parse_url($row['pageUrl']);
				$host = $url['scheme'].'://'.$url['host'].'/';
				
				//$reg = "/<div id=\"imgString\"><img src=\"(.*?\.jpg)\".*<div class=\"pagelist\">(.*?)<\/div>/";
				
				preg_match($reg, $content, $match);
				$imgArr[] = $host.$match[1];

				$regUrl = "/<li><a href=\'(\d{1,7}_\d{1,2}\.html)?\'>\d{1,2}<\/a><\/li>/";
				preg_match_all($regUrl, $content, $match2);
				if($match2) {
					foreach ($match2[1] as $value) {
						$url = $match3 = '';
						$content = file_get_contents($pageUrl['dirname'].'/'.$value);

						preg_match($reg, $content, $match3);
						//debug($match3);
						$imgArr[] = $host.$match3[1];							
					}
				}
				debug($imgArr);
				
			}
		}

	}

}