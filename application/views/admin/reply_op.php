<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('admin/header');
?>
<h2><span class="spantitle"><?=intval($this->input->get('id')) ? '修改' : '添加'?></span><div class="operate"><a href="<?=site_url('admin/reply/lists?mid='.$row['mid'])?>">管理</a></div></h2>
<div class="slider3">
	<form action="<?=site_url('admin/reply/op'.(intval($this->input->get('id')) ? '?id='.intval($this->input->get('id')) : ''))?>" method="POST" enctype="multipart/form-data">
	<table cellspacing="0" cellpadding="0" border="0" class="table1">
		<tr>
			<th><b>*</b> 标题：</th>
			<td>
				<input type="text" name="title" value="<?=set_value('title', isset($row['title']) ? $row['title'] : '')?>" class="input2"/>
				<?php if(form_error('title')) { echo form_error('title'); } ?>
			</td>
		</tr>
		<tr>
			<th><b>*</b> 称呼：</th>
			<td>
				<input type="text" name="name" value="<?=set_value('name', isset($row['name']) ? $row['name'] : '')?>" class="input2"/>
				<?php if(form_error('name')) { echo form_error('name'); } ?>
			</td>
		</tr>
		<tr>
			<th><b>*</b> 内容：</th>
			<td>
				<textarea name="content" id="content"><?=set_value('content', isset($row['content']) ? $row['content'] : '')?></textarea>
				<?php if(form_error('content')) { echo form_error('content'); } ?>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="hidden" name="mid" value="<?=$row['mid']?>"/>
				<input type="submit" name="submit" value="提 交" class="but2"/>
			</td>
		</tr>
	</table>
	</form>
</div>


<script type="text/javascript" src="<?=base_url('./common/kindeditor/kindeditor.js')?>"></script>
<script type="text/javascript">
$(function() {
	KindEditor.ready(function(K) {
		K.create('#content', {width : '670', height: '500', newlineTag:'br', filterMode : true});
	});


	$('.del').click(function() {
		if(confirm('确定删除？')) {
			$.get($('.del').attr('href'), '', function(data) {
				if(data == 'ok') {
					$('.tr_icon').hide();
				} else {
					alert('删除失败');
				}
			})
		}
		return false;
	})
})
</script>

<?php $this->load->view('admin/footer');?>