{literal}
<script type="text/javascript">
/* <![CDATA[ */
	function getSample()
		{		
		var selector = document.getElementById('sample_structure');
		if (selector)
			{
			var url = '{/literal}{$mod_path}{literal}';
			var pars = '{/literal}{$mod_param}{literal}';
		
			var myAjax = new Ajax.Request(
				url, 
				{
					method: 'get', 
					parameters: pars,
					onFailure: reportError,
					onComplete: replaceSample
				});		
			}
		}
	function reportError(request)
		{
			alert('Sorry. There was an error.');
		}

	function replaceSample(originalRequest)
		{
			//put returned sample in the textarea
			$('sample_structure').value = originalRequest.responseText;
		}

	function vcheck()
		{
		var cb = document.getElementById('del_cont_check');
		if (cb && cb.checked)
			{
			if (!confirm('{/literal}{$title_delete_sure}{literal}'))
				{
				cb.checked = false;
				}
			}
		}
	function showstructsource(source)
		{
		var fil = document.getElementById('blfile');
		var fld = document.getElementById('blfield');
		if (fil && fld)
			{
			if (source == 'field')
				{
				fil.style.display='none';
				fld.style.display='block';
				}
			else
				{
				fil.style.display='block';
				fld.style.display='none';
				}
			}
		}
/* ]]> */	
</script>
{/literal}
{if isset($message)}<h3>{$message}</h3>{/if}
{$tabheaders}
{$start_bulk}
{$start_import_form}
<div class="pageoverflow">
	<p class="pagetext">{$title_insert_lorem}:</p>
	<p class="pageinput">{$input_insert_lorem}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_template_to_use}:</p>
	<p class="pageinput">{$input_template_to_use}</p>
</div>
<fieldset><legend>{$title_structure_source}</legend>
<div class="pageoverflow">
	<p class="pagetext">{$title_source_chooser}:</p>
	<p class="pageinput">{$input_source_chooser}</p>
</div>
<div class="pageoverflow" id="blfile">
	<p class="pagetext">{$title_file}:</p>
	<p class="pageinput">{$input_file}</p>
</div>
<div class="pageoverflow" id="blfield" style="display:none">
	<p class="pagetext">{$title_field}:</p>
	<p class="pageinput">{$input_field}<br />{$load_link}</p>
</div>
</fieldset>
<div class="pageoverflow">
	<p class="pagetext">{$title_delete_content}:</p>
	<p class="pageinput">{$input_delete_content}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{$submit_go}</p>
</div>
{$end_form}
{$end_tab}
{$start_settings_form}
{$start_migrate}
<div class="pageoverflow">
	<p class="pagetext">{$title_fetch_assets}:</p>
	<p class="pageinput">{$input_fetch_assets}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_asset_location}:</p>
	<p class="pageinput">{$input_asset_location}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_asset_url}:</p>
	<p class="pageinput">{$input_asset_url}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_asset_regex}:</p>
	<p class="pageinput">{$input_asset_regex}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{$submit}</p>
</div>
{$end_tab}
{$start_settings}
<div class="pageoverflow">
	<p>{$title_migration_help}</p>
</div>
<fieldset><legend>{$title_delimiters}</legend>
	<table>
		<tr><th></th><th>{$title_best}</th><th>{$title_second}</th><th>{$title_third}</th></tr>
		<tr>
			<th>{$title_start_delimiter}</th>
			<td>{$input_start_delimiter1}</td>
			<td>{$input_start_delimiter2}</td>
			<td>{$input_start_delimiter3}</td>
		</tr>
		<tr>
			<th>{$title_end_delimiter}</th>
			<td>{$input_end_delimiter1}</td>
			<td>{$input_end_delimiter2}</td>
			<td>{$input_end_delimiter3}</td>
		</tr>
	</table>
	<p>{$title_delimiters_help}</p>
</fieldset>
<fieldset><legend>{$title_cleanup}</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$title_remove_markup}:</p>
		<p class="pageinput">{$input_remove_markup}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_lowercase_markup}:</p>
		<p class="pageinput">{$input_lowercase_markup}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_allowed_tags}:</p>
		<p class="pageinput">{$input_allowed_tags}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_remove_scripts}:</p>
		<p class="pageinput">{$input_remove_scripts}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_fix_smarty}:</p>
		<p class="pageinput">{$input_fix_smarty}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_fix_internal_links}:</p>
		<p class="pageinput">{$input_fix_internal_links}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_internal_links_rel}:</p>
		<p class="pageinput">{$input_internal_links_rel}</p>
	</div>
	</fieldset>
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submit}</p>
	</div>
</fieldset>
{$end_tab}
{$start_substitutions}
<p>{$title_substitutions_help}</p>
<div class="pageoverflow">
	<p class="pagetext">{$title_substitutions}:</p>
	<p class="pageinput">{$input_substitutions}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{$submit}</p>
</div>

{$end_tab}
{$end_form}
{$end_tabs}