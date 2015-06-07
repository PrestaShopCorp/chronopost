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

<div class="row">
	<div class="col-sm-4">
		<div data-spy="affix">
			<h1>{l s='Module Chronopost' mod='chronopost'}</h1>

			<ol class="nav nav-pills nav-stacked" id="chrononav">
			  <li role="presentation"><a href="#account">1. {l s='Configure account' mod='chronopost'}</a></li>
			  <li role="presentation"><a href="#carriers">2. {l s='Configure carriers' mod='chronopost'}</a></li>
  			  <li role="presentation"><a href="#shipping">4. {l s='Configure shipping options' mod='chronopost'}</a></li>
			  <li role="presentation"><a href="#pricing">3. {l s='Configure pricing' mod='chronopost'}</a></li>
  			  <li role="presentation"><a href="#predict">4. {l s='Configure Predict' mod='chronopost'}</a></li>

			</ol>
		</div>
	</div>
	<div class="col-sm-8">

		<div class="alert alert-dismissible alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span></button>
			<p>
				<strong>{l s='Offer to your customers the first Express delivery service with the offical Chronopost module for Prestashop 1.5 and 1.6. With Chronopost, your customer will have the choice of the main delivery modes within 24h : at home,  at a Pickup point or at the office !' mod='chronopost'}</strong>
			</p><p>
					{l s='Your customers will also have the Predict service :  They are notified by email or SMS the day before the delivery and can reschedule the delivery or ask to be delivered at a pickup point among more than 17 000 points (post offices, Pickup relay or Chronopost agencies).' mod='chronopost'}
			</p><p>
				{l s='Expand your business internationally with Chronopost international delivery service which is included in this module.' mod='chronopost'}
			</p><p><strong>
				{l s='Find all these services in the Chronopost e-commerce pack : MyChrono. To activate the module on your site, contact us at ' mod='chronopost'}<a href="mailto:demandez-a-chronopost@chronopost.fr">demandez-a-chronopost@chronopost.fr</a>
				</strong>
			</p>
		</div>

		<h2 id="account">{l s='Configure account' mod='chronopost'}</h2>
		<style>
			body {
	  			position: relative;
			}
		</style>
		<script>
			var module_dir="{$module_dir|escape:'htmlall'}";
			var chronopost_secret="{$chronopost_secret|escape:'htmlall'}";
			{literal}
				$(function() {
					$('body').scrollspy({ target: '#chrononav' })

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

		<form action="{$post_uri|escape:'htmlall'}" class="form-horizontal" method="post">
			<div class="panel">
				<div class="panel-heading">
					<i class="icon-briefcase"></i> {l s='Account credentials' mod='chronopost'}
				</div>
				<div class="form-group">													
					<label class="control-label col-lg-3">
						{l s='Contract number' mod='chronopost'}
					</label>				
					<div class="col-lg-9 ">
						<input id = "chrono_account" type="text" name="chronoparams[general][account]" value="{$general_account|escape:'htmlall'}"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-3">{l s='Subaccount' mod='chronopost'}</label>
					<div class="col-lg-9">
						<input id = "chrono_subaccount" type="text" name="chronoparams[general][subaccount]" value="{$general_subaccount|escape:'htmlall'}"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-3">{l s='Chronopost password' mod='chronopost'}</label>
					<div class="col-lg-9">
						<input id = "chrono_password" type="text" name="chronoparams[general][password]" value="{$general_password|escape:'htmlall'}"/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-lg-3"></label>
					<div class="col-lg-9">
						<button id = "testWSLogin" class="btn btn-default">{l s='Test the validity of identifiers' mod='chronopost'}</button>
					</div>
				</div>
			</div>

			<div class="panel" class="shipperInfo">
				<div class="panel-heading">
					<i class="icon-truck"></i> {l s='Shipper informations' mod='chronopost'}
				</div>

			 	{$shipper_form}
			</div>
			
			<div class="panel" class="invoicingInfo">
				<div class="panel-heading">
					<i class="icon-euro"></i> {l s='Invoicing informations' mod='chronopost'}
				</div>
				<!--<div class="form-group">
					<label class="control-label col-lg-3" for="copyShipperInfo">{l s='Use the same information as above' mod='chronopost'}</label>
					<div class="col-lg-9">
						<input type="checkbox" id="copyShipperInfo"/>
					</div>
				</div>-->
			 	{$customer_form}
			 	<div class="panel-footer">
					<button type="submit" class="btn btn-default pull-right" name="submitOptionscountry"><i class="process-icon-save"></i> {l s='Save' mod='chronopost'}</button>
				</div>
			</div>
			
			<h2 id="carriers">{l s='Configure carriers' mod='chronopost'}</h2>
			<div class="panel">
				<div class="panel-heading">
					<i class="icon-truck"></i> {l s='Carriers' mod='chronopost'}
				</div>
				{foreach from=$carriers_tpl item=tpl}
					{$tpl}
				{/foreach}
				<div class="panel-footer">
					<button type="submit" class="btn btn-default pull-right" name="submitOptionscountry"><i class="process-icon-save"></i> {l s='Save' mod='chronopost'}</button>
				</div>
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
						<option value="yes"{if $saturday_active!='yes'} selected{/if}>{l s="No" mod='chronopost'}</option>
					</select>
				</div>
				<label>{l s='Option checked by default' mod='chronopost'}</label>
				<div class="margin-form">
					<select name="chronoparams[saturday][checked]">
						<option value="yes"{if $saturday_checked=='yes'} selected{/if}>{l s="Yes" mod='chronopost'}</option>
						<option value="yes"{if $saturday_checked!='yes'} selected{/if}>{l s="No" mod='chronopost'}</option>
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

			


			<p class="clear">&nbsp;</p>
			<center><input type="submit" name="submitchronoRelaisConfig" value="{l s='Save configuration' mod='chronopost'}" class="button" /></center>
			<br/>
		</form>
	</div>
</div>
