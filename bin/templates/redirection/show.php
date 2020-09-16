<div class="row l1">
	<div class="span l1">

		<div class="row l4">
			<div class="span l3">
				<h2 style="padding: 0; margin: 0;" class="text:grey-300">Redirection - Details</h2>
			</div>
		</div>

		<div class="spacer small"></div>

		<div class="row l1">
			<div class="span l1">
				<div class="material">
					<div class="row l2">
						<div class="span l1"><b>Alias:</b></div>
						<div class="span l1 align-right">
							<input type="text" id="email" value="<?= __($redirection->alias) ?>" style="border: none; appearance: none; width: calc(100% - 120px); text-align: right; outline: none; box-shadow: none">
							<button class="button small" id="copy-to-clipboard" style="width: 80px">Copy</button>
						</div>
					</div>

					<div class="spacer small"></div>

					<h3>Recipients</h3>

					<?php foreach ($redirection->targets as $target) : ?>
						<div class="row l4">
							<div class="span l2">
								<?= __(substr($target->to, 0, 6)) . str_repeat('*', strlen($target->to) - 12) . __(substr($target->to, -6)) ?>
							</div>
							<div class="span l1">
								<?= date('Y-m-d - H:i', $target->since) ?>
							</div>
							<div class="span l1 align-right">
								<?= date('Y-m-d - H:i', $target->until) ?>
							</div>
						</div>

						<div class="spacer small"></div>
					<?php endforeach; ?>
				</div>

				<div class="spacer medium"></div>

				<div class="align-center">
					<a class="button outline button-color-grey-300" href="<?= url('redirection', 'index') ?>">Back</a>
				</div>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript">
(function () {
	var btn = document.getElementById('copy-to-clipboard');
	var email = document.getElementById('email');

	function copy () {
		email.select();
		document.execCommand('copy');

		btn.innerHTML = 'Copied!';
		setTimeout(function () { btn.innerHTML = 'Copy'; }, 600);
	};

	function open () {
		window.location = 'mailto:<?= __($redirection->alias) ?>';
	}

	btn.addEventListener('click', copy);
	email.addEventListener('click', copy);
}());
</script>
