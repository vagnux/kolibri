<?php


class manifest extends controller
{
    
    function index() {
        
        $m = new siteConfigModel();
        $m->load('barCode');
        
        $manifest['name'] = config::siteName();
        $manifest['short_name'] = config::siteName();
        $manifest['description'] = config::description();
        $manifest['display'] = 'minimal-ui';
        $manifest['background_color'] = '#000000';
        $manifest['theme_color'] = strtolower($m->getvalue());
        $manifest['start_url'] = config::siteRoot() . '/index.php';
        
        $m->load('logoSite');
        
        $icon['src'] = config::siteRoot() . "/media/" . $m->getvalue();
        $icon["sizes"]= "256x256";
        $icon["type"] = "image/png";
        $icons[] = $icon;
        
        $manifest['icons'] = $icons;
        
        page::addBody(json_encode($manifest));
        page::renderAjax();
        
    }
    
}

