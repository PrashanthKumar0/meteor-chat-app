<?php
    
    include_once __DIR__.'/services/config.php';
    include_once __DIR__.'/services/database_handler.php';
    
    $roomName='public';
    $u_name='user_'.rand(0,9999); //maybe implement anonymous user later
    if(isset($_REQUEST['u_name']) && !isset($_COOKIE[COOKE_USER_NAME_KEY])){
        if(!empty($_REQUEST['u_name'])){
            setcookie(COOKE_USER_NAME_KEY,htmlentities($_REQUEST['u_name']),COOKIE_EXPIRATION_TIME,'/');
        }
    }
    if(isset($_REQUEST['roomName'])){
        if(!empty($_REQUEST['roomName'])){
            $roomName=$_REQUEST['roomName'];
            setcookie(COOKIE_ROOM_NAME_KEY,$_REQUEST['roomName'],COOKIE_EXPIRATION_TIME,'/');
        }
    }
    if(isset($_COOKIE[COOKIE_ROOM_NAME_KEY])){
        $roomName=$_COOKIE[COOKIE_ROOM_NAME_KEY];
    }
    if(!isset($_COOKIE[COOKIE_UNIQID_NAME])){
        setcookie(COOKIE_UNIQID_NAME,uniqid(COOKIE_UNIQID_NAME),COOKIE_EXPIRATION_TIME,'/');
    }
    if(!isset($_COOKIE[COOKE_USER_NAME_KEY])){
        @header('location:./register.php');
        //incase header fails
        echo '<script> onload=function(){window.location.replace("./register.php")}</script>';
        
        die();
    }else{
        $u_name=$_COOKIE[COOKE_USER_NAME_KEY];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    
    <link rel="stylesheet" href="./css/components/appBar.css">
    <link rel="stylesheet" href="./css/animations/basic-animations.css">
    <link rel="stylesheet" href="./css/components/chatScreen.css">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <!-- <link rel="stylesheet" href="./css/font awesome/css/fontawesome.min.css"> -->
    <link rel="stylesheet" href="./css/font awesome/css/all.css">


    <style>
        input[type="file"]{
            display:none;
        }
    </style>

</head>
<body>
    
    <div class="appBar">
        <span class="appBarDrawerIcon"><i class="fas fa-bars"></i></span> 
        <span class="appBarAppName">
            <!-- SSE_CHAT_APP -->
            Meteor Chat
        </span>
        <span class="appBarAppLogo">LOGO <i class="fa fa-meteor"></i> </span>
    </div>
    
    <div class="contacts">

    </div>

    <div class="chatScreen">
        
        <div id="chatScreenChatArea">
            <!-- <div class="me">Hello!<div class='date'>18:6:2</div></div>
            <div class="you"><div class='name'>name</div>hi!<div class='date'>18:6:2</div></div>
            <div class="me">working fine?!<div class='date'>18:6:2</div></div>
            <div class="you"><div class='name'>name</div>yeah<div class='date'>18:6:2</div></div>
            <div class="me">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae blanditiis expedita possimus doloribus ad dignissimos magnam doloremque at esse culpa, reprehenderit iure praesentium quo fuga labore dolores quia fugiat eos, error sit adipisci optio. Incidunt corporis recusandae, aut porro doloribus ullam perferendis ea eum repellendus voluptatibus repudiandae. Rem, nesciunt eum?<div class='date'>18:6:2</div></div>
            <div class="you"><div class='name'>name</div>hi?!<div class='date'>18:6:2</div></div> -->
        </div>


        <div class="chatScreenInputContainer">
            <input type="file" name="f_upload" id="f_upload">
            <label for="f_upload"><i class="fa fa-paperclip chatScreenInputContainerButton"></i></label>
            
            <textarea resizable="false" name="f_message" id="f_message" placeholder="Enter Your Message Here..."></textarea>

            <i style="margin-left:auto" class="fa fa-space-shuttle chatScreenInputContainerButton" id="f_send_button"></i>
        </div>
    </div>

    <script src="./script/utils.js"></script>
    <script src="./script/input-handler.js"></script>


    <!-- initialize all -->
    <script>
        //-[temp]------------------
        const room=<?php echo '"'.$roomName.'"'; ?>,u_name=<?php echo '"'.$u_name.'"'; ?>;

        onload=function(){
            document.body.style.height=innerHeight+'px'; //for fixing height issue with mobile chrome
            pre_init();
        }
        onresize=function(){
            document.body.style.height=innerHeight+'px'; //for fixing height issue with mobile chrome
        }
        
        function pre_init(){
            //set name etc
            input_handler_init();
        }
    </script>

</body>
</html>