<?php
if (!isset($gCms)) exit;

if (isset($params['submit']))
	{
	if (isset($params['start_delimiter']))
		{
		$this->SetPreference('start_delimiter', trim($params['start_delimiter']));
		}
	if (isset($params['end_delimiter']))
		{
		$this->SetPreference('end_delimiter', trim($params['end_delimiter']));
		}
	if (isset($params['allowed_tags']))
		{
		$this->SetPreference('allowed_tags', trim($params['allowed_tags']));
		}
	
	$this->SetPreference('remove_markup',(isset($params['remove_markup'])?$params['remove_markup']:'0'));
	$this->SetPreference('remove_scripts',(isset($params['remove_scripts'])?$params['remove_scripts']:'0'));
	$this->SetPreference('fix_smarty',(isset($params['fix_smarty'])?$params['fix_smarty']:'0'));
	$params['active_tab'] = 'settings';
	$smarty->assign('message',$this->Lang('updated_settings'));
	}


if (FALSE == empty($params['active_tab']))
  {
    $tab = $params['active_tab'];
  } else {
  $tab = '';
 }

$smarty->assign('tabheaders', $this->StartTabHeaders() .
	$this->SetTabHeader('bulk',$this->Lang('bulk'),('bulk' == $tab)?true:false) .
	$this->SetTabHeader('settings',$this->Lang('settings'),('settings' == $tab)?true:false) .
	$this->EndTabHeaders().
	$this->StartTabContent());
$smarty->assign('start_bulk',$this->StartTab('bulk'));
$smarty->assign('start_settings',$this->StartTab('settings'));
$smarty->assign('end_tab',$this->EndTab());
$smarty->assign('end_tabs',$this->EndTabContent());


$smarty->assign('start_import_form', $this->CreateFormStart($id, 'import',
   $returnid, 'post','multipart/form-data'));
$smarty->assign('start_settings_form', $this->CreateFormStart($id, 'defaultadmin',$returnid));


$smarty->assign('title_insert_lorem',$this->Lang('title_insert_lorem'));
$smarty->assign('title_template_to_use',$this->Lang('title_template_to_use'));
$smarty->assign('title_file',$this->Lang('title_file'));
$smarty->assign('title_start_delimiter',$this->Lang('title_start_delimiter'));
$smarty->assign('title_end_delimiter',$this->Lang('title_end_delimiter'));
$smarty->assign('title_remove_markup',$this->Lang('title_remove_markup'));
$smarty->assign('title_allowed_tags',$this->Lang('title_allowed_tags'));
$smarty->assign('title_remove_scripts',$this->Lang('title_remove_scripts'));
$smarty->assign('title_fix_smarty',$this->Lang('title_fix_smarty'));
$smarty->assign('title_migration_help',$this->Lang('title_migration_help'));


$templateops =& $gCms->GetTemplateOperations();

$smarty->assign('input_template_to_use',$templateops->TemplateDropdown());
$items = array($this->Lang('none')=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
$smarty->assign('input_file',$this->CreateInputFile($id, 'ulfile'));
$smarty->assign('input_insert_lorem',$this->CreateInputDropdown($id, 'insert_lorem', $items));
$smarty->assign('input_start_delimiter',
	$this->CreateInputText($id, 'start_delimiter', $this->GetPreference('start_delimiter','/<body[^>]*>/i'),25));
$smarty->assign('input_end_delimiter',
	$this->CreateInputText($id, 'end_delimiter', $this->GetPreference('end_delimiter','/<\/body>/i'),25));
$smarty->assign('input_remove_markup',
	$this->CreateInputCheckbox($id, 'remove_markup', 1, $this->GetPreference('remove_markup','0')).
	$this->Lang('title_remove_markup'));
$smarty->assign('input_remove_scripts',
	$this->CreateInputCheckbox($id, 'remove_scripts', 1, $this->GetPreference('remove_scripts','0')).
	$this->Lang('title_remove_scripts'));
$smarty->assign('input_fix_smarty',
	$this->CreateInputCheckbox($id, 'fix_smarty', 1, $this->GetPreference('fix_smarty','1')).
	$this->Lang('title_fix_smarty'));
$smarty->assign('input_allowed_tags',
	$this->CreateInputText($id, 'allowed_tags',
	$this->GetPreference('allowed_tags','<p><a><i><b><strong><em><ul><li><ol><sup><sub>'),40));



$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('submit_go', $this->CreateInputSubmit($id, 'go', $this->Lang('submit_go')));

$smarty->assign('end_form', $this->CreateFormEnd());

echo $this->ProcessTemplate('adminpanel.tpl');
?>