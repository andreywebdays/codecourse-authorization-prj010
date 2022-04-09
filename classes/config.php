<?php
/**
 * Configuration helper class.
 */

class Config{
    public static function get($path = null){
        if($path){
            $config = $GLOBALS['config']; // We check if 'config' exists, then we check if 'mysql'exists in config and then we check if 'host' exists in mysql, and then we get the 127.0.0.1
            $path = explode('/', $path);

            // print_r($path);

            foreach($path as $bit){
                // echo $bit, ' ';

                if(isset($config[$bit])){
                    // echo 'Set';

                    $config = $config[$bit];
                }else{
                    echo 'Configuration option does not exist, please refer to your configuration file';
                    
                    return false;
                }
            }

            return $config;
        }

        return false;
    }
}