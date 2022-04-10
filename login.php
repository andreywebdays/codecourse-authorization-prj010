<?php
require_once 'core/init.php';

if(Input::exists()){
    // echo Input::get('username');
    if(Token::check(Input::get('token'))){
        // echo "CSRF Check!";
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            )
        ));

        if($validation->passed()){

            $user = new User();

            $remember = (Input::get('remember') === 'on') ? true : false;

            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if($login){
                // echo 'Success!';
                Redirect::to('index.php');
            }else{
                echo 'Logging failed!';
            }

        }else{
            foreach($validation->errors() as $error){
                echo $error, '<br>';
            }
        }
    }
}

?>

<form action="" method="POST">
<div class="field">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username" autocomplete="off"> 
    </div>

    <div class="field">
        <label for="password">Create password: </label>
        <input type="password" name="password" id="password">
    </div>

    <div class="field">
        <label for="remember">Remember me: </label>
        <input type="checkbox" name="remember" id="remember" value="on"> 
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

    <input type="submit" value="Log in">
</form>