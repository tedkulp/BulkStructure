<?php

$this->RemovePreference('start_delimiter');
$this->RemovePreference('end_delimiter');
$this->RemovePreference('fix_links');
$this->RemovePreference('fetch_assets');
$this->RemovePreference('asset_path');
$this->RemovePreference('remove_markup');
$this->RemovePreference('remove_scripts');
$this->RemovePreference('fix_smarty');
$this->RemovePreference('allowed_tags');

// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('uninstalled', $this->GetVersion()) );    
?>