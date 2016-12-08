<?php 
require_once 'app/start.php';

if (input::exists()) {
       
    $validate = new validate(); 
    
    $validate->check($_POST, [
    'name' => [
        'required' => true,
        'min' => 2,
        'max' => 20
    ],
    'username' => [
        'required' => true,
        'min' => 2,
        'max' => 20,
        'unique' => 'users'
    ],
    'password' => [
        'required' => true,
        'min' => 3
    ],
    'password_again' => [
        'required' => true,
        'matches' => 'password'
    ]
   
    ]);
    
    if($validate->passed()) {
        Session::flash('ok','udalo sie zajestrowac');
        header('location: index.php');
    } else {
        foreach($validate->errors() as $error) {
            echo $error . "<br>";   
        }   
    }
    
}

?>


                            <!--szkic formularza -->
<html>
<body>
<container>
    <form action="" method="post">
        <div>
            <input type="text" name="name" value="<?php echo esc(input::get('name'));?>" id="name" placeholder="imie" autocomplete="off">
        </div>

        <div>
        <input type="text" name="username" id="username" value="<?php echo esc(input::get('username'));?>" placeholder="login" autocomplete="off">
        </div> 

        <div>
            <input type="password" name="password" id="password" placeholder="haslo" autocomplete="off">
        </div> 

        <div>
            <input type="password" name="password_again" id="password_again" value="" placeholder="haslo ponownie" autocomplete="off">
        </div>

        <div>
        <input type="submit" value="rejestruj">
        </div>
        <input type="hidden" name="token" value="">
    </form>
</container>
</body>
</html>

<style>
body {
    margin: 0;
    padding: 10px;
    background-color: gray;
    color: white;
    font-size: 20px;
}
container {
    max-width: 1200px;
    display: block;
    margin: 0 auto;
    }
    
div {
    padding: 5px;
    text-align: center;
    }
    
input[type=text],
input[type=password] {
    width: 300px;
    font-size: 20px;
    color: black;
    padding: 10px;
    border-radius: 5px;
    background-color: #efefef;
    border: 2px solid #ddd;
    outline: none;
}   
    
input[type=submit]
{
    width: 300px;
    background-color: #36b03c;
    font-size: 20px;
    color: white;
    padding: 15px 10px;
    margin-top: 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    letter-spacing: 2px;
}    
</style>