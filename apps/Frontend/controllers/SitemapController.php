<?php

namespace Frontend\Controllers;

class SitemapController extends ControllerBase
{

    public function indexAction()
        {

            $this->response->setContentType("application/xml");

            $sitemap = new \DOMDocument("1.0", "UTF-8");

            $urlset = $sitemap->createElement('urlset');
            $urlset->setAttribute('xmlns'    , 'http://www.sitemaps.org/schemas/sitemap/0.9');
            $urlset->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
            $sitemap->appendChild($urlset);

            $url = $sitemap->createElement('url');
            $url->appendChild($sitemap->createElement('loc', 'http://www.'.$_SERVER['SERVER_NAME']));
            $url->appendChild($sitemap->createElement('changefreq', 'daily'));
            $url->appendChild($sitemap->createElement('priority', '1.0'));
            $urlset->appendChild($url);

            $url = $sitemap->createElement('url');
            $url->appendChild($sitemap->createElement('loc', 'http://www.'.$_SERVER['SERVER_NAME'].'/sobre-nos'));
            $url->appendChild($sitemap->createElement('changefreq', 'daily'));
            $url->appendChild($sitemap->createElement('priority', '1.0'));
            $urlset->appendChild($url);

            $url = $sitemap->createElement('url');
            $url->appendChild($sitemap->createElement('loc', 'http://www.'.$_SERVER['SERVER_NAME'].'/investimentos'));
            $url->appendChild($sitemap->createElement('changefreq', 'daily'));
            $url->appendChild($sitemap->createElement('priority', '1.0'));
            $urlset->appendChild($url);

            $url = $sitemap->createElement('url');
            $url->appendChild($sitemap->createElement('loc', 'http://www.'.$_SERVER['SERVER_NAME'].'/lancamentos'));
            $url->appendChild($sitemap->createElement('changefreq', 'daily'));
            $url->appendChild($sitemap->createElement('priority', '1.0'));
            $urlset->appendChild($url);

            $url = $sitemap->createElement('url');
            $url->appendChild($sitemap->createElement('loc', 'http://www.'.$_SERVER['SERVER_NAME'].'/portfolio'));
            $url->appendChild($sitemap->createElement('changefreq', 'daily'));
            $url->appendChild($sitemap->createElement('priority', '1.0'));
            $urlset->appendChild($url);

            $url = $sitemap->createElement('url');
            $url->appendChild($sitemap->createElement('loc', 'http://www.'.$_SERVER['SERVER_NAME'].'/sua-obra'));
            $url->appendChild($sitemap->createElement('changefreq', 'daily'));
            $url->appendChild($sitemap->createElement('priority', '1.0'));
            $urlset->appendChild($url);

            $url = $sitemap->createElement('url');
            $url->appendChild($sitemap->createElement('loc', 'http://www.'.$_SERVER['SERVER_NAME'].'/contato'));
            $url->appendChild($sitemap->createElement('changefreq', 'daily'));
            $url->appendChild($sitemap->createElement('priority', '1.0'));
            $urlset->appendChild($url);

            $this->response->setContent($sitemap->saveXML());

            $this->view->disable();
            $this->response->send();

        }

}
