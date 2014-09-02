<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('admin/header');
?>
<h2><span class="spantitle">用户管理</span><div class="operate"><a href="<?=site_url('admin/account/lists')?>">管理</a></div></h2>
<form method="POST" action="<?=site_url('admin/adminer/adminer_op'.($this->input->get('uid') ? '?uid='.$this->input->get('uid') : ''))?>">
	<table cellpadding="0" cellspacing="0" border="0" class="table3">
		<tr>
			<th width="120">用户名</th>
			<td width="400"><?=$user['username']?></td>
			<th width="120">电子邮箱</th>
			<td><?=$user['email']?></td>
		</tr>
		<tr>
			<th>帐户创建日期</th>
			<td><?=date('Y-m-d H:i:s', $user['ctime'])?></td>
			<th>最近访问日期</th>
			<td></td>
		</tr>
		<tr>
			<th>帐户余额</th>
			<td>$<?=$user['deposit']?></td>
			<th>身份</th>
			<td><?=$user['is_author'] == 1 ? '作家' : '读者'?></td>
		</tr>
		<?php if($user['is_author'] == 1) { ?>
		<tr>
			<th>邮寄地址</th>
			<td colspan="3"><?=$user['country'].','.$user['state'].','.$user['city'].','.$user['street'],','.$user['organization'].','.$user['zipcode']?></td>
		</tr>		
		<?php } ?>
		<tr>
			<td colspan="4"><h3>充值记录</h3></td>
		</tr>
		<?php if(isset($paylist) && $paylist) { ?>
		<tr>
			<td colspan="4">
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
						<td>订单号</td>
						<td>金额</td>
						<td>订单状态</td>
						<td>支付时间</td>
					</tr>				
				<?php foreach($paylist as $v) { ?>
					<tr>
						<td><?=$v['orderID']?></td>
						<td><?=$v['price']?></td>
						<td><?=$v['status'] == 0 ? '未支付' : '支付成功'?></td>
						<td><?=$v['paytime']?></td>
					</tr>
				<?php } ?>
				</table>
			</td>
		</tr>
		<?php } else { ?>
		<tr>
			<td colspan="4">暂无充值记录</td>
		</tr>		
		<?php } ?>

		<tr>
			<td colspan="4"><h3>付款工具</h3></td>
		</tr>
		<?php if(isset($readerCard) && $readerCard) { ?>
		<tr>
			<td colspan="4">
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
						<td>信用卡卡号</td>
						<td>信用卡过期时间</td>
						<td>持卡人姓名</td>
					</tr>				
				<?php foreach($readerCard as $v) { ?>
					<tr>
						<td class="cnum"><?=substr($v['cardinfo']['card_num'], 0, 4).'*'?><a href="<?=site_url('admin/account/creditCardNum?id='.$v['id'])?>" class="cnumView">&nbsp;&nbsp;查看完整卡号</a></td>
						<td><?=$v['cardinfo']['exp_date']?></td>
						<td><?=$v['cardinfo']['holder_first_name'].'.'.$v['cardinfo']['holder_last_name']?></td>
					</tr>
				<?php } ?>
				</table>
			</td>
		</tr>
		<?php } else { ?>
		<tr>
			<td colspan="4">暂无付款工具</td>
		</tr>		
		<?php } ?>

		<?php if($user['is_author'] == 1) { ?>
		<tr>
			<td colspan="4"><h3>银行信息</h3></td>
		</tr>
		<?php if(isset($authorCard) && $authorCard) { ?>
		<tr>
			<td colspan="4">
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
						<td>银行名称</td>
						<td>银行地址</td>
						<td>帐户名称</td>
						<td>帐户号Account Number</td>
						<td>帐户Routing Number</td>
					</tr>				
				<?php foreach($authorCard as $v) { ?>
					<tr>
						<td><?=$v['cardinfo']['bank_name']?></td>
						<td><?=$v['cardinfo']['bank_street']?></td>
						<td><?=$v['cardinfo']['owner_name']?></td>
						<td><?=substr($v['cardinfo']['bank_account'], 0, 4).'*'?><a href="<?=site_url('admin/account/cardNum?id='.$v['id'])?>" class="cnumView">&nbsp;&nbsp;查看完整卡号</a></td>
						<td><?=$v['cardinfo']['bank_routing']?></td>
					</tr>
				<?php } ?>
				</table>
			</td>
		</tr>
		<?php } else { ?>
		<tr>
			<td colspan="4">暂无银行信息</td>
		</tr>		
		<?php } ?>	

		<tr>
			<td colspan="4"><h3>以往汇款记录</h3></td>
		</tr>	
		<tr>
			<td colspan="4">暂无汇款记录</td>
		</tr>			
		<?php } ?>					
	</table>
</form>
<script type="text/javascript">
	$(function() {
		$('.cnumView').click(function() {
			var cnum = $(this);
			$.get($(this).attr('href'), '', function(data) {
				cnum.parent().html(data);
			});
			return false;
		});
	});
</script>
<?php $this->load->view('admin/footer');?>