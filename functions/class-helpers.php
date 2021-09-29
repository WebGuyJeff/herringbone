<?php
namespace Jefferson\Herringbone;

/**
 * A library of helper functions for WordPress.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */
class Helpers {

    /**
     * Public method: output_on_front_end()
     * 
     * Print anything to the front end. Useful for quickly outputting variables or function
     * results when debugging/experimenting 🧪
     *
     */
    public static function output_on_front_end( $stuff_to_output ) {

        $stuff_to_output = is_array( $stuff_to_output ) ||
                           is_object( $stuff_to_output )
                           ? var_dump( $stuff_to_output )
                           : $stuff_to_output;

echo <<<OUTPUT
<div style="position:fixed;top:0;left:0;max-width:100vw;max-height:100vh;overflow:auto;white-space:pre;background:#fff;color:#000;filter: drop-shadow(2px 4px 6px #3339);"><pre>
<b style="background:#333;color:#fff;"># Your output is served  👨‍🍳</b>
<br>
$stuff_to_output
</pre></div>
OUTPUT;

    }

}//Class end