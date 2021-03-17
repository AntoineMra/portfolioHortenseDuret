<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Get sidebar.
 */
function get_tarteaucitron_dynamic_sidebar($index = 1) 
{
	if (!is_active_sidebar( $index )) {
		return;
	}
	
	$sidebar_contents = "";
	ob_start();
	dynamic_sidebar($index);
	$sidebar_contents = ob_get_contents();
	ob_end_clean();
	return $sidebar_contents;
}

/**
 * Display sidebars.
 */
function tarteaucitron_display_sidebars($content) {
	$before = '';
	$after = '';
	
	if (is_singular(array('post'))) {
        if (get_tarteaucitron_dynamic_sidebar('tarteaucitron-before-post') != "") {
            $before .= get_tarteaucitron_dynamic_sidebar('tarteaucitron-before-post');
            $before .= '<div class="tarteaucitronclear"></div>';
        }
        
        if (get_tarteaucitron_dynamic_sidebar('tarteaucitron-before-post-xl') != "") {
            $before .= get_tarteaucitron_dynamic_sidebar('tarteaucitron-before-post-xl');
            $before .= '<div class="tarteaucitronclear"></div>';
        }
        
        if (get_tarteaucitron_dynamic_sidebar('tarteaucitron-after-post') != "") {
            $after .= get_tarteaucitron_dynamic_sidebar('tarteaucitron-after-post');
            $after .= '<div class="tarteaucitronclear"></div>';
        }
        
        if (get_tarteaucitron_dynamic_sidebar('tarteaucitron-after-post-xl') != "") {
            $after .= get_tarteaucitron_dynamic_sidebar('tarteaucitron-after-post-xl');
            $after .= '<div class="tarteaucitronclear"></div>';
        }
    }
	
	if (is_singular() && !is_singular(array('post'))) {
        
        if (get_tarteaucitron_dynamic_sidebar('tarteaucitron-before-page') != "") {
            $before .= get_tarteaucitron_dynamic_sidebar('tarteaucitron-before-page');
            $before .= '<div class="tarteaucitronclear"></div>';
        }
        
        if (get_tarteaucitron_dynamic_sidebar('tarteaucitron-before-page-xl') != "") {
            $before .= get_tarteaucitron_dynamic_sidebar('tarteaucitron-before-page-xl');
            $before .= '<div class="tarteaucitronclear"></div>';
        }
        
        if (get_tarteaucitron_dynamic_sidebar('tarteaucitron-after-page') != "") {
            $after .= get_tarteaucitron_dynamic_sidebar('tarteaucitron-after-page');
            $after .= '<div class="tarteaucitronclear"></div>';
        }
        
        if (get_tarteaucitron_dynamic_sidebar('tarteaucitron-after-page-xl') != "") {
            $after .= get_tarteaucitron_dynamic_sidebar('tarteaucitron-after-page-xl');
            $after .= '<div class="tarteaucitronclear"></div>';
        }
    }
	
	
	return $before . $content . $after;
}
add_filter('the_content', 'tarteaucitron_display_sidebars', 50);

/**
 * Enregistrement des sidebars
 */
if (function_exists('register_sidebar') ) {
	
	if(get_option('tarteaucitronUUID', '') != '') {

    $allWidgetizedAreas = array("tarteaucitron-empty-1", "tarteaucitron-empty-2", "tarteaucitron-empty-3", "tarteaucitron-before-page", "tarteaucitron-before-page-xl", "tarteaucitron-after-page", "tarteaucitron-after-page-xl","tarteaucitron-before-post", "tarteaucitron-before-post-xl", "tarteaucitron-after-post", "tarteaucitron-after-post-xl");
    
    foreach ($allWidgetizedAreas as $WidgetAreaName) {
		$name = '[tarteaucitron.js] ';
		
		if (!preg_match('#^tarteaucitron-empty#', $WidgetAreaName)) {
		if(preg_match('#^tarteaucitron-before#', $WidgetAreaName)) {
			$name .= __('Before', 'tarteaucitronjs');
			$pos = __('For use before your content', 'tarteaucitronjs');
		} else {
			$name .= __('After', 'tarteaucitronjs');
			$pos = __('For use after your content', 'tarteaucitronjs');
		}
		
		if (preg_match('#-page#', $WidgetAreaName)) {
			$name .= ' ' . __('all content type except posts', 'tarteaucitronjs');
		} else {
			$name .= ' ' . __('posts', 'tarteaucitronjs');
		}
	
		if(preg_match('#-xl$#', $WidgetAreaName)) {
			$name .= ' - 100%';
			$class = 'tarteaucitronWidget100p';
		} else {
			$name .= ' - 4 x 25%';
			$class = 'tarteaucitronWidget25p';
		}
		} else {
			$name = '[tarteaucitron.js] ' . __('Unassigned', 'tarteaucitronjs') .' '.preg_replace('#^tarteaucitron-empty-#', '', $WidgetAreaName);
			$pos = __('For use with page and theme builder', 'tarteaucitronjs');
			$class = 'tarteaucitronWidget100p';
		}
		
        register_sidebar(array(
			'name' => $name,
			'before_widget' => '<div class="'.$class.'">',
			'after_widget' => '</div>',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
			'id' => $WidgetAreaName,
			'description' => $pos
        ));
    }
    }
}
