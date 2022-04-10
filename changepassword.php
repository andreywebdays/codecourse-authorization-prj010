<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::exists()){
    // echo Input::get('username');
    if(Token::check(Input::get('token'))){
        // echo "CSRF Check: OK!";
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'password_current' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new_again' => array(
                'required' => true,
                'matches' => 'password_new'
            )
        ));

        if($validation->passed()){
        
            if(!password_verify(Input::get('password_current'), $user->data()->password)){
                echo 'Your current password is wrong!';
            }else{
                // echo 'OK!';
                try{
                    $user->update(array(
                        'password' => password_hash(Input::get('password_new'), PASSWORD_DEFAULT)
                    ));

                Session::flash('home', 'Your password has been changed.');
                
                Redirect::to('Index.php');

                }catch(Exception $e){
                    die($e->getMessage());
                }
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
        <label for="password_current">Current password: </label>
        <input type="password" name="password_current" id="password_current">
    </div>

    <div class="field">
        <label for="password_new">New password: </label>
        <input type="password" name="password_new" id="password_new">
    </div>

    <div class="field">
        <label for="password_new_again">Repeat new password: </label>
        <input type="password" name="password_new_again" id="password_new_again">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

    <input type="submit" value="Change">
</form>