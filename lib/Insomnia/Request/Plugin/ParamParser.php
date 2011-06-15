<?php

namespace Insomnia\Request\Plugin;

use \Insomnia\Pattern\Observer;

class ParamParser extends Observer
{
    /* @var $request \Insomnia\Request */
    public function update( \SplSubject $request )
    {
        $request->mergeParams( \array_filter( $_REQUEST ) );
        $request->mergeParams( \parse_url( $_SERVER['REQUEST_URI'] ) );
    }
}