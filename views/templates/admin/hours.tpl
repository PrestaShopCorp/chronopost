<select name="chronoparams[saturday][{$field_name}]">
	{for $i=0 to 23}
		<option value="{$i}"{if $i==$selected} selected{/if}>{$i|string_format:'%02d'}</option>
	{/for}
</select>