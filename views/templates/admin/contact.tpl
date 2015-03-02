<label>{l s='Title' mod='chronopost'}</label>
<div class="margin-form"><select name="chronoparams[{$prefix}][civility]">
	<option value="M"{if $civility=='M'} selected{/if}>{l s='Mr.' mod='chronopost'}</option>
	<option value="E"{if $civility=='E'} selected{/if}>{l s='Mrs.' mod='chronopost'}</option>
	<option value="L"{if $civility=='L'} selected{/if}>{l s='Ms.' mod='chronopost'}</option>
</option></select></div>
<label>{l s='Company name' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "35" name="chronoparams[{$prefix}][name]" 
		value="{$name}"/>
</div>

<label>{l s='Company name 2' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "35" name="chronoparams[{$prefix}][name2]" 
		value="{$name2}"/>
</div>

<label>{l s='Address' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "35" name="chronoparams[{$prefix}][address]" 
		value="{$address}"/>
</div>

<label>{l s='Address 2' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "35" name="chronoparams[{$prefix}][address2]" 
		value="{$address2}"/>
</div>

<label>{l s='Zipcode' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "5" name="chronoparams[{$prefix}][zipcode]" 
		value="{$zipcode}"/>
</div>

<label>{l s='City' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "35" name="chronoparams[{$prefix}][city]" 
		value="{$city}"/>
</div>

<label>{l s='Contact name' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "35" name="chronoparams[{$prefix}][contactname]" 
		value="{$contactname}"/>
</div>

<label>{l s='Email' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "35" name="chronoparams[{$prefix}][email]" 
		value="{$email}"/>
</div>

<label>{l s='Phone number' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "10" name="chronoparams[{$prefix}][phone]" 
		value="{$phone}"/>
</div>

<label>{l s='Mobile phone number' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "10" name="chronoparams[{$prefix}][mobile]" 
		value="{$mobile}"/>
</div>
