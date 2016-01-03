<?php

namespace Brother\CMSBundle\Controller;

use Sonata\PageBundle\Controller\PageController;

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
