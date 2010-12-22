<?php
#-------------------------------------------------------------------------
# Module: Bulkloader
# Version: 0.1, SjG
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2009 by Ted Kulp (ted@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/bulkloader/
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------

/**
 * Bulkloader class
 *
 * @author SjG
 * @since 0.1
 * @version $Revision$
 * @modifiedby $LastChangedBy:$
 * @lastmodified $Date:$
 * @license GPL
 **/
class BulkStructure extends CMSModule
{
  function GetName()
  {
    return 'BulkStructure';
  }
  
  function GetFriendlyName()
  {
    return $this->Lang('friendlyname');
  }

  function GetVersion()
  {
    return '0.5';
  }

  function GetHelp()
  {
    return $this->Lang('help');
  }
  
  function GetAuthor()
  {
    return 'SjG';
  }

  function GetAuthorEmail()
  {
    return 'sjg@cmsmodules.com';
  }
  
  function GetChangeLog()
  {
    return $this->Lang('changelog');
  }

  function IsPluginModule()
  {
    return false;
  }

  function HasAdmin()
  {
    return true;
  }

  function GetAdminSection()
  {
    return 'extensions';
  }

  function GetAdminDescription()
  {
    return $this->Lang('moddescription');
  }

  function GetDependencies()
  {
    return array();
  }

  function MinimumCMSVersion()
  {
    return "1.9";
  }

  function GetEventDescription ( $eventname )
  {
    return $this->Lang('event_info_'.$eventname );
  }
  
  function GetEventHelp ( $eventname )
  {
    return $this->Lang('event_help_'.$eventname );
  }
  

  function SuppressAdminOutput(&$request)
  {
	if (strpos($_SERVER['QUERY_STRING'],'get_sample') !== false)
        {
        return true;
        }
     return false;
  }

function fetch_url($url)
{
   if (function_exists('curl_init'))
      {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $data = curl_exec($ch);
      if (curl_errno($ch))
         {
         return false;
         }
      curl_close($ch);

      $results = preg_split('/[\r\n]+/',$data, -1, PREG_SPLIT_NO_EMPTY);
      if (!is_array($results))
         {
         return false;
         }
      else
         {
         $len =  count($results);
         if ($len < 1)
            {
            return false;
            }
         }
      return $results;
      }
   else
      {
      return file($url);
      }
}

function fetch_assets(&$asset_list)
{
	global $gCms;
	$count = 0;
	$len = 0;
	$asset_dir = $this->GetPreference('asset_path',$gCms->config['uploads_path'].DIRECTORY_SEPARATOR.$this->Lang('migrate_dir'));
	if (!file_exists($asset_dir))
		{
		if (!mkdir($asset_dir))
			{
				var_dump('failed');
			echo $this->Lang('fail_dir',$asset_dir);
			return false;
			}
		}
	foreach ($asset_list as $url=>$alias)
		{
			var_dump($url, $alias);
		$target_dir = $asset_dir.DIRECTORY_SEPARATOR.$alias;
		if (!file_exists($target_dir))
			{
			if (!mkdir($target_dir, 0777, true))
				{
					var_dump("failed to create dir");
				echo $this->Lang('fail_dir',$target_dir);
				return false;
				}
			}
		$fname = substr($url,strrpos($url,'/')+1);
		if (function_exists('curl_init'))
			{
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$tf = curl_exec($ch);
			if (curl_errno($ch))
				{
					//return false;
					//Move on
					continue;
				}
			curl_close($ch);
			}
		else
			{
			$tf = file_get_contents($url);
			}
		$handle = fopen($target_dir.DIRECTORY_SEPARATOR.$fname, "wb");
		fwrite($handle,$tf);
		fclose($handle);
		$len += mb_strlen($tf, '8bit');
		$count += 1;
		}	
	return array($count,$len);
}

function identify_assets($url,$content,$alias,&$assetlist,&$asset_recon,$parent_path = '')
{
	global $gCms;
	var_dump($parent_path . $alias);
	$srced_links = array();
	$base = parse_url($url);
	$destbase = $this->GetPreference('asset_url',$gCms->config['uploads_url'].'/'.$this->Lang('migrate_dir'));
    $asset_regex = '/'.$this->GetPreference('asset_regex','jpg|jpeg|gif|png|pdf|doc|rtf|swf|xls').'/i';
	if (preg_match_all('/src\s*=\s*\"*([^\"\s]+)[\"\s]/i', $content, $srced_links))
		{
		foreach($srced_links[1] as $link)
			{
			$abs_url = $this->reconcile_url($base['host'],$url,$link);
			if (strlen($abs_url) > 1)
				{
				if (isset($assetlist[$abs_url]) && $assetlist[$abs_url] != $alias)
					{
					$assetlist[$abs_url] = 'common';
					}
				else if (!isset($assetlist[$abs_url]))
					{
					$assetlist[$abs_url] = $parent_path . $alias;	
					}
				// mapped location
				if (strrpos($abs_url,'/') !== false)
					{
					$asset_recon[$link] = $destbase.'/'. $parent_path . $alias .'/'.substr($abs_url,strrpos($abs_url,'/')+1);
					}
				}
			}
		}
	if (preg_match_all('/href\s*=\s*\"*([^\"\s]+)[\"\s]/i', $content, $srced_links))
		{
		foreach($srced_links[1] as $link)
			{
			$v = strpos($link,'.');
			if ($v !== false)
				{
				$ext = substr($link,strrpos($link,'.')+1);
				if (preg_match($asset_regex,$ext))
					{
					$abs_url = $this->reconcile_url($base['host'],$url,$link);

					if (isset($assetlist[$abs_url]) && $assetlist[$abs_url] != $alias)
						{
						$assetlist[$abs_url] = 'common';
						}
					else if (!isset($assetlist[$abs_url]))
						{
						$assetlist[$abs_url] = $parent_path . $alias;	
						}
					// mapped location
					if (strrpos($abs_url,'/') !== false)
						{
						$asset_recon[$link] = $destbase.'/'.$parent_path.$alias.'/'.substr($abs_url,strrpos($abs_url,'/')+1);
						}
					}
				}
			}
		}

}

function makeContentLink($alias, $site_relative=true, $anchor='')
{
	global $gCms;
	
	if ($site_relative)
		{
		$root = parse_url($gCms->config["root_url"]);
		$base = (isset($root['path'])?$root['path']:'');
		}
	else
		{
		$base = $gCms->config["root_url"];
		}
	
	if ($gCms->config["assume_mod_rewrite"])
	{
		return($base."/".$alias.
			(isset($gCms->config['page_extension'])?$gCms->config['page_extension']:'.shtml').
			($anchor!=''?'#'.$anchor:''));
	}
	else
	{
		return($base."/index.php?".$gCms->config["query_var"]."=".$alias.($anchor!=''?'#'.$anchor:''));
	}
}

function makeAssetLink($url, $site_relative=true)
{
	global $gCms;
	
	if (!$site_relative)
		{
		return $url;
		}
	if (strpos($url,$gCms->config['root_url']) == 0)
		{
		$url = substr($url,strlen($gCms->config['root_url']));
		}
	if (substr($url,0,1) != '/')
		{
		$url = '/'.$url;
		}
	return $url;
}


function leading_substr_count($string,$delim)
{
	$i = 0;
	while (substr($string,$i,1) == $delim)
		{
		$i++;
		}
	return $i;
}


function reconcile_internal_links(&$page_map, $aliases)
{
	global $gCms;
	$contentops =& $gCms->GetContentOperations();
   
	foreach($aliases as $thisAlias)
		{
		$page = $contentops->LoadContentFromAlias($thisAlias);
		if ($page)
			{
			$cont = $page->GetPropertyValue('content_en');
			foreach($page_map as $target=>$replacement)
				{
				$new_targ = $this->makeContentLink($replacement,($this->GetPreference('links_rel','1') == '1'));
				$cont = str_replace($target,$new_targ,$cont);
				$rel_targ = substr($target,strpos($target,'/',3));
				$cont = str_replace($rel_targ,$new_targ,$cont);
				$nonwww = str_replace('www.','',$target);
				$cont = str_replace($nonwww,$new_targ,$cont);
				}
			$page->SetPropertyValue('content_en',$cont);
			$page->Save();
			}
		}

}

function reconcile_asset_links(&$asset_map, $aliases)
{
	global $gCms;
	$contentops =& $gCms->GetContentOperations();
   
	foreach($aliases as $thisAlias)
		{
		$page = $contentops->LoadContentFromAlias($thisAlias);
		if ($page)
			{
			$cont = $page->GetPropertyValue('content_en');
			foreach($asset_map as $target=>$replacement)
				{
				$new_targ = $this->makeAssetLink($replacement,($this->GetPreference('links_rel','1') == '1'));
				$cont = str_replace($target,$new_targ,$cont);
				}
			$page->SetPropertyValue('content_en',$cont);
			$page->Save();
			}
		}
}

function reconcile_url($base_host,$full_url,$link)
{
	$abs_url = '';
	if (substr($link,0,5) == 'http:')
		{
		// fully qualified URL
		$linkpieces = parse_url($link);
		if ($linkpieces['host'] == $base_host)
			{
			// local, so keep it
			$abs_url = $link;
			}
		}
	else if (substr($link,0,1) == '/')
		{
		// absolute URL, make canonical
		$abs_url = 'http://'.$base_host.$link;
		}
	else
		{
		// relative URL
		$rel = substr($full_url,0,strrpos($full_url,'/')).$link;
		$abs_url = 'http://'.$base_host.$rel;
		}
	
	return $abs_url;
}

function lc_tags($string)
{
	$i = 0;
	$conv = '';
	$intag = false;
	$inquote = false;
	while ($i < strlen($string))
		{
		$c = substr($string,$i,1);
		if (!$inquote && $c == '<')
			{
			$intag = true;
			}
		else if (!$inquote && $c == '"')
			{
			$inquote = true;
			}
		else if ($inquote && $c == '"')
			{
			$inquote = false;
			}
		else if ($intag && $c == '>')
			{
			$intag = false;
			}
		if ($intag && !$inquote)
			{
			$conv .= strtolower($c);
			}
		else
			{
			$conv .= $c;
			}
		$i+=1;
		}
	return $conv;
}

function remove_comments($inp)
{
	$s = substr($inp,0,1);
	if ($s == '#' || $s == ';')
		{
		return false;
		}
	return true;
}

function str_replace_limit($search,$replace,$subject,$limit)
	{
    $len=strlen($search);    
    $pos=0;
    $replacing = true;
	
    while ($replacing && $limit > 0)
		{
        $pos=strpos($subject,$search,$pos);
        if($pos!==false)
			{                
            $subject=substr($subject,0,$pos) . $replace .
            	substr($subject,$pos+$len);
			$limit -= 1;
        	}
		else
			{
			$replacing = false;
			}
        }
    return $subject;
	}


function process_page($in=array())
{
	$ret = implode("\n",$in);
	
	$i=1;
	$seekingdel = true;
	$foundsdel = false;
	while ($seekingdel)
		{
		if ($i == 1)
			{
			$sdel = $this->GetPreference('start_delimiter1','/<body[^>]*>/i');
			}
		else
			{
			$sdel = $this->GetPreference('start_delimiter'.$i);
			}
		if ($sdel != '')
			{
			if (substr($sdel,0,1) == '/' && substr($sdel,-1,1) == '/')
				{
				// regex;
				$ret = preg_replace($sdel,'X|XSTARTX|X',$ret);
				}
			else
				{
				// straight replace
				$ret = $this->str_replace_limit($sdel,'X|XSTARTX|X',$ret,1);
				}
			}
		if (strpos($ret,'X|XSTARTX|X') !== false)
			{
			$foundsdel = true;
			$seekingdel = false;
			}
		else
			{
			$i+=1;
			if ($i > 3)
				{
				$seekingdel = false;
				}
			}
		}
	if (!$foundsdel)
		{
		echo $this->Lang('no_start_delim');
		}

	$i=1;
	$seekingdel = true;
	$foundedel = false;
	while ($seekingdel)
		{
		if ($i == 1)
			{
			$edel = $this->GetPreference('end_delimiter1','/<\/body>/i');
			}
		else
			{
			$edel = $this->GetPreference('end_delimiter'.$i);
			}
		if ($edel != '')
			{
			if (substr($edel,0,1) == '/' && substr($edel,-1,1) == '/')
				{
				// regex;
				$ret = preg_replace($edel,'X|XENDX|X',$ret);
				}
			else
				{
				// straight replace
				$ret = $this->str_replace_limit($edel,'X|XENDX|X',$ret,1);
				}
			}
		if (strpos($ret,'X|XENDX|X') !== false)
			{
			$foundedel = true;
			$seekingdel = false;
			}
		else
			{
			$i+=1;
			if ($i > 3)
				{
				$seekingdel = false;
				}
			}
		}
	if (!$foundedel)
		{
		echo $this->Lang('no_end_delim');
		}

	if ($foundsdel)
		{
		$ret = substr($ret,stripos($ret,'X|XSTARTX|X')+11);
		}
	if ($foundedel)
		{
    	$ret = substr($ret,0,stripos($ret,'X|XENDX|X'));
		}
	if ($this->GetPreference('remove_scripts','0') == '1')
		{
		$ret = preg_replace('/<script/i','X|XSTARTX|X',$ret);
		$ret = preg_replace('/<\/script>/i','X|XENDX|X',$ret);
		while (strpos($ret,'X|XSTARTX|X') !== false)
			{
			$ret = substr($ret,0,strpos($ret,'X|XSTARTX|X')) .
				substr($ret,strpos($ret,'X|XENDX|X')+9);
			}
		}
	if ($this->GetPreference('remove_markup','0') == '1')
		{
		$ret = strip_tags($ret,$this->GetPreference('allowed_tags','<p><a><img><i><b><strong><em><ul><li><ol><sup><sub>'));
		}
	if ($this->GetPreference('lowercase_markup','0') == '1')
		{
		$ret = $this->lc_tags($ret);
		}
	if ($this->GetPreference('fix_smarty','0') == '1')
		{
		$ret = str_replace('{','X|XSTARTX|X',$ret);
		$ret = str_replace('}','X|XENDX|X',$ret);
		$ret = str_replace('X|XSTARTX|X','{ldelim}',$ret);
		$ret = str_replace('X|XENDX|X','{rdelim}',$ret);
		}
	if ($this->GetPreference('substitutions') != '')
		{
		$subs = explode('|',$this->GetPreference('substitutions'));
		foreach ($subs as $thisSub)
			{
			$sp = explode('~',$thisSub);
			if (isset($sp[0]) && isset($sp[1]))
				{
				$ret = str_replace($sp[0],$sp[1],$ret);
				}
			}
		}
	return $ret;
}
  
}
