<?php   


    header('Access-Control-Allow-Origin:*');
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    
    include_once __DIR__.'/../config.php';
    include_once __DIR__.'/../database_handler.php';
    if(!isset($_REQUEST['room'])){
        die('{err:true,errText:"not a valid request"}');
    }        
    // $prevMessageId=-1;
    $db=new ChatDatabase();
    while(true){
        
        $messages;
        $messages=$db->getNewMessages('/'.$_REQUEST['room']);//TODO something here   
        
        if(count($messages) > 0){
            // $prevMessageId=end($messages['id']);
            echo "data: ".json_encode($messages)."\n\n";
        }else { //hack for heroku need to deal in feontend
        	echo "data:👋\n\n";
        }

        // echo "id: ".$prevMessageId."\n\n";
        @ob_flush();
        flush();
        // usleep(1000);
        usleep(10);
    }