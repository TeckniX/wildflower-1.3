<?php

class CmsHelper extends AppHelper {
	
	public $helpers = array('Html');
	private $_isFirstChild = true;
	private $itemCssClassPrefix;
	
	/**
	 * Get a link tag to a post
	 *
	 * @deprecated: Sux
	 * @param unknown_type $label
	 * @param unknown_type $post
	 * @param unknown_type $options
	 * @return unknown
	 */
	function postLink($label, &$post, $options) {
		$index = WILDFLOWER_POSTS_INDEX;
		return $this->Html->link($label, "/$index/{$post['slug']}", $options);
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
    
    /**
     * Generate HTML list menu from nodes. Valid values for each node
     * are a string or a key value pair if you want to override the URL
     * generation.
     * 
     * Use magic value CHILD_PAGES_PLEASE to generate nested lists of 
     * subpages.
     *
     * Exaple:
     * $cms->menu(array(
     *      'About us' => CHILD_PAGES_PLEASE, 
     *      'Our Work', 
     *      'Read our blogs' => '/blog', 
     *      'Contact'
     * )); 
     * 
     * @param array $nodes
     * @return string
     * 
     * @TODO: too much DB requests - optimize
     */
    function menu($nodes = array(), $cssId = '', $itemCssClassPrefix = '') {
    	$this->itemCssClassPrefix = $itemCssClassPrefix;
        $html = '';
        
        // Reset first child flag
        $this->_isFirstChild = true;
        
        foreach ($nodes as $nodeKey => $nodeValue) {
            if ($nodeValue === CHILD_PAGES_PLEASE) {
                // Append all child pages
                $slug = $this->_getMenuSlug($nodeKey);
                $pages = $this->requestAction("/pages/getChildPagesForMenu/$slug");
                $link = "/$slug";
                $label = $nodeKey;
                if (empty($pages)) {
                    $html .= $this->_createListNode($label, $link);
                    continue;
                }
                $html .= $this->_createListNode($label, $link, $pages);
            } else if (is_integer($nodeKey) and is_string($nodeValue)) {
        	    // Only have label, generate URL from it
        	    $label = $nodeValue;
        	    $link = $this->_getMenuSlug($label);
        	    $link = "/$link";
        	    $html .= $this->_createListNode($label, $link);
        	} else if (is_string($nodeKey) and is_string($nodeValue)) {
        	    $label = $nodeKey;
        	    $html .= $this->_createListNode($label, $nodeValue);
        	} else if (is_string($nodeKey) and is_array($nodeValue)) {
        		// Parent link with nested links
        		if (count($nodeValue) != 2) {
        			continue;
        		}
        		$parentUrl = $nodeValue[0];
        		$childNodes = $nodeValue[1];
        		$label = $nodeKey;
        		$link = $parentUrl;
        		if ($link === null) {
                    $link = $this->_getMenuSlug($label);
        		}
                //$link = "/$link";
                $html .= $this->_createListNode($label, $link, $childNodes);
        	}
        }
        
        $ulAttr = $this->getIdAttr($cssId);
        
        return "<ul$ulAttr>$html</ul>\n";
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
    
    /**
     * Create a slug from a label
     *
     * @param string $label
     * @return string
     */
    private function _getMenuSlug($label) {
        return WildflowerHelper::slug(low($label), '-');
    }

}