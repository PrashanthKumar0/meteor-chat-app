<?php
//server datails useless 
define('HOST','localhost');
define('PORT',8080);

//database details
define('DB_HOST','localhost');
define('DB_PORT',5432);
define('DB_NAME','TestDb');
define('DB_USER','root');
define('DB_PASSWD','');
define('DB_CHAT_TABLE','chats');
define('DB_DSN','pgsql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT);

//chat configs
define('ROOM_NAME_MAX_CHAR',30);    //max chars allowed for naming a room or a person name 
define('ROOM_NAME_PUBLIC','/');     //name (url) of public chat room (room of public chat)
                                    //here its / means if no room is specified on frontend


                                    
//cookie
define('COOKIE_UNIQID_NAME','SSEID');
define('COOKE_USER_NAME_KEY','SSEUSRNM');
define('COOKIE_ROOM_NAME_KEY','SSERNM');
define('COOKIE_EXPIRATION_TIME',time()+60*60*12*360);
/*
    just temp

    CREATE TABLE  chats(
        id SERIAL PRIMARY KEY ,
        room CHAR(30) DEFAULT '/' NOT NULL,
        u_name CHAR(30) NOT NULL,
        sessid CHAR(225) NOT NULL,
        chatText TEXT,
        broadcasted INT DEFAULT 0 NOT NULL,
   	js_time CHAR(65) NOT NULL 
    ); 
  
    INSERT INTO `chats`(`room`, `u_name`, `sessid`, `chatText`,`js_time`) VALUES ("/hello","me","sessionIdHere","Hello Guys","time here");


    CREATE TABLE `rooms`(
        id INT(4) NOT NULL PRIMARY KEY,
        name VARCHAR(30) NOT NULL DEFAULT "/"
    ); 











*/