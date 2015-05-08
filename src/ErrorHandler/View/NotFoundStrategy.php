<?php

namespace ErrorHandler\View;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ViewModel;
use ErrorHandler\Exception\NotFoundException;

class NotFoundStrategy implements ListenerAggregateInterface
{
 
    protected $template;

   
    protected $listeners = array();

 
    public function __construct($template)
    {
        $this->template = (string) $template;
    }

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), -5000);
    }
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

  
    public function setTemplate($template)
    {
        $this->template = (string) $template;
    }

    public function getTemplate()
    {
        return $this->template;
    }

  
    public function onDispatchError(MvcEvent $event)
    {
       
        $result   = $event->getResult();
        $response = $event->getResponse();

        if ($result instanceof Response || ($response && ! $response instanceof HttpResponse)) {
            return;
        }

       
        $viewVariables = array(
           'error'      => $event->getParam('error'),
           'identity'   => $event->getParam('identity'),
        );

        switch ($event->getError()) {
           
            case Application::ERROR_EXCEPTION:
                if (!($event->getParam('exception') instanceof NotFoundException)) {
                    return;
                }

                $viewVariables['reason'] = $event->getParam('exception')->getMessage();
                $viewVariables['error']  = 'error-unauthorized';
                break;
            default:
               
                return;
        }

        $model    = new ViewModel($viewVariables);
        $response = $response ?: new HttpResponse();

        $model->setTemplate($this->getTemplate());
        $event->getViewModel()->addChild($model);
        $response->setStatusCode(404);
        $event->setResponse($response);
    }
}
