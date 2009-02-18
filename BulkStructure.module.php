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
    return '0.1';
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
    return "1.5";
  }

  function GetEventDescription ( $eventname )
  {
    return $this->Lang('event_info_'.$eventname );
  }
  
  function GetEventHelp ( $eventname )
  {
    return $this->Lang('event_help_'.$eventname );
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

  
}
?>
