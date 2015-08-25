<? $error = (bool) array_key_exists($field, $errors); ?>
<div class="form-group <?=( $error ? 'has-error' : '')?>">
	<label for="<?=$field?>" class="col-sm-2 control-label"><?=ucwords($field)?></label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="<?=$field?>" name="<?=$field?>" value="<?=$value?>">
		<? if( $error ) : ?>
			<span class="help-block validation__error"><?=reset($errors[$field])?></span>
		<? endif; ?>
	</div>
</div>
