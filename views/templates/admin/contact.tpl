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
<div class="margin-form"><select name="chronoparams[{$prefix|escape:'htmlall'}][civility]">
	<option value="M"{if $civility=='M'} selected{/if}>{l s='Mr.' mod='chronopost'}</option>
	<option value="E"{if $civility=='E'} selected{/if}>{l s='Mrs.' mod='chronopost'}</option>
	<option value="L"{if $civility=='L'} selected{/if}>{l s='Ms.' mod='chronopost'}</option>
</option></select></div>
<label>{l s='Company name' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "35" name="chronoparams[{$prefix|escape:'htmlall'}][name]" 
		value="{$name|escape:'htmlall'}"/>
</div>

<label>{l s='Company name 2' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "35" name="chronoparams[{$prefix|escape:'htmlall'}][name2]" 
		value="{$name2|escape:'htmlall'}"/>
</div>

<label>{l s='Address' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "35" name="chronoparams[{$prefix|escape:'htmlall'}][address]" 
		value="{$address|escape:'htmlall'}"/>
</div>

<label>{l s='Address 2' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "35" name="chronoparams[{$prefix|escape:'htmlall'}][address2]" 
		value="{$address2|escape:'htmlall'}"/>
</div>

<label>{l s='Zipcode' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "5" name="chronoparams[{$prefix|escape:'htmlall'}][zipcode]" 
		value="{$zipcode|escape:'htmlall'}"/>
</div>

<label>{l s='City' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "35" name="chronoparams[{$prefix|escape:'htmlall'}][city]" 
		value="{$city|escape:'htmlall'}"/>
</div>

<label>{l s='Contact name' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "35" name="chronoparams[{$prefix|escape:'htmlall'}][contactname]" 
		value="{$contactname|escape:'htmlall'}"/>
</div>

<label>{l s='Email' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "35" name="chronoparams[{$prefix|escape:'htmlall'}][email]" 
		value="{$email|escape:'htmlall'}"/>
</div>

<label>{l s='Phone number' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "10" name="chronoparams[{$prefix|escape:'htmlall'}][phone]" 
		value="{$phone|escape:'htmlall'}"/>
</div>

<label>{l s='Mobile phone number' mod='chronopost'}</label><div class="margin-form">
	<input type="text" maxlength = "10" name="chronoparams[{$prefix|escape:'htmlall'}][mobile]" 
		value="{$mobile|escape:'htmlall'}"/>
</div>
