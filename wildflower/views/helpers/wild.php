<?php
App::import('Vendor', 'SimpleHtmlDom', array('file' => 'simple_html_dom.php'));

class WildHelper extends AppHelper {
	
	public $helpers = array('Html', 'Textile', 'Htmla');
	private $_isFirstChild = true;
	private $itemCssClassPrefix;
	
	/**
	 * @depracated Right now routes are so good the $html->link does all the magic
	 *
	 * Link to the Wildflower admin
	 *
	 * @TODO Support for all $html->link args, named params in route
	 */
	function link($label, $route, $attributes) {
		if (is_array($route)) {
			if (!isset($route['controller'])) {
				$route['controller'] = $this->params['controller'];
			}
			// Wf shortcut
			$route['controller'] = str_replace('wild_', '', $route['controller']);
			$_route = '/' . Configure::read('Wildflower.prefix') 
				. '/' . $route['controller'];
			if (isset($route['action'])) {
				$_route .= '/' . $route['action'];
			}
			unset($route['controller'], $route['action']);
			$_route .= '/' . join('/', $route);
			$route = $_route;
		}
		
		return $this->Html->link($label, $route, $attributes);
	}
	
	/**
	 * Get home (/) link tag with site name as label
	 *
	 * @param string $siteName
	 * @return string Link HTML
	 */
	function homeLink($siteName) {
	    $siteName = hsc($siteName);
	    return $this->Html->link("<span>$siteName</span>", '/', array('title' => 'Home'), null, null, false);
	}
	
	function keyWordsMetaTag($default = '') {
	    if (isset($this->params['pageMeta']['keywordsMetaTag']) && !empty($this->params['pageMeta']['keywordsMetaTag'])) {
	        return hsc($this->params['pageMeta']['keywordsMetaTag']);
	    }
	    
	    return $default;
	}
	
	/**
	 * Generate <body> tag with class attribute. Values are
	 * home-page, page-view, post-view.
	 *
	 * @return string
	 */
	function bodyTagWithClass() {
		if (!isset($this->params['Wildflower']['view'])) {
			return '<body>';
		}
		
	    extract($this->params['Wildflower']['view']);
	    $html = '<body';
	    if ($isHome) { 
	       $html .= ' class="home-page"'; 
	    } else if ($isPage) {
	       $pageSlug = '';
	       if (isset($this->params['current']['slug'])) {
              $pageSlug = ' ' . $this->params['current']['slug'] . '-page';           
	       }
	       $html .= ' class="page-view' . $pageSlug . '"'; 
	    } else if ($isPosts) { 
	       $html .= ' class="post-view"'; 
	    } else if (isset($this->params['current']['body_class'])) {
	       $html .= " class=\"{$this->params['current']['body_class']}\"";
	    }
	    $html .= '>';
        return $html;
	}
	
	function descriptionMetaTag($default = '') {
        if (isset($this->params['pageMeta']['descriptionMetaTag']) && !empty($this->params['pageMeta']['descriptionMetaTag'])) {
            return hsc($this->params['pageMeta']['descriptionMetaTag']);
        }
        
        return $default;
    }
    
    function menu($slug, $id = null) {
    	$items = $this->getMenuItems($slug);
    	$links = array();
    	foreach ($items as $item) {
    	    $label = hsc($item['label']);
    	    $slug = self::slug($item['label']);
    	    $classes = array('nav-' . $slug);
    	    $isCurrent = ($this->here === $this->Html->url($item['url']));
    	    if ($isCurrent) {
    	        $classes[] = 'current';
    	    }
    	    $links[] = '<li class="' . join(' ', $classes) . '">' . $this->Html->link("<span>$label</span>", $item['url'], array('escape' => false)) . '</li>';
    	}
    	$links = join("\n", $links);
    	if (is_null($id)) {
    	    $id = "wf_$slug";
    	}
    	return "<ul id=\"$id\">\n$links\n</ul>\n";
    }
    
    function getMenuItems($slug) {
        $WildMenu = ClassRegistry::init('WildMenu');
        $WildMenu->contain(array('WildMenuItem' => array('order' => 'WildMenuItem.order ASC')));
        $menu = $WildMenu->findBySlug($slug);
        return $menu['WildMenuItem'];
    }
    
    function submit($label = 'Save') {
        $button = '<div class="submit"><button type="submit"><span class="bl1"><span class="bl2">' . $label . '</span></span></button></div>';
        return $button;
    }
    
    private function _createListNode($label, $link, $childPages = null) {
        $slug = $this->_getMenuSlug($label);
        $label = hsc($label);
        $node = $this->Html->link("<span>$label</span>", $link, array('class' => "{$this->itemCssClassPrefix}$slug-link"), null, false);
    
        if ($childPages) {
            $node .= " {$this->menu($childPages)}";
        }
        
        $liAttr = array();
        if ($this->_isFirstChild) {
            $liAttr[] = 'first';
            $this->_isFirstChild = false;
        }
        if ($link == $this->here) {
        	$liAttr[] = 'current';
        }
        
        $liAttr = $this->getClassAttr($liAttr);
        return "<li$liAttr>$node</li>\n";
    }
    
    function processWidgets($html) {
        // Find the widget element
        $selector = '.wf_widget';
        $dom = str_get_html($html);
        $widgets = $dom->find($selector);
        $Widget = ClassRegistry::init('WildWidget');
        $view = ClassRegistry::getObject('view');
        foreach ($widgets as $widget) {
            $widgetId = $widget->id;
            $widgetClass = $widget->class;
            $instanceId = intval(r('wf_widget wf_widget_id_', '', $widgetClass));
            $data = $Widget->findById($instanceId);
            $data = json_decode($data['WildWidget']['config'], true);
            $replaceWith = $view->element('widgets/' . $widgetId, array('data' => $data));
            $replace = $widget->outertext;
            if ($widget->parent()->tag == 'p') {
                $replace = $widget->parent()->outertext;
            }
            // Replace the widget placeholder with real stuff
            $html = r($replace, $replaceWith, $html);
        }
        return $html;
    }
    
    function subPageNav() {
        $html = '<ul>';
        $pageSlug = end(array_filter(explode('/', $this->params['url']['url'])));
        $WildPage = ClassRegistry::init('WildPage');
        $WildPage->recursive = -1;
        
        // Get the parent page slug
        $url = $this->params['url']['url'];
        $slug = array_shift(explode('/', $url));
        $pages = $WildPage->findAllBySlugWithChildren($slug);

        if (empty($pages)) {
            return '';
        }
        
        // Build HTML
        foreach ($pages as $page) {
            $html .= '<li>' . $this->Htmla->link($page['WildPage']['title'], $page['WildPage']['url'], array('strict' => true)) . '</li>';
        }
        $html .= '</ul>';
        return $html;
    }
    
    function postsFromCategory($slug) {
        $WildCategory = ClassRegistry::init('WildCategory');
        $WildCategory->contain(array(
            'WildPost' => array(
                'conditions' => array(
                    'draft' => 0
                )
            ),
            'WildPost.WildUser'
        ));
        $category = $WildCategory->findBySlug($slug);
        $posts = $category['WildPost'];
        return $posts;
    }

}