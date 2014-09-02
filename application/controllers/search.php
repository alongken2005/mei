<?php
/**
 * 搜索
 * @version 2013-11-10
 * @author ZhangHao
 */
 
class Search extends MY_Controller {
	private $_data;
	
    public function __construct() {
		parent::__construct();
		$this->load->model('base_mdl', 'base');
		//$this->output->enable_profiler(TRUE);
    }

	public function lists() {
		$this->_data['keyword'] = $keyword = $this->input->get('keyword');
		$more = $this->input->get('more');
		$page = intval($this->input->get('page')) ? intval($this->input->get('page')) : 1;
		$limit = 25;
		$offset = ($page-1)*$limit;

		
		if($more) {
			$this->_data['lists'] = $this->db->query("SELECT * FROM yos_book WHERE status=1 AND title LIKE '%".$keyword."%' OR author LIKE '%".$keyword."%' LIMIT 0, ".$limit)->result_array();
			echo $this->load->view(THEME.'/search_morelist', $this->_data, true);
			exit;
		} else {
			$this->_data['lists'] = $this->db->query("SELECT * FROM yos_book WHERE status=1 AND title LIKE '%".$keyword."%' OR author LIKE '%".$keyword."%' LIMIT ".$offset.", ".$limit)->result_array();
			$this->_data['page'] = $page;
			$this->load->view(THEME.'/search_list', $this->_data);
		}
	}

	public function clists() {
		$keyword = $this->input->get('keyword');
		$genre = intval($this->input->get('genre'));
		$type = $this->input->get('type');
		$more = $this->input->get('more');
		$page = intval($this->input->get_post('page')) ? intval($this->input->get_post('page')) : 1;
		$limit = 0;
		$offset = ($page-1)*$limit;

		if($type == 'mylist' && $this->member && $this->member['uid']) {
			$this->_data['genreName'] = 'My List';

			$favBookid = array();
			$where = '';

			$fav = $this->db->query('SELECT bid FROM yos_book_fav WHERE uid='.$this->member['uid'].' ORDER BY ctime DESC')->result_array();
			if($fav) {
				foreach($fav as $v) {
					$favBookid[] = $v['bid'];
				}
				$where = ' OR id IN('.implode(',', $favBookid).')';
			}

			$this->_data['lists'] = $this->db->query('SELECT * FROM yos_book WHERE status=1 AND uid='.$this->member['uid'].$where.' LIMIT '.$offset.', '.$limit)->result_array();			
			$this->_data['total'] = $this->db->query('SELECT * FROM yos_book WHERE status=1 AND uid='.$this->member['uid'].$where)->num_rows();			
		} else if($type == 'cread' && $this->member && $this->member['uid']) {
			$this->_data['genreName'] = 'Continue Reading for You';
			$this->_data['lists'] = $this->db->query('SELECT b.* FROM yos_history h LEFT JOIN yos_book b ON b.id=h.bid WHERE b.status=1 AND h.uid='.$this->member['uid'].' ORDER BY h.mtime DESC LIMIT '.$offset.', '.$limit)->result_array();
			$this->_data['total'] = $this->db->query('SELECT b.* FROM yos_history h LEFT JOIN yos_book b ON b.id=h.bid WHERE b.status=1 AND h.uid='.$this->member['uid'])->num_rows();
			
		} else if($type == 'popular') {
			$this->_data['genreName'] = 'Popular on YouShelf';
			$this->_data['total'] = $this->base->get_data('book', array('status'=>1))->num_rows();
			$this->_data['lists'] = $this->base->get_data('book', array('status'=>1), '*', $limit, $offset, 'hits DESC')->result_array();
		} else if($type == 'bestRated') {
			$this->_data['lists'] = $this->base->get_data('book', array('status'=>1), '*', $limit, $offset, 'score DESC, mtime DESC')->result_array();
			$this->_data['total'] = $this->base->get_data('book', array('status'=>1))->num_rows();
		} else if($type == 'tops') {
			$this->_data['genreName'] = 'Top Picks for You';
			$this->_data['lists'] = $this->base->get_data('book', array('status'=>1), '*', $limit, $offset, 'ctime DESC')->result_array();
			$this->_data['total'] = $this->base->get_data('book', array('status'=>1))->num_rows();
		} else if($genre) {
			$where = $genre ? 'WHERE genre='.$genre : '';
			$genres = $this->base->get_data('book_genre', array(), 'id, name')->result_array();
			foreach($genres as $v) {
				if($v['id'] == $genre) {
					$this->_data['genreName'] = $v['name'];
					break;
				}
			}

			$this->_data['lists'] = $this->db->query("SELECT * FROM yos_book ".$where." AND status=1 LIMIT ".$offset.", ".$limit)->result_array();
			$this->_data['total'] = $this->db->query("SELECT * FROM yos_book ".$where." AND status=1")->num_rows();

		} else if($keyword) {
			$this->_data['lists'] = $this->db->query("SELECT * FROM yos_book WHERE status=1 AND title LIKE '%".$keyword."%' OR author LIKE '%".$keyword."%' LIMIT ".$offset.", ".$limit)->result_array();
			$this->_data['total'] = $this->db->query("SELECT * FROM yos_book WHERE status=1 AND title LIKE '%".$keyword."%' OR author LIKE '%".$keyword."%' ")->num_rows();
		}

		$this->_data['page'] = $page;
		$this->_data['type'] = $type;
		$this->_data['genre'] = $genre;
		$this->_data['keyword'] = $keyword;
		if($more) {
			$this->load->view(THEME.'/search_morelist', $this->_data);
		} else {
			$this->load->view(THEME.'/search_list', $this->_data);			
		}
	}
}