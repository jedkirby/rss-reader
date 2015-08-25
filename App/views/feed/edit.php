<?=\App\Core\View::make('include.header')->with(compact('title', 'feeds'))->render()?>

	<div class="row site__panel">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><?=$title?></h3>
				</div>
				<div class="panel-body">

					<div class="row">
						<div class="col-md-10 col-md-offset-1">
						
							<form method="post" class="form-horizontal site__form">

								<?=\App\Core\View::make('feed.include.field')->with(compact('errors'))->with(['field' => 'name', 'value' => $name])->render()?>
								<?=\App\Core\View::make('feed.include.field')->with(compact('errors'))->with(['field' => 'url', 'value' => $url])->render()?>

								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-sm btn-primary">Save</button>
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
