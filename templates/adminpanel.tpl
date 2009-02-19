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
<div class="pageoverflow">
	<p class="pagetext">{$title_file}:</p>
	<p class="pageinput">{$input_file}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{$submit_go}</p>
</div>
{$end_form}
{$end_tab}
{$start_settings}
{$start_settings_form}
<div class="pageoverflow">
	<p>{$title_migration_help}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_start_delimiter}:</p>
	<p class="pageinput">{$input_start_delimiter}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_end_delimiter}:</p>
	<p class="pageinput">{$input_end_delimiter}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$title_remove_markup}:</p>
	<p class="pageinput">{$input_remove_markup}</p>
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
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{$submit}</p>
</div>
{$end_form}
{$end_tab}
{$end_tabs}