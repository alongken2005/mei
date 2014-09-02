<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('admin/header');
?>
<h2><span class="spantitle">管理员</span><div class="operate"><!--a href="<?=site_url('admin/account/op')?>">添加</a--></div></h2>
<form action="<?=site_url('admin/account/lists')?>" method="get" style="margin: 3px 5px;">
	身份：<select name="is_author">
		<option value="">全部</option>
		<option value="1" <?=$this->input->get('is_author')==1 ? 'selected' : ''?>>作家</option>
		<option value="2" <?=$this->input->get('is_author')==2 ? 'selected' : ''?>>普通用户</option>
	</select>
	<input type="submit" value="提交"/>
</form>
<table cellpadding="0" cellspacing="0" border="0" class="table2">
	<tr>
		<th>用户名</th>
		<th>登陆名</th>
		<th>邮箱</th>
		<th>身份</th>
		<th width="150">创建日期</th>
	</tr>
<?php foreach($lists as $v):?>
	<tr>
		<td><a href="<?=site_url('admin/account/detail?uid='.$v['uid'])?>"><?=$v['username']?></a></td>
		<td><?=$v['loginname']?></td>
		<td><?=$v['email']?></td>
		<td><?=($v['is_author'] == 1 ? '作家' : '')?></td>
		<td><?=date('Y-m-d H:i', $v['ctime'])?></td>
	</tr>
<?php endforeach;?>
</table>
<?=$pagination?>
<script type="text/javascript">
$(function() {
	$('.del').click(function() {
		if(confirm('确认删除？')){
			var po = $(this).parent().parent();
			$.get($(this).attr('href'), '', function(data) {
				if(data == 'ok'){
					po.hide();
				} else {
					alert('删除失败！');
				}
			})
		}
		return false;
	})
})
</script>
<?php $this->load->view('admin/footer');?>