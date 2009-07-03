<?php
$lang['friendlyname'] = 'Bulk Structure Importer';
$lang['uninstalled'] = 'Module Uninstalled.';
$lang['installed'] = 'Module version %s installed.';
$lang['prefsupdated'] = 'Module preferences updated.';
$lang['error'] = 'Error!';
$lang['title_insert_lorem'] = 'Paragraphs of <em>Lorem Ipsum</em> to insert in each page';
$lang['none'] = 'None';
$lang['title_template_to_use'] = 'Template to use for pages';
$lang['title_file'] = 'Structure File';
$lang['title_field'] = 'Structure Definition';
$lang['title_structure_source'] = 'Structure Source';
$lang['title_source_chooser'] = 'Structure Data Source';
$lang['title_delete_content'] = 'Delete existing site content before import?';
$lang['title_delete_sure'] = 'THIS WILL DELETE ALL PAGES IN YOUR SITE! ARE YOU SURE YOU WANT TO DO THIS?';
$lang['title_delimiters_help'] = 'Delimiters are used to extract only the relevant piece of the migrated pages. They may be static tags, or regexes. Regexes are detected by starting and ending with "/". If the preferred delimiter is not found, the second will be tried. If that fails, the third will be tried.';
$lang['title_start_delimiter'] = 'Starting Delimiter';
$lang['title_end_delimiter'] = 'End delimiter';
$lang['title_best'] = 'Preferred';
$lang['title_second'] = '2nd Best';
$lang['title_third'] = '3rd Best';
$lang['title_remove_markup'] = 'Remove markup from migrated pages?';
$lang['title_allowed_tags'] = 'If removing markup, what tags should be left in migrated pages';
$lang['title_remove_scripts'] = 'Try to remove Javascript from migrated pages?';
$lang['title_fix_smarty'] = 'Try to fix things that will hose smarty?';
$lang['title_fix_smarty_help'] = 'Replace curly-braces with smarty delimiters';
$lang['title_cleanup'] = 'Migrated content cleanup options';
$lang['title_fix_internal_links'] = 'Fix internal content links';
$lang['title_internal_links_rel'] = 'Make fixed links site-relative';
$lang['title_fetch_assets'] = 'Fetch assets for migrated pages';
$lang['title_asset_location'] = 'Fetched asset location';
$lang['title_asset_url'] = 'Fetched asset URL';
$lang['title_asset_regex'] = 'Regular expression to use for testing assets linked by HREF';
$lang['title_fetch_assets_help'] = 'Retrieve images, etc, referenced by migrated page';
$lang['title_delimiters'] = 'Content Boundries';
$lang['created'] = 'Created page %s.';
$lang['bulk'] = 'Bulk Structure';
$lang['migrate_dir'] = 'migrated';
$lang['migrate'] = 'Migration Settings';
$lang['settings'] = 'Advanced Migration Settings';
$lang['deleting'] = 'Deleting existing content...';
$lang['no_start_delim'] = 'Cannot find any starting delimiter in page. Starting from top of page.';
$lang['no_end_delim'] = 'Cannot find any ending delimiter in page. Using to end of page.';
$lang['submit_go'] = 'Go!';
$lang['file'] = 'Upload File';
$lang['form'] = 'Enter into Form';
$lang['load_sample'] = 'Load an example structure';
$lang['fail_dir'] = 'Failed to create directory %s. Try checking permissions?';
$lang['title_migration_help'] = 'If you are using this tool to migrate an external site to CMSMS, you can use these settings to fine-tune the process. You will still doubtless need to do some clean-up by hand, but this should save you a lot of effort.';
$lang['upload_error'] = 'Upload error: %s';
$lang['moddescription'] = 'This module allows the bulk import of site structure.';
$lang['updated_settings'] = 'Updated Migration settings.';
$lang['nag'] = 'Annoying Nagging from the Author';
$lang['pages_done'] = '<p>You just populated a site with %s pages:<br />%s placeholders<br />%s migrated from an extant site; you also transfered %s site graphics/assets (%s bytes).</p><p>Assuming it takes you 1 minute to create a placeholder page, and 5 minutes to migrate a page from another site, <strong>you just saved %s minutes -- at US$35/hour, you just saved at least US$%s!</strong></p>';
$lang['changelog'] = '<ul>
<li>Version 0.4, June 2009 SjG, Improved handling of start/end tagging of fetched pages.</li>
<li>Version 0.3, Mar 2009 SjG, Added asset fetching and link reconciliation. This is actually becoming useful at this point.</li>
<li>Version 0.2, Feb 2009 SjG, Bug fixes with page alias generation, lots of site migration improvements, added annoying nagware because I am an annoying person.</li>
<li>Version 0.1, Feb 2009 SjG, Initial Version</li>
</ul>';
$lang['lorem'] = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut laoreet. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla pellentesque, lectus ac posuere ultrices, mauris nibh feugiat nunc, ac lobortis augue pede ac odio. Morbi consequat nulla et lacus. Donec pellentesque dapibus nisl. Nulla et arcu ut ipsum faucibus sagittis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis sit amet libero. Proin dapibus. Donec facilisis est sed magna. Vestibulum lorem lectus, venenatis ac, tempus quis, sollicitudin in, arcu. Donec sagittis neque. Quisque viverra. Sed volutpat. Quisque vitae justo et urna lacinia consequat. Mauris blandit, mauris vitae tempus adipiscing, libero mi ornare enim, eu mollis nisl nisl a nisi. Praesent condimentum, pede sed tempor hendrerit, enim lacus posuere ligula, a hendrerit est elit quis mauris. Ut pellentesque. Nullam faucibus, ipsum in accumsan euismod, ligula mi ullamcorper ante, non fermentum augue pede vitae nisi.</p>
|<p>Proin sit amet neque. Cras elementum, lacus id pharetra aliquam, lacus augue blandit nisl, eget egestas lectus eros quis purus. Sed neque. Nunc accumsan. Ut imperdiet, felis a porta tempus, elit erat ultricies velit, nec pulvinar nulla nisl nec est. Aenean ultricies nisi eu elit. In et nunc id ligula bibendum feugiat. Mauris vitae erat ut sem cursus gravida. Maecenas quam. Proin mollis varius ante. Sed in pede vitae sapien auctor pellentesque. Morbi vehicula porta eros. Pellentesque congue lacus nec erat.</p>
|<p>Etiam lobortis, enim in elementum aliquam, nulla nisl sagittis urna, et commodo dui pede eget turpis. Duis bibendum odio vitae nulla. Donec vel augue. Praesent adipiscing. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sit amet nisl in odio luctus sollicitudin. Fusce tristique venenatis metus. Etiam ut arcu. Vestibulum ornare nibh sit amet nibh. In pharetra. Maecenas non orci sed mi pulvinar molestie. Nulla facilisi. Pellentesque bibendum vulputate pede. Curabitur molestie nisi ac risus. Sed imperdiet ligula sit amet ligula egestas gravida. Mauris egestas elit at nulla. Curabitur convallis.</p>
|<p>Maecenas dui risus, aliquam dapibus, commodo sed, viverra eu, pede. Aenean lacus nisl, porttitor eget, ornare ac, varius facilisis, lorem. Suspendisse eu erat ut odio condimentum hendrerit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In in ipsum id pede viverra posuere. Integer eget neque bibendum elit volutpat ultricies. Cras commodo auctor elit. Pellentesque a neque ac metus varius rhoncus. Ut condimentum vestibulum nulla. Donec nulla. Ut aliquet quam sodales enim. Nunc tempus elit. Nulla sed pede quis sem faucibus aliquet. Pellentesque vehicula. Curabitur mollis.</p>
|<p>Sed ante. Pellentesque id mauris. Vestibulum semper mattis arcu. Fusce tempus nisl quis justo. Nunc vel risus quis neque ultrices sollicitudin. Sed eu est ut nunc scelerisque accumsan. Praesent id mauris. Sed tempus est nec ipsum. Nunc viverra magna non risus. Mauris felis libero, porttitor eu, viverra sed, sodales eu, metus. Aliquam eu ipsum. Sed sagittis. Sed cursus venenatis libero. Praesent eros magna, laoreet quis, dignissim sed, pretium sit amet, mi. Cras quam. Morbi eget risus. Nunc laoreet.</p>';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This is a tool for rapidly roughing out a site structure by populating pages. It is useful for rapid-prototyping sites with customers.</p>
<p>The module also has some pretty cool capabilities for migrating existing sites into CMSMS -- any web-accessible site content can be retrieved and placed into pages. It optionally can automatically retrieve assets such as images, documents, or other files from migrated sites, and correct the links so they work on your CMS site. If you have ever had to migrate a 500-page, content-rich site, you will appreciate this tool!</p>
<h3>How Do I Use It</h3>
<h4>Layout File</h4>
<p>Create a sample layout file. The syntax is very simple:</p>
<pre>
Page Title [Menu Text] {Page Alias} | http://www.sample.com/test.html, http://www.sample.com/test2.html
</pre>
<p>Specifically: List one site page per line. Leading hyphens
are used to represent site hierarchy. You can specify Menu Text by putting it in square brackets. You can specify Page Alias by putting it in curly braces. You can try to fetch one or
more pages from the internet to populate your new page by adding a | followed by an URL or comma-separated
URLs.</p>
<pre>
The Top Page [Top]|http://www.yoursite.com/index.html
-Subpage
--Subsubpage
-Subpage 2
Second Top Level
</pre>
<br />
<p>will create a hierarchy like:</p>
<ul>
<li>Top<ul><li>Subpage<ul><li>Subsubpage</li></ul><li>Subpage 2</li></ul></li>
<li>Second Top Level</li>
</ul>
<br /><br />
<p>Where the contents of the page "Top" will be everything within the &lt;body&gt; of
http://www.yoursite.com/index.html.</p>
<p>For a better example, look at planets.txt in the modules "example" directory.</p>
<h4>Usage</h4>
<p>In the admin, select a layout file or enter your format directly into the text area. Choose which template to use for the generated pages, and a number of
paragraphs of <em>lorem ipsum</em> to insert into a page. Then submit.</p>
<p>If you want to replace all of your site content with the new structure, click the checkbox. THIS WILL DELETE YOUR CONTENT! Do not check the box unless that is what you want.</p>
<p><em>Lorem Ispum</em> and/or URL-fetched content only go to the main content area on a page. If
you have specified <em>lorem ipsum</em> and URL fetch content, you will only get your URL-fetch
content. If you have not specified either, you will get the page name as the page content.</p>
<p>Most of the other page attributes (caching, searchability) go by your site defaults.
Page aliases are automatically generated.</p>
<h4>Migration Options</h4>
<p>If you are migrating pages, you can opt to also copy over assets referenced in those pages. Typically, they will be put in a "migration" directory under your site upload directory, but you can change that. Assets will be put into a subdirectory named for the page where they were found -- if an asset is found in more than one page, it will be put into a subdirectory called "common". You can also filter which kinds of assets are migrated by updating the regular expression.</p>
<p>Advanced migration options include choosing what tags delimit the content you want fetched (theoretically, this should be selectable on a per-page basis, but I did not realize this until too late). You can use whatever regular expression you can come up with. You can also selectively remove markup from migrated pages (this uses the PHP strip_tags function, which is actually kind of hit-or-miss, but better than nothing). You can also choose to remove embedded javascripts. By default, the migrator will replace curly braces with smarty-friendly tags, but you can disable this behavior too.</p>
<h3>Extra Disclaimer</h3>
<p>If you click the checkbox, this WILL DELETE YOUR SITE CONTENT before creating the new structure. 
<p>Even if you do not delete your content, this module adds content directly to your site.
It tries to do it at the root content level. It could cause trouble. Back up your database before using this. Do not say you were not warned.</p>
<p>This is not a sophisticated site population tool. This is more for rapidly prototyping
site content. For a site population tool, take a look at Alex Gomoloff\'s
<a href="http://dev.cmsmadesimple.org/projects/import-content">Import Content</a> module.</p>
<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report, please visit the Module Forge
<a href="http://dev.cmsmadesimple.org/projects/bulkstructure/">Bulk Structure</a>.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.</li>
<li>The author, SjG, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.</li>  
</ul>
<p>As per the GPL, this software is provided as-is. Please read the text
of the license for the full disclaimer.</p>

<h3>Copyright and License</h3>
<p>Copyright &copy; 2009, Samuel Goldstein <a href="mailto:sjg@cmsmodules.com">&lt;sjg@cmsmodules.com&gt;</a>. All Rights Are Reserved.</p>
<p>This module has been released under the <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a>. You must agree to this license before using the module.</p>
';
?>
