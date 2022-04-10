<?php
require_once 'core/init.php';

// This is one way of doing it, but it is a lit bit messy and won't work if we'll change the name of a file in future:
// $GLOBALS['config']['mysql']['host'];

// The end result we want is something like:
// echo Config::get('mysql/host'); // 127.0.0.1

// This function lists all the usernames from the database:
// $users = DB::getInstance()->query('SELECT username FROM users');
// if($users->count()){
//     foreach($users as $user){
//         echo $user->username;
//     }
// }

// This is an example of helper function:
// $users = DB::getInstance()->get('users', array('username', '=', 'alex'));
// if($users->count()){
//     foreach($users as $user){
//         echo $user->username;
//     }
// }

// Just the connection to the DB.
// DB::getInstance();

// This is one way to create queries:
// DB::getInstance()->query("SELECT name FROM users WHERE username = 'Alex'"); // But we ll call them inside our db.php
// $user = DB::getInstance()->query("SELECT name FROM users WHERE username = ?", array('alex'));
// $user = DB::getInstance()->get('users', array('name', '=', 'alex'));

// $user = DB::getInstance()->query("SELECT * FROM users");

// if(!$user->count()){
//     echo 'No user';
// }else{
//     // foreach($user->results() as $user){
//     //     echo $user->username, '<br>';
//     // }
    
//     // echo $user->results()[0]->username;

//     echo $user->first()->username;
// }

// $userInsert = DB::getInstance()->insert('users', array(
//     'username' => 'Lance',
//     'password' => 'password123',
//     'salt' => 'salt'
// ));

// If($userInsert){
//     // Success
// }

// $userUpdate = DB::getInstance()->update('users', 1, array(
//     'password' => 'newpassword',
//     'name' => 'Gloria'
// ));

// $userUpdate = DB::getInstance()->query("UPDATE users SET password = 'newpassword2', name = 'Gloria2' WHERE id = 1");

if(Session::exists('home')){
    echo '<p>' . Session::flash('home') . '</p>';
}

// echo Session::get(Config::get('session/session_name'));

$user = new User();
// echo $user->data()->username;

if($user->isLoggedIn()){
    // echo 'Logged in';
    ?>
        <p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a>!</p>

        <ul>
            <li><a href="logout.php">Log out</a></li>
            <li><a href="update.php">Update profile</a></li>
            <li><a href="changepassword.php">Change password</a></li>
        </ul>
    <?php

    if($user->hasPermission('admin')){
        echo '<p>You are an Administrator.</p>';
    }

}else{
    echo '<p>You need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
}


