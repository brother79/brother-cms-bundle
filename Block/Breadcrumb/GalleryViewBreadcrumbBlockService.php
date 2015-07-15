<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brother\CMSBundle\Block\Breadcrumb;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\MediaBundle\Block\Breadcrumb\GalleryViewBreadcrumbBlockService as BaseGalleryViewBreadcrumbBlockService;

/**
 * BlockService for view gallery.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class GalleryViewBreadcrumbBlockService extends BaseGalleryViewBreadcrumbBlockService
{
    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        $menu = $this->getRootMenu($blockContext);

        if ($gallery = $blockContext->getBlock()->getSetting('gallery')) {
            $menu->addChild($gallery->getName());
        }

        return $menu;
    }
}
