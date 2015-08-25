<?=\App\Core\View::make('include.header')->with(compact('title', 'feeds'))->render()?>

	<div class="row site__panel">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<div class="pull-left">
						<h3 class="panel-title"><?=$feed->name?></h3>
					</div>
					<div class="pull-right">
						<div class="btn-group btn-group-xs">
							<a href="/feed/edit?id=<?=$feed->id?>" class="btn btn-default">Edit</a>
							<a href="/feed/remove?id=<?=$feed->id?>" class="btn btn-default">Remove</a>
						</div>
					</div>
				</div>
				<div class="panel-body">

					<? if( !empty($feeder->items()) ) : ?>

						<div class="panel-group feed__list" id="feeds">

							<? $i = 0; ?>
							<? foreach($feeder->items() as $entry) : ?>

								<? $id = 'feed-'.$i; ?>

								<div class="panel panel-default">
									<div class="panel-heading" role="tab">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#feeds" href="#<?=$id?>">
												<?=htmlentities($entry->title)?>
											</a>
										</h4>
									</div>
									<div id="<?=$id?>" class="panel-collapse collapse <?=( $i === 0 ? 'in' : '' )?>" role="tabpanel">
										<div class="panel-body">
											<p><?=strip_tags($entry->description)?></p>
											<p>
												<a href="<?=$entry->link?>" target="_blank">Read More &raquo;</a>
											</p>
										</div>
									</div>
								</div>

								<? $i++; ?>

							<? endforeach; ?>

						</div>

					<? else : ?>

						<p>Unable to load feed contents.</p>

					<? endif; ?>

				</div>

			</div>
		</div>
	</div>

<?=\App\Core\View::make('include.footer')->render()?>
