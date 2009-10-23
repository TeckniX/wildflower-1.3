<?php echo $html->doctype('xhtml-strict') ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php echo $html->charset(); ?>
	
	<title><?php echo $title_for_layout; ?></title>
	
	<meta name="description" content="" />
	
    <link rel="shortcut icon" href="<?php echo $this->webroot; ?>favicon.ico" type="image/x-icon" />
	
	<?php 
        echo
        // Load your CSS files here
        $html->css(array(
            '/wildflower/css/wf.main','/css/wildflower/calendar'
        )),
        // TinyMCE 
        // @TODO load only on pages with editor?
        $javascript->link('/wildflower/js/tiny_mce/tiny_mce');
    ?>
     
    <!--[if lte IE 7]>
    <?php
        // CSS file for Microsoft Internet Explorer 7 and lower
        echo $html->css('/wildflower/css/wf.ie7');
    ?>
    <![endif]-->
    
    <!-- JQuery Light MVC -->
    <script type="text/javascript" src="<?php echo $html->url('/' . Configure::read('Routing.admin') . '/assets/jlm'); ?>"></script>
    <script type="text/javascript">
    //<![CDATA[
        $.jlm.config({
            base: '<?php echo $this->base ?>',
            controller: '<?php echo $this->params['controller'] ?>',
            action: '<?php echo $this->params['action'] ?>', 
            prefix: '<?php echo Configure::read('Routing.admin') ?>',
            custom: {
                wildflowerUploads: '<?php echo Configure::read('Wildflower.uploadsDirectoryName'); ?>'
            }
        });
        
        tinyMCE.init($.jlm.components.tinyMce.getConfig());

        $(function() {
           $.jlm.dispatch(); 
	   $("ul.pages-list").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings';
			alert("My serial: "+$(this).sortable("serialize"));
			$.post("updateDB.php", order, function(theResponse){
				$("#contentRight").html(theResponse);
			}); 															 
		}								  
		});
        });
    //]]>
    </script>
    
</head>
<body>
 
<div id="header">
<<<<<<< HEAD:wildflower/views/layouts/admin_default.ctp
    <div id="header-wrap">
        <h1 id="site-title"><?php echo $html->link($siteName, '/', array('title' => __('View homepage', true))); ?></h1>
        
        <div id="login-info">
            <?php echo $htmla->link(__('Logout', true), array('controller' => 'wild_users', 'action' => 'logout'), array('id' => 'logout')); ?>
            
        </div>

        <?php 
            echo $navigation->create(array(
                __('Dashboard', true) => '/' . Configure::read('Wildflower.prefix'),
                __('Pages', true) => array('controller' => 'wild_pages'),
                __('Modules', true) => array('controller' => 'wild_sidebars'),
                __('Posts', true) => array('controller' => 'wild_posts'),
                __('Categories', true) => array('controller' => 'wild_categories'),
                __('Comments', true) => array('controller' => 'wild_comments'),
				__('Events', true) => array('controller' => 'wild_events'),
                __('Messages', true) => array('controller' => 'wild_messages'),
                __('Files', true) => array('controller' => 'wild_assets'),
                
                __('Users', true) => array('controller' => 'wild_users'),
                __('Site Settings', true) => array('controller' => 'wild_settings'),
                
            ), array('id' => 'nav'));
        ?>
=======
    <h1 id="site_title"><?php echo hsc($siteName); ?></h1>
    <?php echo $html->link('Site index', '/', array('title' => __('Visit ', true)  . FULL_BASE_URL, 'id' => 'site_index')); ?>
    
    <div id="login_info">
        <?php echo $htmla->link(__('Logout', true), array('controller' => 'users', 'action' => 'logout'), array('id' => 'logout')); ?>
>>>>>>> 853920ce542235a426a12ae3ae2e697a80080143:wildflower/views/layouts/admin_default.ctp
    </div>

    <ul id="nav">
        <li><?php echo $htmla->link(__('Dashboard', true), '/' . Configure::read('Routing.admin'), array('strict' => true)); ?></li>
        <li><?php echo $htmla->link(__('Pages', true), array('controller' => 'pages', 'action' => 'index')); ?></li>
        <li><?php echo $htmla->link(__('Modules', true), array('controller' => 'sidebars', 'action' => 'index')); ?></li>
        <li><?php echo $htmla->link(__('Posts', true), array('controller' => 'posts', 'action' => 'index')); ?></li>
        <li><?php echo $htmla->link(__('Categories', true), array('controller' => 'categories', 'action' => 'index')); ?></li>
        <li><?php echo $htmla->link(__('Comments', true), array('controller' => 'comments', 'action' => 'index')); ?></li>
        <li><?php echo $htmla->link(__('Messages', true), array('controller' => 'messages', 'action' => 'index')); ?></li>
        <li><?php echo $htmla->link(__('Files', true), array('controller' => 'assets', 'action' => 'index')); ?></li>
        <li class="nav_item_on_right"><?php echo $htmla->link(__('Users', true), array('controller' => 'users', 'action' => 'index')); ?></li>
        <li class="nav_item_on_right"><?php echo $htmla->link(__('Site Settings', true), array('controller' => 'settings', 'action' => 'index')); ?></li>
    </ul>
</div>

<div id="wrap">
    <div id="content">
        <div id="co_bottom_shadow">
        <div id="co_right_shadow">
        <div id="co_right_bottom_corner">
        <div id="content_pad">
            <?php echo $content_for_layout; ?>
        </div>
        </div>
        </div>
        </div>
    </div>
    
    <?php if (isset($sidebar_for_layout)): ?>
    <div id="sidebar">
        <ul>
            <?php echo $sidebar_for_layout; ?>
        </ul>
    </div>
    <?php endif; ?>
        
    <div class="cleaner"></div>
</div>

</body>
</html>

