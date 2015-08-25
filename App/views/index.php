<?=\App\Core\View::make('include.header')->with(compact('title', 'feeds'))->render()?>

	<div class="row site__panel">
		<div class="col-md-4 col-md-offset-4">

			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Select Feed</h3>
				</div>
				<div class="panel-body">

					<div class="list-group  feed__list">
						<? if( $feeds ) : ?>
							<? foreach($feeds as $feed) : ?>
								<a href="/feed?id=<?=$feed->id?>" class="list-group-item"><?=$feed->name?></a>
							<? endforeach; ?>
						<? else : ?>
							<a href="/feed/add" class="list-group-item">Add Feed</a>
						<? endif; ?>
					</div>

				</div>
			</div>

		</div>
	</div>

<?=\App\Core\View::make('include.footer')->render()?>
