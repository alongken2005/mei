<?php $this->load->view(THEME.'/header');?>
<link rel="stylesheet" type="text/css" href="<?=THEME_VIEW?>css/space.css"/>

<div class="box1000">
	<?=$slider_left?>

	<div class="space_box">
		<div class="leader">Author Dashboard > Manage Books</div>
		<a href="<?=site_url('book/edit')?>" class="btn1" style="float:left;margin-right:24px;">Add New Book</a>
		<div class="clear"></div>
		<div class="h">
			<h3>Book Activity (<?=count($books)?> Total)</h3>
			<a href="<?=site_url('book/lists?view=grid')?>" class="viewgrid"></a>
			<a href="<?=site_url('book/lists?view=list')?>" class="viewlist"></a>
		</div>
	<?php if($view == 'grid'):?>
		<ul class="grid">
		<?php foreach($books as $v):?>
			<li>
				<a href="<?=site_url('book/edit?id='.$v['id'])?>"><img src="data/books/<?=$v['cover']?>"/></a>
				<div><a href="<?=site_url('book/edit?id='.$v['id'])?>"><?=$v['title']?></a></div>
			</li>
		<?php endforeach;?>
		</ul>
	<?php elseif($view == 'list'):?>
		<table cellpadding="0" cellspacing="0" class="book_list_table">
			<tr>
				<th>Book Title</th>
				<th width="130">Last Modified</th>
				<th width="80">Status</th>
			</tr>
		<?php foreach($books as $v):?>
			<tr>
				<td><a href="<?=site_url('book/edit?id='.$v['id'])?>"><?=$v['title']?></a></td>
				<td><?=date('Y-m-d H:i', $v['mtime'])?></td>
				<td>
					<input type="hidden" name="bid" class="bid" value="<?=$v['id']?>"/>
				<?php 
					if($v['status'] == 2) {
						echo 'Suspended';
					} else if($v['status'] == 3) {
						echo 'Processing';
					} else {
				?>
					<select name="status" class="changeStatus">
						<option value="0">Pending</option>
						<?php if($v['status'] == 1) { ?>
						<option value="1" selected>Active</option>
						<?php } else { ?>
						<option value="1">Active</option>
						<?php } ?>					
					</select>
				<?php		
					}
				?>
				</td>
			</tr>
		<?php endforeach;?>
		</table>
		<div style="padding:5px; margin-top:10px; color:#666">Please contact <a href="mailto:author-support@youshelf.com" target="_blank" style="color:#0098CA">author-support@youshelf.com</a> for any requests or questions.</div>
	<?php endif;?>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		$('.changeStatus').change(function() {
			var bid = $(this).prev().val();
			var status = $(this).val();
			$.post("<?=site_url('book/editStatus')?>", {bid:bid, status:status}, function(data) {
				alert(data.msg); 
			}, 'json');			
		});
	});
</script>
<?php $this->load->view(THEME.'/footer');?>