<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brother\CMSBundle\Listener;

use Sonata\PageBundle\Listener\ResponseListener as BaseResponseListener;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * This class redirect the onCoreResponse event to the correct
 * cms manager upon user permission.
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class ResponseListener extends BaseResponseListener
{
    public function onCoreResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        if (!$response->isRedirection()) {
            parent::onCoreResponse($event);
        }
    }
}
