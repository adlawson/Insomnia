<?php

namespace Insomnia\Kernel\Module\HTTP\Request\Plugin;

use \Insomnia\Pattern\Observer;

class ParamParser extends Observer
{
    /* @var $request \Insomnia\Request */
    public function update( \SplSubject $request )
    {
        // Trim params
        $requestParams = array_map( 'trim', $_REQUEST );
        
        // Remove blank params
        $requestParams = array_diff( $requestParams, array( '', null ) );
        
        // Merge in to request object
        $request->mergeParams( $requestParams );
    }
}