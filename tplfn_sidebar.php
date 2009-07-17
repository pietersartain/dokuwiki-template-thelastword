<?php 
/*
 * Provide navigation sidebar functionality to Dokuwiki Templates
 *
 * This is not currently part of the official Dokuwiki release
 *
 * @link   http://wiki.jalakai.co.uk/dokuwiki/doku.php?id=tutorials:dev:navigation_sidebar
 * @author Christopher Smith <chris@jalakai.co.uk>
 */

// sidebar configuration settings
tpl_loadConfig();

#$conf['sidebar']['enable'] = 1;               // 1 or true to enable sidebar functionality, 0 or false to disable it
#$conf['sidebar']['page'] = 'navigate';        // name of sidebar page
#$conf['sidebar']['layout'] = 'inside';        // inside (between button bars) or outside (full height of dokuwiki)
#$conf['sidebar']['orientation'] = 'left';     // left or right
#$conf['sidebar']['showeditbtn'] = 1;          // show a sidebar edit button IF USER HAS EDIT PERMISSION FOR SIDEBAR

$lang['btn_sidebaredit'] = 'edit sidebar';

// determine the sidebar class
$sidebar_class = "sidebar_".tpl_getConf('layout').'_'.tpl_getConf('orientation');

// recursive function to establish best sidebar file to be used
function getSidebarFN($ns, $file, $callingID) {

	// check for wiki page = $ns:$file (or $file where no namespace)
	$nsFile = ($ns) ? "$ns:$file" : $file;
	
	// As a preference, if this is the root directory, check to see if there's a namespace 
	// named the same as the page we're currently viewing with a sidebar in
//	if ($nsFile == $file) $nsFile = "$callingID:$file";
//	echo "$nsFile;$callingID;$ns;$file";

	if (file_exists(wikiFN($nsFile)) && auth_quickaclcheck($nsFile)) return $nsFile;
		
// remove deepest namespace level and call function recursively
	
	// no namespace left, exit with no file found	
	if (!$ns) return '';
	
	$i = strrpos($ns, ":");
	$ns = ($i) ? substr($ns, 0, $i) : false;	
	return getSidebarFN($ns, $file, $callingID);
}

// print a sidebar edit button - if appropriate
function tpl_sidebar_editbtn() {
    global $ID, $conf, $lang;

	// check sidebar configuration
    if (!tpl_getConf('showeditbtn') || !tpl_getConf('page')) return;
	
	// check sidebar page exists
	$fileSidebar = getSidebarFN(getNS($ID), tpl_getConf('page'), $ID);
	if (!$fileSidebar) return;
	
	// check user has edit permission for the sidebar page
	if (auth_quickaclcheck($fileSidebar) < AUTH_EDIT) return;
	
?>
    <div class="secedit">
      <form class="button" method="post" action="<?php echo wl($fileSidebar,'do=edit'); ?>" onsubmit="return svchk()">
        <input type="hidden" name="do" value="edit" />
        <input type="hidden" name="rev" value="" />
        <input type="hidden" name="id" value="<?php echo $fileSidebar; ?>" />
        <input type="submit" value="<?php echo $lang['btn_sidebaredit']; ?>" class="button" />
      </form>
    </div>
<?php
}

// display the sidebar
function tpl_sidebar_content($sidebar=null) {
	global $ID, $REV, $conf;
	
	// save globals
	$saveID = $ID;
	$saveREV = $REV;

	// discover file to be displayed in navigation sidebar	
	$fileSidebar = '';
	
	if ($sidebar != null) {
		$fileSidebar = $sidebar;
	} else {
		if (tpl_getConf('page')) {
			$fileSidebar = getSidebarFN(getNS($ID), tpl_getConf('page'), $ID);
		}
	}

	// determine what to display
	if ($fileSidebar) {
		$ID = $fileSidebar;
		$REV = '';
		print p_wiki_xhtml($ID,$REV,false);
	}
	else {
		global $IDX;
		html_index($IDX);
	}
		
	// restore globals
	$ID = $saveID;
	$REV = $saveREV;
}


if (!function_exists('tpl_pagename')) {

    require_once(DOKU_INC.'inc/parserutils.php');

    /**
     * Returns the name of the given page (current one if none given).
     *
     * If useheading is enabled this will use the first headline else
     * the given ID is printed.
     *
     * based on tpl_pagetitle in inc/template.php
     */
    function tpl_pagename($id=null){
      global $conf;
      if(is_null($id)){
        global $ID;
        $id = $ID;
      }
    
      $name = $id;
      if ($conf['useheading']) {
        $title = p_get_first_heading($id);
        if ($title) $name = $title;
      }
      return hsc($name);
    }
}

?>
