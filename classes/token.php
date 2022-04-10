<?php
/**
 * Token class to prevent Cross-Site Request Forgery (CSRF) is an attack that forces authenticated users to submit a request to a Web application against which they are currently authenticated.
 */

class Token{
    public static function  generate(){
        return Session::put(Config::get('session/token_name'), md5(uniqid()));
    }

    public static function check($token){
        $tokenName = Config::get('session/token_name');

        if(Session::exists($tokenName) && $token === Session::get($tokenName)){
            Session::delete($tokenName);
            return true;
        }

        return false;
    }
}