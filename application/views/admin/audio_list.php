<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('admin/header');
?>
<table cellpadding="0" cellspacing="0" border="0" class="table2">
	<tr>
		<th width="150">文件名</th>
		<th>添加时间</th>
		<th width="150">操作</th>
	</tr>
<?php if($lists): foreach($lists as $v):?>
	<tr>
		<td><?=$v['filename']?></td>
		<td><?=date('Y-m-d H:i', $v['ctime'])?></td>
		<td>
			<a href="<?=site_url('admin/book/audiodown?id='.$v['id'])?>">下载</a>
		</td>
	</tr>
<?php endforeach; endif;?>
</table>

<?php $this->load->view('admin/footer');?>