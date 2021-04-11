<?php    
    include_once __DIR__.'/services/config.php';
    include_once __DIR__.'/services/database_handler.php';
    
    if(!isset($_COOKIE[COOKIE_UNIQID_NAME])){
                        setcookie(COOKIE_UNIQID_NAME,uniqid(COOKIE_UNIQID_NAME),COOKIE_EXPIRATION_TIME,'/');
     }        
    
    $inputNameElement='<input type="text" name="u_name" placeholder="Your Name Here!">';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/components/appBar.css">
    <link rel="stylesheet" href="./css/components/tabBar.css">
    <link rel="stylesheet" href="./css/components/registerScreen.css">
    <link rel="stylesheet" href="./css/font awesome/css/all.min.css">
    <link rel="stylesheet" href="./css/animations/basic-animations.css">
    <link rel="stylesheet" href="./css/responsive.css">
</head>
<body>
    
    <div class="appBar">
        <span class="appBarDrawerIcon"><i class="fa fa-fingerprint"></i></span> 
        <span class="appBarAppName">
            <!-- SSE_CHAT_APP -->
            Meteor Chat
            <span class='appBarPathSlash fa'>Register</span>
        </span>
        <span class="appBarAppLogo">LOGO <i class="fa fa-meteor"></i> </span>
    </div>


    <div class="registerScreen">
        <div class="registrationBox">
            <i class="logo fa fa-meteor"></i>
            <div class="tabBar">
                <div class="tab active" for='jRoom'>Join Room <i class="fa fa-slash"></i> Create Room</div>
                <!-- <div class="tab" for='cRoom'>Create Room</div> -->
            </div>                
            <form class="tabItem" name='jRoom' action="./index.php" method="POST">
                <?php #join room
                    if(!isset($_COOKIE[COOKE_USER_NAME_KEY])){
                        echo $inputNameElement;
                    }
                ?>
                <input type="text" name="roomName" placeholder="Room Name (CaseSensitive)">
                    <button type="submit">GO <i class="fa fa-meteor"></i></button>
                </form>

            <!-- <div class="tabItem" name='cRoom'>
                <?php #create room 
                    if(!isset($_COOKIE[COOKIE_UNIQID_NAME])){
                        setcookie(COOKIE_UNIQID_NAME,uniqid(COOKIE_UNIQID_NAME),COOKIE_EXPIRATION_TIME,'/');
                    }        
                    if(!isset($_COOKIE[COOKE_USER_NAME_KEY])){
                        echo $inputNameElement;
                    }
                ?>
                
                <input type="text" name='roomName'>
                <button onclick=submit(this.parentNode)>GO <i class="fa fa-meteor"></i></button>
                
            </div> -->
            
        </div>
    </div>


    <!-- useless now -->
    <script>
        function $(el) {return document.querySelector(el);}
        function _(el) {return document.querySelectorAll(el);}

        window.onload=init;

        function init(){
            $('.tab').classList.add('active');
            _('.tab').forEach(function(el){
                el.addEventListener('click',_handle_tab_click)
            });

            manage_tabs();

        }
        function manage_tabs(){
            _('.tab').forEach(function(el){
                var activeElem=(el.classList.contains('active'));
                var forLabel=(el.getAttribute('for'));
                if(activeElem){
                    $('.tabItem[name="'+forLabel+'"]').setAttribute('active',1);
                }else{
                    $('.tabItem[name="'+forLabel+'"]').setAttribute('active',0);
                }
            });
        }

        

        function _handle_tab_click(e){
            // let targ=e.target;
            // console.log(e.target);
            _('.tab').forEach(function(el){
                el.classList.remove('active');
            });    
            e.target.classList.add('active');
            manage_tabs();    
        }


    </script>
</body>
</html>