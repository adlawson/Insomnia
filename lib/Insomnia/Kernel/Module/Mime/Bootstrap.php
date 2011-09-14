<?php

namespace Insomnia\Kernel\Module\Mime;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

class Bootstrap extends KernelModule
{
    public function bootstrap( Kernel $kernel )
    {
        $kernel->addDispatcherPlugin( new Dispatcher\Plugin\ViewAnnotationReader );
        $kernel->addResponsePlugin( new Response\Plugin\ContentTypeSelector );
        $kernel->addResponsePlugin( new Response\Plugin\RendererSelector );
    }
}