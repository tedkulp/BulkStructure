<?php
if (!isset($gCms)) exit;

if (!empty($_FILES[$id.'ulfile']['error']))
   {
   echo $this->Lang('upload_error',$_FILES[$id.'ulfile']['error']);
   }
else
   {
   $listing = file($_FILES[$id.'ulfile']['tmp_name']);
   $page_cachable = ((get_site_preference('page_cachable',"1")=="1")?true:false);
   $active = ((get_site_preference('page_active',"1")=="1")?true:false);
   $showinmenu = ((get_site_preference('page_showinmenu',"1")=="1")?true:false);
   $metadata = get_site_preference('page_metadata');
   $userid = get_userid();
	$contentops =& $gCms->GetContentOperations();
   $lorem = explode('|',$this->Lang('lorem'));
   $loremstr = '';
   for($i=0;$i<$params['insert_lorem'];$i++)
      {
      $loremstr .= $lorem[$i];
      }

   $prevdepth = 0;
   $parents = array();
   $p_count = 0;
   $m_count = 0;
   foreach ($listing as $thisPage)
      {
      $thisPage = preg_replace('/\n|\r/','',$thisPage);
      if (!empty($thisPage))
         {
         $details = explode('|',$thisPage);
         $thisdepth = substr_count($details[0],'-');
         $name = preg_replace('/^[-]+/','',$details[0]);
         $alias = preg_replace('/[^a-zA-Z0-9]/','-',$name);
         $contentobj = $contentops->CreateNewContent('content');
         $contentobj->SetMenuText($name);
         $contentobj->mName = $name;
         $alias = munge_string_to_url($alias, true);
		 // Make sure auto-generated new alias is not already in use on a different page
		 $error = $contentops->CheckAliasError($alias);
		 if ($error !== FALSE)
		    {
			$alias_num_add = 2;
			while ($contentops->CheckAliasError($alias.'-'.$alias_num_add) !== FALSE)
				{
				$alias_num_add++;
				}
			$alias .= '-'.$alias_num_add;
			}
         $contentobj->SetAlias($alias);
         $contentobj->SetOwner($userid);
         $contentobj->SetCachable($page_cachable);
         $contentobj->SetActive($active);
         $contentobj->SetShowInMenu($showinmenu);
         $contentobj->SetLastModifiedBy($userid);
         $contentobj->SetMetadata($metadata);
         $contentobj->SetTemplateId($_POST['template_id']);
         $populated_content = false;
         if (count($details) > 1)
            {
            $fetched = $this->fetch_url($details[1]);
            if ($fetched !== false)
               {
               $content = $this->process_page($fetched);
               $contentobj->SetPropertyValue('content_en', $content);
               $populated_content = true;
               $m_count += 1;
               }
            }
         if (!$populated_content)
            {
            if ($params['insert_lorem'] > 0)
               {
               $contentobj->SetPropertyValue('content_en',$loremstr);
               }
            else
               {
               $contentobj->SetPropertyValue('content_en', $name);
               }
			$p_count += 1;
            }
         if ($thisdepth > 0)
            {
            $contentobj->SetParentId($parents[$thisdepth-1]);
            }
         else
            {
            $contentobj->SetParentId(-1);
            }
         $contentobj->SetPropertyValue('searchable',
   				      get_site_preference('page_searchable',1));
         $contentobj->SetPropertyValue('extra1',
   				      get_site_preference('page_extra1',''));
         $contentobj->SetPropertyValue('extra2',
   				      get_site_preference('page_extra2',''));
         $contentobj->SetPropertyValue('extra3',
   				      get_site_preference('page_extra3',''));
         $contentobj->Save();
         $parents[$thisdepth] = $contentobj->Id();
         $contentops->SetAllHierarchyPositions();
         echo $this->Lang('created',$name)."<br />\n";
         }
      }
   echo "<br /><br /><strong>".$this->Lang('nag')."</strong><br />\n";
   $time_estimate = $p_count + $m_count * 5;
   $dollars = $time_estimate / 60 * 35;
   $dollars = sprintf('%0.2f',$dollars);
   echo $this->Lang('pages_done',array(($p_count+$m_count),$p_count,$m_count,$time_estimate,$dollars));
   echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
</form>
';
   }
?>