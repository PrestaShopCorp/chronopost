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
 <select name="chronoparams[saturday][{$field_name|escape:'htmlall'}]">
	{for $i=0 to 23}
		<option value="{$i|escape:'htmlall'}"{if $i==$selected} selected{/if}>{$i|string_format:'%02d'}</option>
	{/for}
</select>