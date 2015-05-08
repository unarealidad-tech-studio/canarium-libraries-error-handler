<?php

namespace ErrorHandler\Service;

use ErrorHandler\View\NotFoundStrategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NotFoundStrategyServiceFactory implements FactoryInterface
{
  
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('ErrorHandler\Config');

        return new NotFoundStrategy($config['template']);
    }
}
