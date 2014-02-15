<?php

namespace Matthias\SymfonyControllerAnnotation;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

abstract class AbstractControllerAnnotationListener
{
    private $annotationReader;

    /**
     * Return the class of the annotation that should be present for
     * the current controller in order for the processAnnotation() method
     * to be called
     *
     * @return string
     */
    abstract protected function getAnnotationClass();

    /**
     * Will only be called if an annotation of the class returned by
     * getAnnotationClass() was found
     */
    abstract protected function processAnnotation(
        $annotation,
        FilterControllerEvent $event
    );

    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        $action = new \ReflectionMethod($controller[0], $controller[1]);

        $annotationClass = $this->getAnnotationClass();

        $annotation = $this
            ->annotationReader
            ->getMethodAnnotation(
                $action,
                $annotationClass
            );

        if (!($annotation instanceof $annotationClass)) {
            return;
        }

        $this->processAnnotation($annotation, $event);
    }
}
