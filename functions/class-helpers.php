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
     * Public method: enqueue_assets()
     * 
     * Register assets passed as an argument using enqueue_assets() as a cb.
     * Not intended for production use as is.
     */
    public static function enqueue_assets( ...$fonts ) {

        $asset_handles = [];

        if ( ! isset( $fonts ) ) {
            echo '<script>console.log("ERROR: Jefferson\Herringbone\Helpers:enqueue_assets() FONT ARGS EMPTY")</script>';

        } else {

            $match = false;

            foreach ( $fonts as $font_name ) {
                switch ( $font_name ) {

                    case 'jetbrains':
                        wp_register_style( 'jetbrains', 'https://fonts.googleapis.com/css2?family=JetBrains+Mono&display=swap', false );
                        $asset_handles[] = 'jetbrains';
                        $match = true;
                        break;

                    default:
                        echo '<script>console.log("ERROR: Jefferson\\\Herringbone\\\Helpers:enqueue_assets() FONT NOT FOUND: ' . $font_name .  '")</script>';
                        break;
                }
            }

            if ( $match ) {

                foreach ( $asset_handles as $handle ) {
                    wp_enqueue_style( $handle );
                }
            }
        }
    }


    /**
     * Public method: output_on_front_end(  )
     * 
     * Print anything to the front end. Useful for quickly outputting variables or function
     * results when debugging/experimenting 🧪
     *
    */
    public static function output_on_front_end( ...$stuff_to_output ) {

        Helpers::enqueue_assets( 'jetbrains' );

        echo '<div style="font:1rem\'JetBrains Mono\',monospace;position:fixed;top:0;left:0;width:480px;max-width:100vw;max-height:calc(100vh - 16px);border:2px solid;resize:both;overflow:auto;white-space:pre;background:#fff;color:#000;filter: drop-shadow(2px 4px 6px #3339);">';
        echo '<pre style="font:inherit;">';
        echo '<b style="background:#333;color:#fff;"># Your output is served  👨‍🍳</b>';
        echo '<br><br><br>';

        foreach ( $stuff_to_output as $key => $value ) {
            var_dump( $value );
        }

        /* backtrace useful for some debugging
        echo '<br><span>==== debug_backtrace =====//</span><br><br>';
        var_dump(debug_backtrace());
        echo '<br></pre></div>';
        */
    }


    /**
     * Unregeister unused nav menu locations.
     * 
     * Unregister all unused nav menu locations that were registered by a theme and not currently
     * in use. Any menu locations which are actively being registered e.g. in functions.php will remain
     * so. Output displayed on front end. Warning: this function is destructive.
     */
    public static function unregister_unused_nav_menu_locations( $update_db = false ) {

        echo '<div style="position:fixed;top:0;left:0;max-width:100vw;max-height:100vh;overflow:auto;white-space:pre;background:#fff;color:#000;">';

        $menus = get_registered_nav_menus();
        $locations = get_nav_menu_locations();
        $orphaned_locations = [];
        $current_locations = [];

        //For each location...
        foreach ( $locations as $loc_key => $loc_value ) {

            $match = false;

            //...check for a matching nav menu registration
            foreach ( $menus as $men_key => $men_value ) {

                if ( $men_key == $loc_key ) {
                    $match = true;
                }
            }
            //add to this array if not matched...
            if ( $match === false ) {
                $orphaned_locations[$loc_key] = $loc_value;

            //...else add to this array
            } else {
                $current_locations[$loc_key] = $loc_value;
            }

        }

        //Start the Output
        echo '<pre>';

        // if update_db is true, attempt deletion of orphans and output results...
        if ( $update_db ) {

            echo 'Old Menu Locations <br><br>';
            var_dump( get_nav_menu_locations() );

            // set the database option and capture boolean result...
            $has_updated = set_theme_mod( 'nav_menu_locations', $current_locations );

            // ...success
            if ( $has_updated ) {
                echo '<br>SUCCESS: Menu locations updated.<br>';
                echo '<br>Deleted Locations: <br><br>';
                var_dump( $orphaned_locations );
            // ...fail
            } else {
                echo '<br>ERROR: set_theme_mod failed to update value.<br>';
                echo '<br>Perhaps there were no orphaned menus?<br>';
            }

        // ...else, output a list of orphaned locations but take no action.
        } else {

            echo 'DRY RUN - NO ACTION TAKEN<br><br>';

            echo '$orphaned_locations: <br><br>';
            var_dump( $orphaned_locations );

            echo '<br>$current_locations: <br><br>';
            var_dump( $current_locations );

        }
        echo '</pre></div>';
    }


    /**
     * Display registered nav menus.
     * 
     * Display all registered nav menus and locations for debugging/cleanup. Registered nav menus
     * are menus which have been registered to a location, but are not necessarily a current menu.
     * I'm not aware of a need to keep these in the db and ideally should be purged.
     * 
     * Use unregister_unused_nav_menu_locations() to cleanup the orphans.
     * 
     * Output displayed on front end.
     */
    public static function display_all_registered_nav_menu_objects() {

        echo '<div style="position:fixed;top:0;left:0;max-width:100vw;max-height:100vh;overflow:auto;white-space:pre;background:#fff;color:#000;">';
        echo '<pre>';

        echo '<br>';
        echo 'Registered nav menu locations';
        echo '<br>';
        echo '-----------------------------';
        echo '<br><br>';
        var_dump( get_nav_menu_locations() );
        echo '<br>';

        echo '<br>';
        echo 'Registered nav menu objects';
        echo '<br>';
        echo '---------------------------';
        echo '<br><br>';
        var_dump( get_registered_nav_menus() );
        echo '<br>';

        $locations = get_nav_menu_locations();
        $count = 0;
        echo '<br>';
        echo 'Location => menu object registrations';
        echo '<br>';
        echo '-------------------------------------';
        echo '<br><br>';
        echo 'KEY:';
        echo '<br>';
        echo '📍 = location';
        echo '<br>';
        echo '📜 = menu name';
        echo '<br><br><br><br>';

        foreach ( $locations as $loc => $value ) {

            $count = $count + 1;
            $menuobject = wp_get_nav_menu_object( $value );

            echo '---( #' . $count . ' )--';
            echo '<br><br>';

            if ( is_object( $menuobject ) ) {
                $name = $menuobject->name;
                echo '📍  "' . $loc . '"';
                echo '<br>';
                echo '📜  "' . $name . '"';
                echo '<br><br>';

                foreach ( $menuobject as $sub_key => $sub_value ) {
                    if ( is_array( $sub_key ) ) {
                        var_dump( $menuobject->$sub_key );
                        echo '<br>';
                    } else {
                        echo $sub_key . ' => ' . $sub_value;
                        echo '<br>';
                    }
                }

            } elseif ( is_array( $menuobject ) ) {
                $name = $menuobject["name"];
                echo '📍  "' . $loc . '"';
                echo '<br>';
                echo '📜  "' . $name;
                echo '<br><br>';

                foreach ( $menuobject as $sub_key => $sub_value ) {
                    if ( is_array( $sub_key ) ) {
                        var_dump( $menuobject->$sub_key );
                        echo '<br>';
                    } else {
                        echo $sub_key . ' => ' . $sub_value;
                        echo '<br>';
                    }
                }

            } else {
                echo '📍  "' . $loc . '"';
                echo '<br>';
                if ( $menuobject == '' ) {
                    echo '📜  [no menu registered]';               
                }
                else {
                    echo 'ERROR: menu object not recognised';
                    echo $menuobject;
                }
                echo '<br>';
            }
            echo '<br><br><br>';
        }
        echo '</pre></div>';
    }


}//Class end