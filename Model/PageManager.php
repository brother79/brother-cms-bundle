<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 11.03.2015
 * Time: 14:32
 */

namespace Brother\CMSBundle\Model;

use Brother\CommonBundle\AppDebug;
use Doctrine\ORM\NoResultException;
use Sonata\PageBundle\Entity\PageManager as BasePageManager;
use Sonata\PageBundle\Model\Page;
use Sonata\PageBundle\Model\PageInterface;
use Sonata\PageBundle\Model\SiteInterface;

class PageManager extends BasePageManager
{

    private $pages = null;

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $c = $criteria;
        $query = $this->getRepository()->createQueryBuilder('p');
//            ->orderBy('s.isDefault', 'DESC')
//            ->andWhere('s.enabled=true')
//            ->getQuery()->useResultCache(true, 3600)->execute();
        /* @var $query \Doctrine\ORM\QueryBuilder */
        foreach ($c as $k => $v) {
            switch ($k) {
                case 'url':
                    $query->andWhere('p.url=:url')->setParameter('url', $v);
                    unset($c[$k]);
                    break;
                case 'site':
                    $query->andWhere('p.site=:site')->setParameter('site', $v);
                    unset($c[$k]);
                    break;
                case 'routeName':
                    $query->andWhere('p.routeName=:routeName')->setParameter('routeName', $v);
                    unset($c[$k]);
                    break;
                case 'id':
                    $query->andWhere('p.id=:id')->setParameter('id', $v);
                    unset($c[$k]);
                    break;
                default:
                    AppDebug::_dx($c, $k);
            }
        }
        if ($orderBy) {
            AppDebug::_dx($orderBy);
        }

        if (count($c) || $orderBy) {
            return parent::findOneBy($criteria, $orderBy);
        } else {
            try {
                return $query->setMaxResults(1)->getQuery()->useResultCache(true, 300, 'page_')->getSingleResult();
            } catch (NoResultException $e) {
                return null;
            }
        }
    }


    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
//        AppDebug::_dx($criteria);
        if ($criteria == array('enabled' => 1)) {
            $repository = $this->getRepository();
            /* @var $repository \Doctrine\ORM\EntityRepository */
            return $repository->createQueryBuilder('s')
                ->orderBy('s.isDefault', 'DESC')
                ->andWhere('s.enabled=true')
                ->getQuery()->useResultCache(true, 300)->execute();
        }
        return parent::findBy($criteria, $orderBy, $limit, $offset); // TODO: Change the autogenerated stub
    }

    public function getMainPage(SiteInterface $site, $url = '/')
    {
        foreach ($this->loadPagesEnabled($site) as $page) {
            if ($page->getUrl() == $url) {
                return $page;
            }
        }
        return null;
    }

    /**
     * @param SiteInterface $site
     * @return BasePage[]
     */
    public function loadPagesEnabled(SiteInterface $site)
    {
        if ($this->pages == null) {
            $this->pages = $this->getEntityManager()
                ->createQuery(sprintf('SELECT p FROM %s p INDEX BY p.id WHERE p.site = %d and p.published=1 ORDER BY p.position ASC', $this->class, $site->getId()))
                ->useResultCache(true, 300)
                ->execute();
            /* @var $Pages PageInterface[] */
            foreach ($this->pages as $page) {
                /* @var $page Page */
                $parent = $page->getParent();
                /* @var $parent Page */

                $page->disableChildrenLazyLoading();
                if (!$parent) {
                    continue;
                }
                if (isset($this->pages[$parent->getId()])) {
                    $this->pages[$parent->getId()]->disableChildrenLazyLoading();
                    $this->pages[$parent->getId()]->addChildren($page);
                }
            }
        }
        return $this->pages;
    }


} 