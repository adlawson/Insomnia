<?php

namespace Insomnia\Controller;

use \Insomnia\Response\Format\ArrayRenderer,
    \Insomnia\Response\Format\JsonRenderer,
    \Insomnia\Response\Format\ViewRenderer,
    \Insomnia\Response\Code,
    \Insomnia\Session,
    \Insomnia\Response\Layout;

class NotFoundException extends \Exception {};

class ControllerAbstract
{
    protected $request,
              $session;

    public function __construct()
    {
        $this->setResponse( new \Insomnia\Response );
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setRequest( \Insomnia\Request $request )
    {
        $this->request = $request;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse( $response )
    {
        $this->response = $response;
    }

    public function preDispatch( $controller, $action )
    {
        //$this->selectRenderer( $controller, $action );
        $this->setResponseCode();
    }

    public function preRender( $controller, $action )
    {
        \Application\Maps\Layout::render( $this->request, $this->response );
    }

    private function setResponseCode()
    {
        if( $this->request->getMethod() == 'POST' )
            $this->response->setCode( Code::HTTP_CREATED );
    }

    private function selectRenderer( $controller, $action )
    {
        foreach( explode( ',', $this->request->getHeader( 'Accept' ) ) as $format )
        {
            switch( reset( explode( ';', $format ) ) )
            {
                case 'application/json':
                case '*/*':
                    $this->response->setRenderer( new JsonRenderer );
                    break 2;

                case 'application/xml':
                case 'text/xml':
                    $this->response->setRenderer( new XmlRenderer );
                    break 2;

                case 'application/xhtml':
                case 'text/html':
                    $renderer = new ViewRenderer;
                    $renderer->setLayoutPath( __DIR__ . '/../../../Application/Layout/' );
                    $renderer->setViewPath( __DIR__ . '/../../../Application/View/' );
                    $renderer->useView( $controller . '/' . $action );
                    $this->response->setRenderer( $renderer );
                    break 2;
            }
        }
    }
}