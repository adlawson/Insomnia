<?php

namespace Application\Router;

use \Insomnia\Request,
    \Insomnia\Router\Route,
    \Insomnia\Router\RouterAbstract;

class ApplicationRouter extends RouterAbstract
{
    public function __construct( Request $request )
    {
        parent::__construct( $request );

        $params = array();
        $params[ 'version' ]    = 'v\d+';
        $params[ 'controller' ] = '[a-z]+';
        $params[ 'id' ]         = '\w+';
        
        $route = new Route( '/' );
        $route->setDefault( 'controller', 'index' )
              ->setAction( 'POST',   'create' )
              ->setAction( 'GET',    'index' )
              ->setAction( 'ANY',    'index' );
        $this[] = $route;

        $route = new Route( '/:id' );
        $route->setDefault( 'controller', 'index' )
              ->setParams( $params )
              ->setAction( 'GET',    'read' )
              ->setAction( 'PUT',    'update' )
              ->setAction( 'DELETE', 'delete' );
        $this[] = $route;

        $route = new Route( '/:version/:controller' );
        $route->setParams( $params )
              ->setAction( 'POST',   'create' )
              ->setAction( 'GET',    'index' );
        $this[] = $route;

        $route = new Route( '/:version/:controller/:id' );
        $route->setParams( $params )
              ->setAction( 'GET',    'read' )
              ->setAction( 'HEAD',   'read' )
              ->setAction( 'PUT',    'update' )
              ->setAction( 'DELETE', 'delete' );
        $this[] = $route;
    }
}