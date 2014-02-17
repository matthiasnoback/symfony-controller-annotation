<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$autoloader = require __DIR__.'/../vendor/autoload.php';
/* @var $autoloader Composer\Autoload\ClassLoader */

$autoloader->add('Matthias\SymfonyControllerAnnotation\Tests', 'tests/');

AnnotationRegistry::registerLoader(array($autoloader, 'loadClass'));
