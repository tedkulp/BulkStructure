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
         $validalias = false;
         $vacount = 1;
         $subal = $alias;
         while (!$validalias)
            {
            $contentobj->SetAlias($subal);
            if ($contentobj->Alias() == '')
               {
               $subal = $alias.'-'.$vacount;
               $vacount += 1;
               }
            else
               {
               $validalias = true;
               }
            }
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
               $content = implode("\n",$fetched);
               $content = substr($content,stripos($content,'<body'));
               $content = substr($content,stripos($content,'>')+1);
               $content = substr($content,0,stripos($content,'</body'));
               $contentobj->SetPropertyValue('content_en', $content);
               $populated_content = true;
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
         //if ($depth > $prevdepth)
         //   {
            $parents[$thisdepth] = $contentobj->Id();
         //   }
         $contentops->SetAllHierarchyPositions();
         echo $this->Lang('created',$name)."<br />";
         }
      }
   }
?>