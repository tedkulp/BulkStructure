<?php
if (!isset($gCms)) exit;

set_time_limit(0);

$db = $gCms->GetDb();

if (empty($params['structure']) && !empty($_FILES[$id.'ulfile']['error']))
   {
   echo $this->Lang('upload_error',$_FILES[$id.'ulfile']['error']);
   }
else
   {
   if (isset($_FILES[$id.'ulfile']['tmp_name']) && !empty($_FILES[$id.'ulfile']['tmp_name']))
      {
      $listing = file($_FILES[$id.'ulfile']['tmp_name']);
      }
   else
     {
	 $listing = explode("\n",$params['structure']);
     }
   $page_cachable = ((get_site_preference('page_cachable',"1")=="1")?true:false);
   $active = ((get_site_preference('page_active',"1")=="1")?true:false);
   $showinmenu = ((get_site_preference('page_showinmenu',"1")=="1")?true:false);
   $metadata = get_site_preference('page_metadata');
   $userid = get_userid();
   if (isset($params['delete_content']) && $params['delete_content'] == '1')
		{
		$db = &$gCms->GetDb();
		$db->debug = true;
		echo "<p>".$this->Lang('deleting')."</p>\n";
		$query = 'delete from '.cms_db_prefix().'content';
		$dbresult = $db->Execute($query);
		$query = 'delete from '.cms_db_prefix().'content_props';
		$dbresult = $db->Execute($query);
		}
   $contentops =& $gCms->GetContentOperations();
   $lorem = explode('|',$this->Lang('lorem'));
   $loremstr = '';
   for($i=0;$i<$params['insert_lorem'];$i++)
      {
      $loremstr .= $lorem[$i];
      }

   $prevdepth = 0;
   $parents = array();
   $parent_paths = array();
   $p_count = 0;
   $a_count = 0;
   $a_len = 0;
   $m_count = 0;
   $listing = array_filter($listing, array($this,'remove_comments'));
   $assets = array();
   $asset_recon = array();
   $alias_list = array();
   $page_map = array();

   foreach ($listing as $thisPage)
      {
      $thisPage = trim(preg_replace('/\n|\r/','',$thisPage));
      if (!empty($thisPage))
         {
		 if (preg_match('/\[([^\]]+)\]/',$thisPage,$menutextarr))
			{
			$mtext = $menutextarr[1];
			$thisPage = preg_replace('/\[[^\]]+\]/','',$thisPage);
			}
		 else
		    {
			$mtext = '';
		    }
		 if (preg_match('/\{([^\}]+)\}/',$thisPage,$aliasarr))
			{
			$alias = $aliasarr[1];
			$thisPage = preg_replace('/\{[^\}]+\}/','',$thisPage);
			}
		 else
		    {
			$alias = '';
		    }

         $details = explode('|',$thisPage);
         $thisdepth =  $this->leading_substr_count($details[0],'-');
         $name = preg_replace('/^[-]+/','',$details[0]);
 		 if ($mtext == '')
			{
			$mtext = $name;
			}
        if ($alias == '')
			{
		    $alias = preg_replace('/[^a-zA-Z0-9]/','-',$mtext);
	        }
 		 $contentobj = $contentops->CreateNewContent('content');
         $contentobj->SetMenuText(trim($mtext));
         $contentobj->mName = trim($name);
         $alias = munge_string_to_url($alias, true);
		 // Make sure auto-generated new alias is not already in use on a different page
		 $alias = trim($alias);
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
			$flist = explode(',',$details[1]);
			$content = '';
			foreach ($flist as $thisFetch)
				{
				$thisFetch = trim($thisFetch);
			    $page_map[$thisFetch] = (isset($parent_paths[$thisdepth-1])?$parent_paths[$thisdepth-1] . '/':'') . $alias;
            	$fetched = $this->fetch_url($thisFetch);
				array_push($alias_list,$alias);
	            if ($fetched !== false)
	               {
				   $cont = '';
	               $cont = $this->process_page($fetched);
				   $this->identify_assets($thisFetch,$cont,$alias,$assets,$asset_recon,(isset($parent_paths[$thisdepth-1])?$parent_paths[$thisdepth-1] . '/':''));
				   $content .= $cont;
                   $m_count += 1;
	               }
				}
			   $contentobj->SetPropertyValue('content_en', $content);
               $populated_content = true;
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
         if ($thisdepth > 0 && isset($parents[$thisdepth-1]))
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
		 //Path doesn't exist in the object yet, so just grab it from the
		 //database
		 $parent_paths[$thisdepth] = $db->GetOne("SELECT hierarchy_path FROM ".cms_db_prefix()."content WHERE content_id = ?", array($contentobj->Id()));
         echo $this->Lang('created',$name)."<br />\n";
         }
      }
   if ($this->GetPreference('fetch_assets','0') == '1')
		{
  		list($a_count,$a_len) = $this->fetch_assets($assets);
		$this->reconcile_asset_links($asset_recon,$alias_list);
		}
	if ($this->GetPreference('fix_links','0') == '1')
		{
		$this->reconcile_internal_links($page_map, $alias_list);
		}
   echo "<br /><br /><strong>".$this->Lang('nag')."</strong><br />\n";
   $time_estimate = $p_count + $m_count * 5;
   $dollars = $time_estimate / 60 * 35;
   $dollars = sprintf('%0.2f',$dollars);
   echo $this->Lang('pages_done',array(($p_count+$m_count),$p_count,$m_count,$a_count,$a_len,$time_estimate,$dollars));
   echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
</form>
';
   }
