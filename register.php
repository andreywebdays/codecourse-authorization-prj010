<?php
require_once 'core/init.php';

// var_dump(Token::check(Input::get('token')));

if(Input::exists()){
    // echo Input::get('username');
    if(Token::check(Input::get('token'))){
        // echo "CSRF Check!";
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            )
        ));

        if($validation->passed()){
            // echo 'Passed';
            // Session::flash('success', 'You registered successfully!');
            // header('Location: index.php');

            $user = new User();

            try{
                $user->create(array(
                    'username' => Input::get('username'),
                    'password' => password_hash(Input::get('password'), PASSWORD_DEFAULT),
                    'name' => Input::get('name'),
                    'joined' => date('Y-m-d H:i:s'),
                    'role' => 1
                ));

                Session::flash('home', 'You have been registered and can now log in!');
                // header('Location: index.php');
                // Redirect::to(404);
                Redirect::to('Index.php');

            }catch(Exception $e){
                die($e->getMessage());
            }
        }else{
            // print_r($validation->errors());
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
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off"> 
    </div>

    <div class="field">
        <label for="password">Create password: </label>
        <input type="password" name="password" id="password">
    </div>

    <div class="field">
        <label for="password_again">Repeat password: </label>
        <input type="password" name="password_again" id="password_again">
    </div>

    <div class="field">
        <label for="name">Your Name: </label>
        <input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')); ?>" autocomplete="off">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

    <input type="submit" value="Register">
</form>