<?php

namespace Matthias\SymfonyControllerAnnotation\Tests;

use Matthias\SymfonyControllerAnnotation\AbstractControllerAnnotationListener;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class TestListener extends AbstractControllerAnnotationListener
{
    private $processAnnotationHasBeenCalled = false;

    protected function getAnnotationClass()
    {
        return 'Matthias\SymfonyControllerAnnotation\Tests\TestAnnotation';
    }

    protected function processAnnotation(
        $annotation,
        FilterControllerEvent $event
    ) {
        $this->processAnnotationHasBeenCalled = true;
    }

    public function processAnnotationHasBeenCalled()
    {
        return $this->processAnnotationHasBeenCalled;
    }
}
