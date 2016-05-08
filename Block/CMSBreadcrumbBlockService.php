<?php

namespace Brother\CMSBundle\Block;

use Brother\CMSBundle\Model\BasePage;
use Brother\CommonBundle\Route\AppRouteAction;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;

class CMSBreadcrumbBlockService extends BaseBreadcrumbMenuBlockService
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cms.bundle.block.breadcrumb';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRootMenu(BlockContextInterface $blockContext)
    {
        $menu = parent::getRootMenu($blockContext);

//        $menu->addChild('sonata_media_gallery_index', array(
//            'route'  => 'sonata_media_gallery_index',
//            'extras' => array('translation_domain' => 'SonataMediaBundle'),
//        ));

        return $menu;
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        $blockContext->setSetting('include_homepage_link', false);
        $menu = $this->getRootMenu($blockContext);
        /* @var $menu \Knp\Menu\MenuItem */
        $curPage = AppRouteAction::getCmsManager()->getCurrentPage();
        /* @var $curPage BasePage */
        if ($curPage && $curPage->getRouteName() != 'homepage') {
            foreach ($curPage->getParents() as $page) {
                /* @var $page BasePage */
                if ($page->getUrl() !== '/') {
                    $menu->addChild(AppRouteAction::translate($page->getName()), array(
                        'route' => $page,
//                    'extras' => array('translation_domain' => 'SonataMediaBundle'),
                    ));
                }
            }
            $menu->addChild(AppRouteAction::translate($curPage->getName()), array());
        }
        return $menu;
    }
}
