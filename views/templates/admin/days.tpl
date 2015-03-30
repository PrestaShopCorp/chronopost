<select name="chronoparams[saturday][{$field_name}]">
	<option value="1"{if $selected == 1} selected{/if}>{l s="Monday" mod="chronopost"}</option>
	<option value="2"{if $selected == 2} selected{/if}>{l s="Tuesday" mod="chronopost"}</option>
	<option value="3"{if $selected == 3} selected{/if}>{l s="Wednesday" mod="chronopost"}</option>
	<option value="4"{if $selected == 4} selected{/if}>{l s="Thursday" mod="chronopost"}</option>
	<option value="5"{if $selected == 5} selected{/if}>{l s="Friday" mod="chronopost"}</option>
	<option value="6"{if $selected == 6} selected{/if}>{l s="Saturday" mod="chronopost"}</option>
	<option value="0"{if $selected == 0} selected{/if}>{l s="Sunday" mod="chronopost"}</option>
</select>