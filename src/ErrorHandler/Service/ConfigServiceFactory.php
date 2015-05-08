<?php

namespace ErrorHandler\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class ConfigServiceFactory implements FactoryInterface
{
  
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        return $config['error_handler'];
    }
}
