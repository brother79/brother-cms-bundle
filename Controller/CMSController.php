<?php

namespace Brother\CMSBundle\Controller;

use Brother\CommonBundle\AppDebug;
use Sonata\PageBundle\Controller\PageController;
use Sonata\PageBundle\Entity\PageManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CMSController extends PageController
{
    public function menuAction()
    {
        $manager = $this->getCmsManager();
        /* @var $manager \Sonata\PageBundle\CmsManager\CmsPageManager */
        $pageManager = $this->get('sonata.page.manager.page');
        /* @var $pageManager \Brother\CMSBundle\Model\PageManager */

        $page = $pageManager->getMainPage($manager->getCurrentPage()->getSite(), '/');

        return $this->render('BrotherCMSBundle:CMS:_menu.html.twig', array(
            'pages' => $page ? $page->getChildren() : array()
        ));
    }
}
