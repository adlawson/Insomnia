<?php

namespace Insomnia\Response\Plugin;

use \Insomnia\Pattern\Observer;

class SetCacheHeaders extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        \header( 'Last-Modified: ' . \gmdate( 'D, d M Y H:i:s' ) . ' GMT' );

        // Cache Headers ( used by reverse proxy caches )
        $ttl = $response->getTimeToLive();

        // Set caching time for response
        if( $ttl > 0 )
        {
            \header( 'Expires: ' . \gmdate( 'D, d M Y H:i:s', \strtotime( "+$ttl secs" ) ) . ' GMT' );
            \header( "Cache-Control max-age=$ttl, public" );
        }

        // Disable caching of response
        else {
            \header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
            \header( 'Cache-Control: no-store, no-cache, no-transform, must-revalidate' );
            \header( 'Cache-Control: post-check=0, pre-check=0', false );
            \header( 'Pragma: no-cache' );
        }
    }
}