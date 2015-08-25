<?=\App\Core\View::make('include.header')->with(compact('title', 'feeds'))->render()?>

	<div class="row site__panel">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title"><?=$title?></h3>
				</div>
				<div class="panel-body">

					<div class="row">
						<div class="col-md-10 col-md-offset-1">
						
							<form method="post" class="form-horizontal site__form">

								<div class="form-group">
									<div class="col-md-10">
										<p>
											Are you sure you want to remove the feed <strong><?=$feed->name?></strong>
										</p>
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-10">
										<button type="submit" class="btn btn-sm btn-danger">Remove</button>
										<a href="/" class="btn btn-sm btn-link">Cancel</a>
									</div>
								</div>

							</form>

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

<?=\App\Core\View::make('include.footer')->render()?>
