<?php 
/**
 * DokuWiki Sidebar Template
 * @author Christopher Smith <chris@jalakai.co.uk>
 *
 * This template is the Dokuwiki Default Template with
 * a few alterations
 *
 * @link   http://wiki.splitbrain.org/wiki:tpl:templates
 * @author Andreas Gohr <andi@splitbrain.org>
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();

// include functions that provide sidebar functionality
@require_once(dirname(__FILE__).'/tplfn_sidebar.php');

// multitemplate capable
	if (isset($DOKU_TPL)==FALSE) $DOKU_TPL = DOKU_TPL; 
	if (isset($DOKU_TPLINC)==FALSE) $DOKU_TPLINC = DOKU_TPLINC;
	if (isset($CONF_TPL)==FALSE) $CONF_TPL = 'sidebar'; 
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>"
 lang="<?php echo $conf['lang']?>" dir="<?php echo $lang['direction']?>">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>
    [<?php echo strip_tags($conf['title'])?> // the last word]
    <?php tpl_pagetitle()?>
  </title>

  <?php tpl_metaheaders($CONF_TPL)?>

  <link rel="shortcut icon" href="<?php echo $DOKU_TPL?>images/favicon.ico" />

  <?php /*old includehook*/ @include(dirname(__FILE__).'/meta.html')?>
</head>

<body<?php if (tpl_getConf('enable')) echo " class='$sidebar_class'"; ?>>
<?php /*old includehook*/ @include(dirname(__FILE__).'/topheader.html')?>

<div class="dokuwiki">
  <?php html_msgarea()?>

  <!-- stylehead start -->
  <div class="stylehead">

    <!-- header start -->
    <div class="header">
	
	  <div class="tlw">
		<img src="<?php echo $DOKU_TPL?>images/thelastword.png"></img>
	  </div>

      <div class="logo">
        <?php 
			//tpl_link(wl(),$conf['title'],'name="dokuwiki__top" id="dokuwiki__top" accesskey="h" title="[ALT+H]"')
		?>
		<img src="<?php echo $DOKU_TPL?>images/twl-pesartain.com.png"></img>
	
		<div class="logoicons">	
			<?php 
				tpl_actionlink('admin','','','<img src="'.$DOKU_TPL.'images/16/admin.png" title="Admin"></img>');
				tpl_actionlink('profile','','','<img src="'.$DOKU_TPL.'images/16/user.png" title="Profile"></img>');
				tpl_actionlink('login','','','<img src="'.$DOKU_TPL.'images/16/logged_in.png" title="Log In"></img>');	
			?>
		</div>
      </div>
	    
      <div class="pagename">
        :: <?php tpl_link(wl($ID,'do=backlink'),tpl_pagename($ID)) ?> ~ 
		<div class="logoicons">
			<?php 
				tpl_link(wl('disclaimer'),'<img src="'.$DOKU_TPL.'images/20/info.png" title="Disclaimer"></img>','class="img16"');	
				tpl_link('feed.php?ns=blog&num=10&linkto=current&content=html','<img src="'.$DOKU_TPL.'images/rss.png" title="TLW RSS"></img>');
				tpl_actionlink('edit','','','<img src="'.$DOKU_TPL.'images/20/edit.png" class="img16" title="Edit"></img>');
				tpl_actionlink('history','','','<img src="'.$DOKU_TPL.'images/20/history.png" class="img16" title="Previous versions"></img>');
				
			?>
		</div>
      </div>


      <div class="clearer"></div>
    </div>
    <!-- header stop -->

    <?php /*old includehook*/ @include(dirname(__FILE__).'/header.html')?>
	
	<div class="toprip">&nbsp;</div>

  </div>
  <!-- stylhead stop -->

  <?php flush()?>

  <?php /*old includehook*/ @include(dirname(__FILE__).'/pageheader.html')?>

<!-- content start -->
<div class="content">

    <!-- breadcrumbs start -->
	<?php if($conf['breadcrumbs']){?>
	<div class="breadcrumbs">
	  <?php tpl_breadcrumbs()?>
	  <?php //tpl_youarehere() //(some people prefer this)
	  ?>
	</div>
	<?php }?>
    <!-- breadcrumbs stop -->

    <!-- trace start -->
	<?php if($conf['youarehere']){?>
	<div class="breadcrumbs">
	  <?php tpl_youarehere() ?>
	</div>
	<?php }?>
    <!-- trace stop -->

  <!-- sidebar start for karate corners -->
  <?php if (tpl_getConf('enable')) { ?>
  <div id="sidebar" class="cornerBox">
    <div class="corner TL"></div>
    <div class="corner TR"></div>
    <div class="corner BL"></div>
    <div class="corner BR"></div>
	<div class="cornerBoxInner">
      <?php tpl_userinfo()?>
      <div id="sidebar_content">
        <?php tpl_sidebar_content('blog_sidebar'); ?>
      </div>
      <br></br>
      <br></br>
      <hr style='clear: left;'></hr>
        <?php tpl_pageinfo()?>
      <hr style='clear: left;'></hr>
      <?php /*old includehook*/ @include(dirname(__FILE__).'/footer.html')?>
	</div>
    <!-- cornerBoxInner end -->
  </div>
  <?php } ?>
  <!-- sidebar stop -->

  <!-- page start -->
  <div class="page">

	<!-- wikipage start -->
	<?php tpl_content()?>
	<!-- wikipage stop -->	
  
  </div>
  <!-- page stop -->




</div>
<!-- content stop -->

  <div class="clearer">&nbsp;</div>

  <?php flush()?>

<div class="stylefoot">
  <div class="footrip1">&nbsp;</div>
  <?php tpl_pageinfo()?>
  <div class="footrip2">&nbsp;</div>
</div>

</div>
<!-- dokuwiki stop -->

<div class="no"><?php tpl_indexerWebBug()?></div>
</body>
</html>
