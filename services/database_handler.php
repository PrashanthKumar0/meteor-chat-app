<?php 

// define('DIR_SEPERATOR','\\');

include_once __DIR__.'/config.php';

class ChatDatabase{

    private $db=null;
    public $err=false;
    public $errStr='';
    public $table=null;
    public function __construct(){
        try{

           // $this->db=new PDO(DB_DSN,DB_USER,DB_PASSWD);
                
            $db = parse_url(getenv("DATABASE_URL"));

            $this->db = new PDO("pgsql:" . sprintf(
                     "host=%s;port=%s;user=%s;password=%s;dbname=%s",
                    $db["host"],
                   $db["port"],
                   $db["user"],
                   $db["pass"],
                    ltrim($db["path"], "/")
             ));
            $this->table=DB_CHAT_TABLE;
        }catch(PDOException $e){
            $this->err=true;
            $this->table=null;
            error_log('failed connecting to database',0);
            error_log('\n\n\n\n\n',0);
        }
    }

    public function addNewChat($room,$userName,$chatText,$jsTimeStamp){
        if(!isset($_COOKIE[COOKIE_UNIQID_NAME])){
            $this->err=1;
            $this->errStr='No cookies Found';
            return 0;
        }

        $sql='  INSERT INTO '.$this->table.' (room, u_name, sessid, chatText, js_time)  
                VALUES(:room,:u_name,:sessid,:chatText,:js_time);';

        $vals=array(
                    ':room'=>$room,
                    ':u_name'=>$userName,
                    ':sessid'=>$_COOKIE[COOKIE_UNIQID_NAME],
                    ':chatText'=>$chatText,
                    ':js_time'=>$jsTimeStamp
                );

        $stmtHandler=$this->db->prepare($sql)->execute($vals);
    }

    public function getNewMessages($room='/'){
        
        $vals=array(
            ':room'=>$room
        );

        $sql='SELECT id,u_name,sessid,chatText,js_time FROM '.$this->table.' WHERE broadcasted=0 AND room=:room;';
        // $sql='SELECT * FROM '.$this->table.' WHERE room=:room;';

        $stmth=$this->db->prepare($sql);
        $stmth->execute($vals);
        
        $toReturn=$stmth->fetchAll(PDO::FETCH_ASSOC);

        //TODO:clear all broadcasted messages?
        foreach ($toReturn as $key => $value) {
            $sql='UPDATE '.$this->table.' SET broadcasted=1 WHERE id='.$value['id'];
            $this->db->exec($sql);
        }
        
        return $toReturn;
    }
}