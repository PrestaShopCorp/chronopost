<div class="form-group">
	<label class="control-label col-lg-3">Carrier for {$code}</label>
	<div class="col-lg-9">
		<select name="chronoparams[{$code}][id]">
			<option value="-1">{l s='Do not activate' mod='chronopost'}</option>

			{foreach from=$carriers item=carrier}
				<option value="{$carrier.id_carrier}"{if $selected==$carrier.id_carrier} selected{/if}>{$carrier.name}</option>
			{/foreach}
		</select>
	</div>
</div>
<div class="form-group">
	<div class="col-lg-3">
	</div>
	<div class="col-lg-9 text-right">
		<button class="createCarrier btn btn-default" value="{$code}"><i class="icon-plus"></i> {l s='Create new carrier'}</button>
	</div>
</div>