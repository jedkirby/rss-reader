<html>
	<head>
		<title><?=$title?> :: RSS Feeder</title>
		<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="/assets/css/main.css">
		<script src="/assets/js/jquery-2.1.3.min.js"></script>
		<script src="/assets/js/bootstrap.min.js"></script>
	</head>
	<body>

		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">

				<div class="navbar-header">
					<a class="navbar-brand" href="/">RSS Feeder</a>
				</div>

				<div class="navbar-right">

					<div class="btn-group btn-group-sm nav__controls">
						<? if( $feeds ) : ?>
							<div class="btn-group btn-group-sm">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									Feeds
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<? foreach($feeds as $feed) : ?>
										<li><a href="/feed?id=<?=$feed->id?>"><?=$feed->name?></a></li>
									<? endforeach; ?>
								</ul>
							</div>
						<? endif; ?>
						<a href="/feed/add" class="btn btn-primary">Add</a>
					</div>

				</div>

			</div>
		</nav>

		<div class="container site">

			<?=\App\Core\View::make('include.messages')->render()?>

