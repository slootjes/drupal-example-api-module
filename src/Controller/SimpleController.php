<?php

namespace Drupal\api\Controller;

use Drupal\controller_annotations\Configuration\Route;
use Drupal\controller_annotations\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("simple/")
 */
final class SimpleController
{

    /**
     * @Route("string")
     * @Security(access=true)
     */
    public function stringAction()
    {
        return 'string';
    }

    /**
     * @Route("array")
     * @Security(access=true)
     */
    public function arrayAction()
    {
        return ['foo', 'bar'];
    }

    /**
     * @Route("exception")
     * @Security(access=true)
     */
    public function exceptionAction()
    {
        throw new \LogicException('something got messed up');
    }

    /**
     * @Route("not-found")
     * @Security(access=true)
     */
    public function notFoundAction()
    {
        throw new NotFoundHttpException('entity not found');
    }
}
