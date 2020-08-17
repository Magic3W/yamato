<!doctype html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Yamato</title>
	<link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
	<link href="https://cdn.iconmonstr.com/1.3.0/css/iconmonstr-iconic-font.min.css" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="<?= asset('css/app.css') ?>">
	<meta name="_scss" content="<?= asset() ?>/css/_/js/">

	<script src="<?= asset('js/m3/depend.js') ?>" type="text/javascript"></script>
	<script src="<?= asset('js/m3/depend/router.js') ?>" type="text/javascript"></script>

	<script type="text/javascript">
		(function() {
			depend(['m3/depend/router'], function(router) {
				var _SCSS = document.querySelector('meta[name="_scss"]').getAttribute('content') || '/assets/css/_/js/';
				var assets = '<?= asset() ?>';

				router.all().to(function(e) {
					return assets + '/js/' + e + '.js';
				});
				router.equals('_scss').to(function() {
					return assets + '/css/_/js/_.scss.js';
				});


				router.startsWith('_scss/').to(function(str) {
					return _SCSS + str.substring(6) + '.js';
				});
			});
		}());
	</script>

	<?php if ($authUser) : ?>
		<style type="text/css">
			*[data-visibility] {
				display: none;
			}

			*[data-visibility="<?= $authUser->username ?>"] {
				display: inline-block;
			}
		</style>
	<?php endif; ?>

</head>

<body>
	<script>
		/*
		 * This little script prevents an annoying flickering effect when the layout
		 * is being composited. Basically, since we layout part of the page with JS,
		 * when the browser gets to the JS part it will discard everything it rendered
		 * to this point and reflow.
		 * 
		 * Since the reflow MUST happen in order to render the layout, we can tell 
		 * the browser to not render the layout at all. This will prevent the layout
		 * from shift around before the user had the opportunity to click on it.
		 * 
		 * If, for some reason the layout was unable to start up within 500ms, we 
		 * let the browser render the page. Risking that the browser may need to 
		 * reflow once the layout is ready
		 */
		(function() {
			return;
			document.body.style.display = 'none';
			document.addEventListener('DOMContentLoaded', function() {
				document.body.style.display = null;
			}, false);
			setTimeout(function() {
				document.body.style.display = null;
			}, 500);
		}());
	</script>

	<!--Top most navigation-->
	<div class="navbar">
		<div class="left">
			<span class="toggle-button dark"></span>
		</div>
		<div class="right">
			<?php if (isset($authUser) && $authUser) : ?>
				<div class="has-dropdown" style="display: inline-block">
					<a href="<?= url('user', $authUser->username) ?>" class="app-switcher" data-toggle="app-drawer">
						<span class="notification-indicator">
							<span class="badge" data-ping-counter="0">0</span>
							<img src="<?= $authUser->avatar ?>" width="32" height="32" style="border-radius: 50%; vertical-align: middle">
						</span>
					</a>
				</div>
			<?php else : ?>
				<a class="menu-item" href="<?= url('account', 'login') ?>">Login</a>
			<?php endif; ?>
		</div>
		<div class="center">
			<a href="<?= url() ?>">
				<img src="<?= asset('img/logo.png') ?>" height="32px">
				<span class="desktop-only" style="vertical-align: .4rem">Yamato</span>
			</a>
		</div>
	</div>

	<div class="auto-extend">

		<div class="content" data-sticky-context>
			<?= $this->content() ?>
			<div class="spacer medium"></div>
		</div>
	</div>

	<!--Sidebar -->
	<div class="contains-sidebar">
		<div class="sidebar">
			<div class="navbar">
				<div class="left">
					<a href="<?= url() ?>">
						<img src="<?= asset('img/logo.png') ?>" width="17" style="margin-right: 5px; vertical-align: -3px"> Yamato
					</a>
				</div>
			</div>

			<?php if (isset($authUser) && $authUser) : ?>
				<div class="menu-entry"><a href="<?= url('redirection', 'create') ?>">Create an Email</a></div>
				<div class="menu-entry"><a href="<?= url('redirection', 'index') ?>">Current Redirections</a></div>
				<div class="menu-title"> Account</div>
				<div class="menu-entry"><a href="<?= url('settings', 'display') ?>">Settings</a></div>
			<?php else : ?>
				<div class="menu-title"> Account</div>
				<div class="menu-entry"><a href="<?= url('account', 'login') ?>">Login</a></div>
			<?php endif; ?>

			<div class="spacer" style="height: 10px"></div>

			<div class="menu-title">Our network</div>
			<div id="appdrawer"></div>
		</div>
	</div>

	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function() {
			var ae = document.querySelector('.auto-extend');
			var wh = window.innerheight || document.documentElement.clientHeight;
			var dh = document.body.clientHeight;

			ae.style.minHeight = Math.max(ae.clientHeight + (wh - dh), 0) + 'px';
		});
	</script>
	<script type="text/javascript">
		(function() {
			depend(['ui/dropdown'], function(dropdown) {
				dropdown('.app-switcher');
			});

			depend(['_scss'], function() {
				console.log('Loaded _scss');
			});
		}());
	</script>

	<script type="text/javascript">
		depend(['/m3/ui/sticky'], function(sticky) {

			/*
			 * Create elements for all the elements defined via HTML
			 */
			var els = document.querySelectorAll('*[data-sticky]');

			for (var i = 0; i < els.length; i++) {
				sticky.stick(els[i], sticky.context(els[i]), els[i].getAttribute('data-sticky'));
			}
		});
	</script>

	<script type="text/javascript">
		/*
		 * Load the applications into the sidebar
		 */
		depend(['m3/core/request'], function(Request) {
			var request = new Request('<?= $sso->getEndpoint() ?>/appdrawer.json');
			request
				.then(JSON.parse)
				.then(function(e) {
					e.forEach(function(i) {
						console.log(i)
						var entry = document.createElement('div');
						var link = entry.appendChild(document.createElement('a'));
						var icon = link.appendChild(document.createElement('img'));
						entry.className = 'menu-entry';

						link.href = i.url;
						link.appendChild(document.createTextNode(i.name));

						icon.src = i.icon.m;
						document.getElementById('appdrawer').appendChild(entry);
					});
				})
				.catch(console.log);
		});
	</script>
</body>

</html>
