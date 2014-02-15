<?php

namespace Matthias\SymfonyControllerAnnotation\Tests;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class AbstractControllerAnnotationListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TestListener
     */
    private $listener;

    protected function setUp()
    {
        $this->listener = new TestListener($this->createAnnotationReader());
    }

    /**
     * @test
     */
    public function it_uses_the_annotation_reader_to_see_if_an_action_has_the_right_annotation_and_then_processes_it()
    {
        $controller = array(new TestController(), 'actionHasATestAnnotation');

        $event = $this->createFilterControllerEvent($controller);

        $this->listener->onKernelController($event);

        $this->assertTrue($this->listener->processAnnotationHasBeenCalled());
    }

    /**
     * @test
     */
    public function it_does_nothing_when_the_controller_is_not_an_array_callable()
    {
        $controller = function() { };

        $event = $this->createFilterControllerEvent($controller);
        $this->listener->onKernelController($event);

        $this->assertFalse($this->listener->processAnnotationHasBeenCalled());
    }

    /**
     * @test
     */
    public function it_does_not_process_the_annotation_when_the_action_has_no_annotation()
    {
        $controller = array(new TestController(), 'actionHasNoAnnotation');

        $event = $this->createFilterControllerEvent($controller);

        $this->listener->onKernelController($event);

        $this->assertFalse($this->listener->processAnnotationHasBeenCalled());
    }

    private function createAnnotationReader()
    {
        return new AnnotationReader();
    }

    private function createFilterControllerEvent($controller)
    {
        $httpKernel = $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface');

        $request = $this
            ->getMockBuilder('Symfony\Component\HttpFoundation\Request')
            ->disableOriginalConstructor()
            ->getMock();

        return new FilterControllerEvent($httpKernel, $controller, $request, null);
    }
}
