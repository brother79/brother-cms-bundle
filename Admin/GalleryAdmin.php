<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brother\CMSBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\MediaBundle\Admin\GalleryAdmin as Admin;
use Sonata\AdminBundle\Form\FormMapper;

class GalleryAdmin extends Admin
{

    private $fixTrans=false;

    public function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        if (($id=='Gallery' || $id == 'Options')&& $this->fixTrans) {
            return $id;
        }
        return parent::trans($id, $parameters, $domain, $locale);
    }


    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->fixTrans = true;
        parent::configureFormFields($formMapper);
        $this->fixTrans = false;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        $listMapper->add('images4', null, array('template' => 'BrotherCMSBundle:Gallery:list_field_images.html.twig'));
    }


}
