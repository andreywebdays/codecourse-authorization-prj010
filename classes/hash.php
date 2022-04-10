<?php
/**
 * Hash class.
 */

class Hash{
    public static function unique(){
        return hash('sha256', uniqid());
    }
}