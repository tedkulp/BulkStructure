<?php
if (!isset($gCms)) exit;

$smarty->assign('start_form', $this->CreateFormStart($id, 'import',
   $returnid, 'post','multipart/form-data'));


$smarty->assign('title_insert_lorem',$this->Lang('title_insert_lorem'));
$smarty->assign('title_template_to_use',$this->Lang('title_template_to_use'));
$smarty->assign('title_file',$this->Lang('title_file'));

$templateops =& $gCms->GetTemplateOperations();

$smarty->assign('input_template_to_use',$templateops->TemplateDropdown());

$items = array($this->Lang('none')=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');

$smarty->assign('input_file',$this->CreateInputFile($id, 'ulfile'));


$smarty->assign('input_insert_lorem',$this->CreateInputDropdown($id, 'insert_lorem', $items));
$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));

$smarty->assign('end_form', $this->CreateFormEnd());

echo $this->ProcessTemplate('adminpanel.tpl');
?>