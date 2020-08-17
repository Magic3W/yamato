<div class="row l1">
	<div class="span l1">

		<div class="row l4">
			<div class="span l3">
				<h2 style="padding: 0; margin: 0;" class="text:grey-300">Current Redirections</h2>
			</div>
		</div>

		<div class="spacer small"></div>

		<div class="row l5">
			<div class="span l3" style="padding-left: 2rem;">EMail (Alias)</div>
			<div class="span l1 align-center">Recipients</div>
			<div class="span l1 align-right" style="padding-right: 2rem;">Options</div>
		</div>

		<?php foreach ($redirections as $redirect) : ?>
			<div class="row l1 ">
				<div class="span l1">
					<div class="material">
						<div class="row l5">
							<div class="span l3">
								<?= __($redirect->alias) ?>
							</div>

							<div class="span l1 align-center">
								<?= __($redirect->targets->getQuery()->count()) ?>
							</div>

							<div class="span l1 align-right">
								<a class="button small" href="<?= url('redirection', 'show', $redirect->_id) ?>">Show</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="spacer small"></div>
		<?php endforeach; ?>

	</div>
</div>
