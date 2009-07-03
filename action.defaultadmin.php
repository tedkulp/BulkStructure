<?php
if (!isset($gCms)) exit;

if (isset($params['submit']))
	{
	$this->SetPreference('start_delimiter1', trim($params['start_delimiter1']));
	$this->SetPreference('start_delimiter2', trim($params['start_delimiter2']));
	$this->SetPreference('start_delimiter3', trim($params['start_delimiter3']));
	$this->SetPreference('end_delimiter1', trim($params['end_delimiter1']));
	$this->SetPreference('end_delimiter2', trim($params['end_delimiter2']));
	$this->SetPreference('end_delimiter3', trim($params['end_delimiter3']));
	if (isset($params['allowed_tags']))
		{
		$this->SetPreference('allowed_tags', trim($params['allowed_tags']));
		}
	if (isset($params['asset_path']))
		{
		$this->SetPreference('asset_path', trim($params['asset_path']));
		}
	if (isset($params['asset_url']))
		{
		$this->SetPreference('asset_url', trim($params['asset_url']));
		}
	if (isset($params['asset_regex']))
		{
		$this->SetPreference('asset_regex', trim($params['asset_regex']));
		}
	
	$this->SetPreference('substitutions',(isset($params['substitutions'])?$params['substitutions']:''));
	$this->SetPreference('links_rel',(isset($params['links_rel'])?$params['links_rel']:'0'));
	$this->SetPreference('fix_links',(isset($params['fix_links'])?$params['fix_links']:'0'));
	$this->SetPreference('fetch_assets',(isset($params['fetch_assets'])?$params['fetch_assets']:'0'));
	$this->SetPreference('remove_markup',(isset($params['remove_markup'])?$params['remove_markup']:'0'));
	$this->SetPreference('lowercase_markup',(isset($params['lowercase_markup'])?$params['lowercase_markup']:'0'));
	$this->SetPreference('remove_scripts',(isset($params['remove_scripts'])?$params['remove_scripts']:'0'));
	$this->SetPreference('fix_smarty',(isset($params['fix_smarty'])?$params['fix_smarty']:'0'));
	$params['active_tab'] = 'settings';
	$smarty->assign('message',$this->Lang('updated_settings'));
	}

if (FALSE == empty($params['active_tab']))
  {
    $tab = $params['active_tab'];
  } else {
  $tab = 'bulk';
 }

$smarty->assign('tabheaders', $this->StartTabHeaders() .
	$this->SetTabHeader('bulk',$this->Lang('bulk'),('bulk' == $tab)?true:false) .
	$this->SetTabHeader('migrate',$this->Lang('migrate'),('migrate' == $tab)?true:false) .
	$this->SetTabHeader('settings',$this->Lang('settings'),('settings' == $tab)?true:false) .
	$this->SetTabHeader('substitutions',$this->Lang('substitutions'),('substitutions' == $tab)?true:false) .
	$this->EndTabHeaders().
	$this->StartTabContent());
$smarty->assign('start_bulk',$this->StartTab('bulk'));
$smarty->assign('start_settings',$this->StartTab('settings'));
$smarty->assign('start_migrate',$this->StartTab('migrate'));
$smarty->assign('start_substitutions',$this->StartTab('substitutions'));
$smarty->assign('end_tab',$this->EndTab());
$smarty->assign('end_tabs',$this->EndTabContent());


$smarty->assign('start_import_form', $this->CreateFormStart($id, 'import',
   $returnid, 'post','multipart/form-data'));
$smarty->assign('start_settings_form', $this->CreateFormStart($id, 'defaultadmin',$returnid));


$smarty->assign('title_insert_lorem',$this->Lang('title_insert_lorem'));
$smarty->assign('title_template_to_use',$this->Lang('title_template_to_use'));
$smarty->assign('title_file',$this->Lang('title_file'));
$smarty->assign('title_field',$this->Lang('title_field'));
$smarty->assign('title_delimiters_help',$this->Lang('title_delimiters_help'));
$smarty->assign('title_best',$this->Lang('title_best'));
$smarty->assign('title_second',$this->Lang('title_second'));
$smarty->assign('title_third',$this->Lang('title_third'));
$smarty->assign('title_start_delimiter',$this->Lang('title_start_delimiter'));
$smarty->assign('title_end_delimiter',$this->Lang('title_end_delimiter'));
$smarty->assign('title_remove_markup',$this->Lang('title_remove_markup'));
$smarty->assign('title_lowercase_markup',$this->Lang('title_lowercase_markup'));
$smarty->assign('title_allowed_tags',$this->Lang('title_allowed_tags'));
$smarty->assign('title_remove_scripts',$this->Lang('title_remove_scripts'));
$smarty->assign('title_fix_smarty',$this->Lang('title_fix_smarty'));
$smarty->assign('title_migration_help',$this->Lang('title_migration_help'));
$smarty->assign('title_delete_content',$this->Lang('title_delete_content'));
$smarty->assign('title_delete_sure',$this->Lang('title_delete_sure'));
$smarty->assign('title_source_chooser',$this->Lang('title_source_chooser'));
$smarty->assign('title_structure_source',$this->Lang('title_structure_source'));
$smarty->assign('title_source_chooser',$this->Lang('title_source_chooser'));
$smarty->assign('title_cleanup',$this->Lang('title_cleanup'));
$smarty->assign('title_delimiters',$this->Lang('title_delimiters'));
$smarty->assign('title_fix_internal_links',$this->Lang('title_fix_internal_links'));
$smarty->assign('title_internal_links_rel',$this->Lang('title_internal_links_rel'));
$smarty->assign('title_fetch_assets',$this->Lang('title_fetch_assets'));
$smarty->assign('title_asset_location',$this->Lang('title_asset_location'));
$smarty->assign('title_asset_url',$this->Lang('title_asset_url'));
$smarty->assign('title_asset_regex',$this->Lang('title_asset_regex'));
$smarty->assign('title_substitutions',$this->Lang('title_substitutions'));

$templateops =& $gCms->GetTemplateOperations();

$smarty->assign('input_template_to_use',$templateops->TemplateDropdown());
$items = array($this->Lang('none')=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
$smarty->assign('input_file',$this->CreateInputFile($id, 'ulfile'));
$smarty->assign('input_insert_lorem',$this->CreateInputDropdown($id, 'insert_lorem', $items));
$smarty->assign('input_start_delimiter1',
	$this->CreateInputText($id, 'start_delimiter1', $this->GetPreference('start_delimiter1','/<body[^>]*>/i'),25));
$smarty->assign('input_start_delimiter2',
	$this->CreateInputText($id, 'start_delimiter2', $this->GetPreference('start_delimiter2',''),25));
$smarty->assign('input_start_delimiter3',
	$this->CreateInputText($id, 'start_delimiter3', $this->GetPreference('start_delimiter3',''),25));
$smarty->assign('input_end_delimiter1',
	$this->CreateInputText($id, 'end_delimiter1', $this->GetPreference('end_delimiter1','/<\/body>/i'),25));
$smarty->assign('input_end_delimiter2',
	$this->CreateInputText($id, 'end_delimiter2', $this->GetPreference('end_delimiter2',''),25));
$smarty->assign('input_end_delimiter3',
	$this->CreateInputText($id, 'end_delimiter3', $this->GetPreference('end_delimiter3',''),25));
$smarty->assign('input_fix_internal_links',
	$this->CreateInputCheckbox($id, 'fix_links', 1, $this->GetPreference('fix_links','1')).
	$this->Lang('title_fix_internal_links'));
$smarty->assign('input_internal_links_rel',
	$this->CreateInputCheckbox($id, 'links_rel', 1, $this->GetPreference('links_rel','1')).
	$this->Lang('title_internal_links_rel'));
$smarty->assign('input_fetch_assets',
	$this->CreateInputCheckbox($id, 'fetch_assets', 1, $this->GetPreference('fetch_assets','0')).
	$this->Lang('title_fetch_assets_help'));
$smarty->assign('input_asset_location',$this->CreateInputText($id, 'asset_path',
	$this->GetPreference('asset_path',$gCms->config['uploads_path'].DIRECTORY_SEPARATOR.$this->Lang('migrate_dir')), 40));
$smarty->assign('input_asset_url',$this->CreateInputText($id, 'asset_url',
	$this->GetPreference('asset_url',$gCms->config['uploads_url'].'/'.$this->Lang('migrate_dir')), 40));
$smarty->assign('input_asset_regex',$this->CreateInputText($id, 'asset_regex',
	$this->GetPreference('asset_regex','jpg|jpeg|gif|png|pdf|doc|rtf|swf|xls'),40));
$smarty->assign('input_remove_markup',
	$this->CreateInputCheckbox($id, 'remove_markup', 1, $this->GetPreference('remove_markup','0')).
	$this->Lang('title_remove_markup'));
$smarty->assign('input_lowercase_markup',
	$this->CreateInputCheckbox($id, 'lowercase_markup', 1, $this->GetPreference('lowercase_markup','0')).
	$this->Lang('title_lowercase_markup'));
$smarty->assign('input_remove_scripts',
	$this->CreateInputCheckbox($id, 'remove_scripts', 1, $this->GetPreference('remove_scripts','0')).
	$this->Lang('title_remove_scripts'));
$smarty->assign('input_fix_smarty',
	$this->CreateInputCheckbox($id, 'fix_smarty', 1, $this->GetPreference('fix_smarty','1')).
	$this->Lang('title_fix_smarty_help'));
$smarty->assign('input_allowed_tags',
	$this->CreateInputText($id, 'allowed_tags',
	$this->GetPreference('allowed_tags','<p><a><img><i><b><strong><em><ul><li><ol><sup><sub>'),40));
$smarty->assign('input_delete_content',
	$this->CreateInputCheckbox($id, 'delete_content', '1', '0', "id=\"del_cont_check\" onclick='vcheck()'").
	$this->Lang('title_delete_content'));
$smarty->assign('input_source_chooser','<input type="radio" name="structsource" value="file" id="filecheck" checked="checked" onclick="showstructsource(\'file\')"/><label for="filecheck">'.$this->Lang('file').'</label><input type="radio" name="structsource" value="field" id="fieldcheck" onclick="showstructsource(\'field\')"/><label for="fieldcheck">'.$this->Lang('form').'</label>');
$smarty->assign('input_field',$this->CreateTextArea(false, $id, '', 'structure','','sample_structure'));
$smarty->assign('load_link','<a href="javascript:getSample()">'.$this->Lang('load_sample').'</a>');
$smarty->assign('input_substitutions',$this->CreateTextArea(false, $id, $this->GetPreference('substitutions','<br>~<br />|<hr>~<hr />'), 'substitutions'));



$modLink = $this->CreateLink($id, 'get_sample', $returnid, '', array(), '', true);
list($mod_path, $mod_param) = explode('?',$modLink);
$smarty->assign('security_key',CMS_SECURE_PARAM_NAME.'='.$_SESSION[CMS_USER_KEY]);
$smarty->assign('mod_path',$mod_path);
$smarty->assign('mod_param',html_entity_decode($mod_param));


$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('submit_go', $this->CreateInputSubmit($id, 'go', $this->Lang('submit_go')));

$smarty->assign('end_form', $this->CreateFormEnd());

echo $this->ProcessTemplate('adminpanel.tpl');
?>