<?php

namespace Matthias\SymfonyControllerAnnotation\Tests;

class TestController
{
    /**
     * @TestAnnotation
     */
    public function actionHasATestAnnotation()
    {
    }

    public function actionHasNoAnnotation()
    {
    }
}
