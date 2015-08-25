<?=\App\Core\View::make('include.header')->with(compact('title'))->with('feeds', [])->render()?>

	<div class="row site__panel">
		<div class="col-md-6 col-md-offset-3">

			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title">Oops! Look's like something's not right..</h3>
				</div>
				<div class="panel-body">
					<?=$message?>
				</div>
			</div>

		</div>
	</div>

<?=\App\Core\View::make('include.footer')->render()?>
