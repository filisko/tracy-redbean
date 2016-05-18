<?php
namespace Filisko\Tracy;

class RedBeanBarPanelMiddleware
{
    private $bar;
    private $rb;

    /**
    * Middleware invokable class
    *
    * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
    * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
    * @param  callable                                 $next     Next middleware
    *
    * @return \Psr\Http\Message\ResponseInterface
    */
    public function __invoke($request, $response, $next)
    {
        $response = $next($request, $response);
        $panel = new RedBeanBarPanel($this->rb->getLogger());
        $this->bar->addPanel($panel);

    	return $response;
    }

    public function __construct(\Tracy\Bar $bar, \RedBeanPHP\Driver\RPDO $rb)
    {
        $this->bar = $bar;
        $this->rb = $rb;
    }
}
