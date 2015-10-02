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
<h2>{l s="Chronopost and Chronopost Pickup" mod='chronopost'}</h2>
<style>label { width:300px;}</style>
<script>
	var module_dir="{$module_dir|escape:'htmlall'}";
	var chronopost_secret="{$chronopost_secret|escape:'htmlall'}";
	{literal}
		$(function() {
			$("#testWSLogin").on("click", function(e)
			{
				e.preventDefault();
				$.get(module_dir+"chronopost/async/testLogin.php?account="+$("#chrono_account").val()+"&shared_secret="+chronopost_secret+"&password="+$("#chrono_password").val(), function(data) { 
							if (data == "OK") alert("Les identifiants fournis sont valides !");
							else alert(data);
					});
				return false;
			});
		});
	{/literal}
</script>
<form action="{$post_uri|escape:'htmlall'}" method="post">

	<!--GENERAL-->
	<fieldset>
	 <legend><img src="../img/admin/asterisk.gif" alt="" title="" />{l s='Common config' mod='chronopost'}</legend>
		<label>{l s='Contract number' mod='chronopost'}</label>
		<div class="margin-form">
			<input id = "chrono_account" type="text" name="chronoparams[general][account]" value="{$general_account|escape:'htmlall'}"/>
		</div>

		<label>{l s='Subaccount' mod='chronopost'}</label>
		<div class="margin-form">
			<input id = "chrono_subaccount" type="text" name="chronoparams[general][subaccount]" value="{$general_subaccount|escape:'htmlall'}"/>
		</div>

		<label>{l s='Chronopost password' mod='chronopost'}</label>
		<div class="margin-form">
			<input id = "chrono_password" type="text" name="chronoparams[general][password]" value="{$general_password|escape:'htmlall'}"/>
		</div>
		

		<div class="margin-form">
			<button id = "testWSLogin">{l s='Test the validity of identifiers' mod='chronopost'}</button>
		</div>


		<label>{l s='Waybill print type' mod='chronopost'}</label>
		<div class="margin-form">
			<select name="chronoparams[general][printmode]">
				{foreach from=$print_modes key="k" item="v"}
					<option value="{$k}"{if $k==$selected_print_mode} selected{/if}>{$v}</option>
				{/foreach}
			</select>
		</div>

		<label>{l s='Product unit weight' mod='chronopost'}</label>
		<div class="margin-form">
			<select name="chronoparams[general][weightcoef]"/>';
				{foreach from=$weights key="v" item="k"}
					<option value="{$k}"{if $k==$selected_weight} selected{/if}>{$v}</option>
				{/foreach}
			</select>
		</div>
	</fieldset>
	<p class="clear">&nbsp;</p>

	<!--SATURDAY-->
	<fieldset>
	 <legend><img src="../img/admin/asterisk.gif" alt="" title="" />{l s='Delivery on saturday option' mod='chronopost'}</legend>
		<label>{l s='Activate Saturday delivery option' mod='chronopost'}</label>
		<div class="margin-form">
			<select name="chronoparams[saturday][active]">
				<option value="yes"{if $saturday_active=='yes'} selected{/if}>{l s="Yes" mod='chronopost'}</option>
				<option value="no"{if $saturday_active!='yes'} selected{/if}>{l s="No" mod='chronopost'}</option>
			</select>
		</div>
		<label>{l s='Option checked by default' mod='chronopost'}</label>
		<div class="margin-form">
			<select name="chronoparams[saturday][checked]">
				<option value="yes"{if $saturday_checked=='yes'} selected{/if}>{l s="Yes" mod='chronopost'}</option>
				<option value="no"{if $saturday_checked!='yes'} selected{/if}>{l s="No" mod='chronopost'}</option>
			</select>
		</div>
		<div class="path_bar">{l s='Display the Saturday delivery option from:' mod='chronopost'}</div>

		<label>{l s='Day' mod='chronopost'}</label>
		<div class="margin-form">
			 {$day_start}
 		</div>

		<label>{l s='Hour' mod='chronopost'}</label>
		<div class="margin-form">
			{$hour_start} : {$minute_start}
		</div>
		<div class="path_bar">{l s="Until" mod='chronopost'}</div>
		
		<label>{l s='Day' mod='chronopost'}</label>
		<div class="margin-form">
			 {$day_end}
 		</div>

		<label>{l s='Hour' mod='chronopost'}</label>
		<div class="margin-form">
			{$hour_end} : {$minute_end}
		</div>
	</fieldset>
	<p class="clear">&nbsp;</p>
	<!--CORSICA-->
	<fieldset>
	 <legend><img src="../img/admin/asterisk.gif" alt="" title="" />{l s='Shipping to Corsica' mod='chronopost'}</legend>
		
		<label>{l s='Supplement for deliveries to Corsica' mod='chronopost'}</label>
		<div class="margin-form">
			+ <input name="chronoparams[corsica][supplement]" type="text" style = "width:40px;text-align:right;"
				value="{$corsica_supplement|escape:'htmlall'}"/> €
<p class="clear hint">{l s='Configurable amount according to your pricing policy. However, the amount charged by Chronopost corresponds to pricing policy specified in your contract.' mod='chronopost'}</p>
		</div>
	</fieldset>
	<p class="clear">&nbsp;</p>
	<!--QUICKCOST-->
	<fieldset>
	 <legend><img src="../img/admin/asterisk.gif" alt="" title="" />{l s='Pricing with Quickcost' mod='chronopost'}</legend>
		
		<label>{l s='Activate Quickcost' mod='chronopost'}</label>
		<div class="margin-form">
			 <select name="chronoparams[quickcost][enabled]">
				<option value="0"{if $quickcost_enabled != 1} selected{/if}>{l s='No' mod='chronopost'}</option>
				<option value="1"{if $quickcost_enabled == 1} selected{/if}>{l s='Yes' mod='chronopost'}</option>
			</select>
<p class="clear hint">{l s='Quickcost will calculate the cost of an item, depending on the rates negociated with Chronopost. This option replaces the use of the fee schedule.' mod='chronopost'}</p>
		</div>
	</fieldset>
	<p class="clear">&nbsp;</p>


	<!--AD VALOREM-->
	<fieldset>
	 <legend><img src="../img/admin/asterisk.gif" alt="" title="" />{l s="Insurance" mod='chronopost'}</legend>
		
		<label>{l s='Activate insurance' mod='chronopost'}</label>
		<div class="margin-form">
			<select name="chronoparams[advalorem][enabled]">
				<option value="1">{l s="Yes" mod='chronopost'}</option>
				<option value="0"{if $advalorem_enabled==0} selected{/if}>{l s="No" mod='chronopost'}</option>
			</select>
		</div>

		<label>{l s='Minimum amount to insure' mod='chronopost'}</label>
		<div class="margin-form">
			<input type="text" name="chronoparams[advalorem][minvalue]" value="{$advalorem_minvalue|escape:'htmlall'}"/>
<p class="clear hint">{l s='By enabling this option, for each package exceeding the amount you enter, your shipment will be insured up to the amount of its the articles (maximum 20,000€ ). You can enter the amount to insure on your order detail.' mod='chronopost'}</p>
		</div> 
	</fieldset>
	<p class="clear">&nbsp;</p>
	<!-- BAL OPTION -->
	<fieldset>
	 <legend><img src="../img/admin/asterisk.gif" alt="" title="" />{l s='Mailbox option' mod='chronopost'}</legend>
		
		<label>{l s='Activate mailbox option' mod='chronopost'}</label>
		<div class="margin-form">
			<select name="chronoparams[bal][enabled]">
				<option value="0">{l s='No' mod='chronopost'}</option>
				<option value="1"{if $bal_enabled==1} selected{/if}>{l s='Yes' mod='chronopost'}</option>
			</select>
			
			<p class="clear hint">{l s='Careful : This option has to be contracted first' mod="chronopost"}</p>
		</div>

	</fieldset>
	<p class="clear">&nbsp;</p>

	<!--SHIPPER-->
	<fieldset>
	 <legend><img src="../img/admin/asterisk.gif" alt="" title="" />{l s='Shipper informations' mod='chronopost'}</legend>
	 {$shipper_form}
	</fieldset>
	<p class="clear">&nbsp;</p>
	<fieldset>
	 <legend><img src="../img/admin/asterisk.gif" alt="" title="" />{l s='Invoicing informations' mod='chronopost'}</legend>
	 {$customer_form}
	</fieldset>


	<p class="clear">&nbsp;</p>
	<center><input type="submit" name="submitchronoRelaisConfig" value="{l s='Save configuration' mod='chronopost'}" class="button" /></center>
	<br/>
</form>