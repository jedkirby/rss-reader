<? if( ($status = \App\Core\Cookie::once('status')) ) : ?>
	<div class="alert alert-<?=$status?>">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<?=\App\Core\Cookie::once('message')?>
	</div>
<? endif; ?>
