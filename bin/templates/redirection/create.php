<div class="row l1">
	<div class="span l1">

		<div class="row l4">
			<div class="span l3">
				<h2 style="padding: 0; margin: 0;" class="text:grey-300">Create an Email</h2>
			</div>
		</div>

		<div class="spacer small"></div>

		<div class="row l1 ">
			<div class="span l1">
				<div class="material">
					<form method="POST" action="">

						<div class="row l3">
							<div class="span l1">
								<label>Email</label>
								<input type="text" class="frm-ctrl" name="targets[0][email]" placeholder="Email">
							</div>
							<div class="span l1">
								<label>Since</label>
								<select class="frm-ctrl" name="targets[0][since]">
									<?php foreach (['Jetzt' => time(), 'In 20 Minuten' => time() + 1200] as $readable => $time) : ?>
										<option value="<?= $time ?>"><?= __($readable) ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="span l1">
								<label>To</label>
								<select class="frm-ctrl" name="targets[0][until]">
									<?php foreach (['In 20 Minuten' => time() + 1200, 'In 1 Jahr' => time() + 86400 * 365] as $readable => $time) : ?>
										<option value="<?= $time ?>"><?= __($readable) ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="spacer small"></div>

						<div class="row l3">
							<div class="span l1">
								<label>Email</label>
								<input type="text" class="frm-ctrl" name="targets[1][email]" placeholder="Email">
							</div>
							<div class="span l1">
								<label>Since</label>
								<select class="frm-ctrl" name="targets[1][since]">
									<?php foreach (['Jetzt' => time(), 'In 20 Minuten' => time() + 1200] as $readable => $time) : ?>
										<option value="<?= $time ?>"><?= __($readable) ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="span l1">
								<label>To</label>
								<select class="frm-ctrl" name="targets[1][until]">
									<?php foreach (['In 20 Minuten' => time() + 1200, 'In 1 Jahr' => time() + 86400 * 365] as $readable => $time) : ?>
										<option value="<?= $time ?>"><?= __($readable) ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<template data-lysine-view="email">
							<div>
								<div class="spacer small"></div>

								<div class="row l3">
									<div class="span l1">
										<label>Email</label>
										<input type="text" class="frm-ctrl" data-lysine-name="targets[{{id}}][email]" placeholder="Email">
									</div>
									<div class="span l1">
										<label>Since</label>
										<select class="frm-ctrl" data-lysine-name="targets[{{id}}][since]">
											<?php foreach (['Jetzt' => time(), 'In 20 Minuten' => time() + 1200] as $readable => $time) : ?>
												<option value="<?= $time ?>"><?= __($readable) ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="span l1">
										<label>To</label>
										<select class="frm-ctrl" data-lysine-name="targets[{{id}}][until]">
											<?php foreach (['In 20 Minuten' => time() + 1200, 'In 1 Jahr' => time() + 86400 * 365] as $readable => $time) : ?>
												<option value="<?= $time ?>"><?= __($readable) ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
						</template>

						<div class="spacer small"></div>

						<div class="align-center">
							<a id="btn-add-email" class="button outline small button-color-grey-300">Add an Email</a>
						</div>

						<div class="spacer small"></div>

						<div class="align-right">
							<button class="button" type="submit">Create</button>
						</div>

					</form>

				</div>
			</div>
		</div>

	</div>
</div>



<script lang="text/javascript">
	depend(['m3/core/lysine'], function(Lysine) {
		let counter = 2;
		document.getElementById('btn-add-email').addEventListener('click', function() {
			let v = new Lysine.view('email');
			v.setData({
				id: counter++
			});
		});
	});
</script>
