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
<br /><fieldset style = "width:400px;"><legend><img src="../img/admin/delivery.gif"/>
{l s='Print the Chronopost waybills' mod='chronopost'}
</legend><form method="POST" action="{$module_uri|escape:'htmlall'}/postSkybill.php">
{if $bal==1}
	<p style = "text-align:center;width:400px"><b>Option BAL activée.</b></p>
{/if}

{if $saturday==1}
	<label>{l s='Saturday delivery option' mod='chronopost'}</label>
		<div class="margin-form"><input type="checkbox" name="shipSaturday" value="yes" {if $saturday_ok==1} checked{/if}/>
	</div>
{/if}

<label>{l s='Number of parcels' mod='chronopost'}</label>
<div class="margin-form"><input type="text" name="multiOne" id = "multiOne" value="{$nbwb|escape:'htmlall'}"/></div>
{if $to_insure>-1}
	<br/><label for = "advalorem">{l s='Shipment insurance' mod='chronopost'}</label>
	<div class="margin-form"><input type="checkbox" id = "advalorem" name="advalorem" value="yes" {if $to_insure>0} checked{/if}/>
	</div>
	<label>{l s='Value to insure' mod='chronopost'}</label><div class="margin-form"> <input type="text" name="advalorem_value" value="{$to_insure|escape:'htmlall'}"/>
	</div>
{/if}
<input type="hidden" name="orderid" value="{$id_order|escape:'htmlall'}"/><p style = "text-align:center">
<input type="hidden" name="shared_secret" value="{$chronopost_secret|escape:'htmlall'}"/><input type="submit" value="{l s='Print waybill' mod='chronopost'}" class="button" style = "margin:10px;"/>
{if $return==1}<input style = "margin:10px;" type="submit" name="return" value="{l s='Print the return waybill' mod='chronopost'}" class="button"/>{/if}
</form></fieldset>