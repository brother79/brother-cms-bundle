<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 11.03.2015
 * Time: 13:40
 */

namespace Brother\CMSBundle\Model;

use Brother\CommonBundle\AppDebug;
use Sonata\PageBundle\Site\HostPathSiteSelector as BaseHostPathSiteSelector;
use Symfony\Component\HttpFoundation\Request;

class HostPathSiteSelector extends BaseHostPathSiteSelector  {

    protected function getSites(Request $request)
    {
        return $this->siteManager->findBy(array('enabled' => true), array('isDefault' => 'DESC'));
    }


    public function retrieve()
    {
        if ($this->site == null) {
            $sites = $this->getSites(AppDebug::getRequest());
            $this->site = reset($sites);
        }
        return parent::retrieve(); 
    }

} 