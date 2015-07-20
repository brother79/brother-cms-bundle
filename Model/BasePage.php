<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 03.07.2015
 * Time: 10:36
 */

namespace Brother\CMSBundle\Model;

use Brother\CommonBundle\AppDebug;
use Brother\CommonBundle\Route\AppRouteAction;
use Sonata\PageBundle\Entity\BasePage as SonataBasePage;

abstract class BasePage extends SonataBasePage {

    protected $published = false;

    /**
     *
     */
    public function getMenuClass()
    {
        return AppRouteAction::getMenuClass($this);
    }

    public function getMenuTitle()
    {
        return $this->getName();
    }

    public function hasChildren()
    {
        return count($this->children);
    }

    /**
     * @return boolean
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @param boolean $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    private function toArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'title' => $this->getTitle(),
            'slug' => $this->getSlug(),
            'route' => $this->getRouteName(),
            'created_at' => $this->getCreatedAt()


        );
    }


} 