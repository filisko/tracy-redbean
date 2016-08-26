<?php
namespace Filisko\Tracy;

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

class RedBeanBarPanelMiddleware
{
    /**
     * RedBeanBarPanel instance
     * @var RedBeanBarPanel
     */
    protected $panel;

    /**
    * Middleware invokable class
    *
    * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
    * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
    * @param  callable                                 $next     Next middleware
    *
    * @return \Psr\Http\Message\ResponseInterface
    */
    public function __invoke(Request $request, Response $response, $next)
    {
        $response = $next($request, $response);

        RedBeanBarPanel::boot($this->panel);

    	return $response;
    }

    /**
     * Set the panel
     * @param RedBeanBarPanel $panel
     */
    public function __construct(RedBeanBarPanel $panel)
    {
        $this->panel = $panel;
    }
}
