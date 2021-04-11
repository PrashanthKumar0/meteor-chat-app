<?php

    // header('Access-Control-Allow-Origin : * ');

    include_once __DIR__.'/config.php';
    include_once __DIR__.'/database_handler.php';

    $response=array(
        'err'=>0,
        'errText'=>'',
    );

    if(!isset($_COOKIE[COOKIE_UNIQID_NAME])){
        setcookie(COOKIE_UNIQID_NAME,uniqid(COOKIE_UNIQID_NAME),COOKIE_EXPIRATION_TIME,'/');
    }
    
    // print_r($_COOKIE);
    
    // if(isset($_SERVER['PATH_INFO'])){ //available only for ajax i guess
    //     if($_SERVER['PATH_INFO']=='/send'){
            reciever_init();
    //     } else {
    //         die(json_encode(array('err'=>1,'errText'=>'Not A Valid Request At '.$_SERVER['PATH_INFO'])));
    //     }
    // } else {
        // die(json_encode(array('err'=>1,'errText'=>'Not A Valid Request')));
    // }














    function reciever_init(){
        global $response;

        if(
            !isset($_REQUEST['room']) || 
            !isset($_REQUEST['u_name']) || 
            !isset($_REQUEST['message']) || 
            !isset($_REQUEST['timestamp'])
        ){
                
            $response['err']=1;
            $response['errText']='Incomplete Data!';
            die(json_encode($response));
        }else if(
            empty($_REQUEST['room']) || 
            empty($_REQUEST['u_name']) || 
            empty($_REQUEST['message']) || 
            empty($_REQUEST['timestamp'])
        ){
            $response['err']=1;
            $response['errText']='Incomplete Data!';
            die(json_encode($response));      
        }   

        $room=$_REQUEST['room'];
        $u_name=$_REQUEST['u_name'];
        $message=$_REQUEST['message'];
        $js_time=$_REQUEST['timestamp'];
        $db=new ChatDatabase();
        $db->addNewChat($room,$u_name,$message,$js_time);
        if($db->err){
            $response['err']=$db->err;
            $response['errText']=$db->errStr;
            die(json_encode($response));
        }
        die(json_encode($response));
    }