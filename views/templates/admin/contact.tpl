{*
  * MODULE PRESTASHOP OFFICIEL CHRONOPOST
  * 
  * LICENSE : All rights reserved - COPY AND REDISTRIBUTION FORBIDDEN WITHOUT PRIOR CONSENT FROM OXILEO
  * LICENCE : Tous droits réservés, le droit d'auteur s'applique - COPIE ET REDISTRIBUTION INTERDITES SANS ACCORD EXPRES D'OXILEO
  *
  * @author    Oxileo SAS <contact@oxileo.eu>
  * @copyright 2001-2015 Oxileo SAS
  * @license   Proprietary - no redistribution without authorization
  *}
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
