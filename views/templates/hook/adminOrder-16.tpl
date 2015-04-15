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
<div class="row"><div class="panel col-lg-7">
				<div class="panel-heading">
					<i class="icon-truck"></i> {l s='Print the Chronopost waybills' mod='chronopost'}</div>
				<form method="POST" action="{$module_uri|escape:'htmlall'}/postSkybill.php" role="form" class="form-horizontal">

{if $bal==1}
	<p style = "text-align:center;width:400px"><b>Option BAL activée.</b></p>
{/if}

{if $saturday==1}
<div class="form-group"><div class="col-sm-offset-4 col-sm-8">
	<div class="checkbox">
		<label>
			<input type="checkbox" name="shipSaturday" value="yes" {if $saturday_ok==1} checked{/if}/>{l s='Saturday delivery option' mod='chronopost'}
		</label>
	</div>
</div></div>
{/if}
<div class="form-group">
	<label for = "multiOne" class="control-label col-sm-4">{l s='Number of parcels' mod='chronopost'}</label>
	<div class="col-sm-8"><input type="number" name="multiOne" id="multiOne" value="{$nbwb|escape:'htmlall'}" class="form-control"/></div>
</div>

{if $to_insure>-1}
<div class="form-group"><div class="col-sm-offset-4 col-sm-8">
	<div class="checkbox">
		<label>
			<input type="checkbox" id="advalorem" name="advalorem" value="yes" {if $to_insure>0} checked{/if}/>
			{l s='Shipment insurance' mod='chronopost'}
		</label>
	</div>
</div></div>
			
<div class="form-group">
	<label for = "advalorem_value" class="control-label col-sm-4">{l s='Value to insure' mod='chronopost'}</label>
	<div class="col-sm-8"><input type="text" class="form-control" name="advalorem_value" value="{$to_insure|escape:'htmlall'}"/></div>
</div>
{/if}

<input type="hidden" name="orderid" value="{$id_order|escape:'htmlall'}"/><p style = "text-align:center">
<input type="hidden" name="shared_secret" value="{$chronopost_secret|escape:'htmlall'}"/>

<input class="btn btn-primary" type="submit" value="{l s='Print waybill' mod='chronopost'}" class="button" style = "margin:10px;"/>

{if $return==1}
	<input class="btn btn-default" style = "margin:10px;" type="submit" name="return" value="{l s='Print the return waybill' mod='chronopost'}" class="button"/>
{/if}

</form></div></div>