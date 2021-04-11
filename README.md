# meteor-chat-app
a web chat app based on server sent events
<a href="https://impk.herokuapp.com">
    see a live version ?
</a>

# Deploying

[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy?template=https://github.com/PrashanthKumar0/meteor-chat-app.git)


```php

#edit services/config.php accordingly while deployiing espically these lines
define('DB_HOST','localhost');
define('DB_PORT',5432);
define('DB_NAME','TestDb');
define('DB_USER','root');
define('DB_PASSWD','');
define('DB_CHAT_TABLE','chats');
define('DB_DSN','pgsql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT);

```
>services/config.php also contains the chat table's schema in postgreSQL .

```php

#Make sure to tweak these lines in services/database_handler.php if you are not using heroku 

$db = parse_url(getenv("DATABASE_URL"));
$this->db = new PDO("pgsql:" . sprintf(
            "host=%s;port=%s;user=%s;password=%s;dbname=%s",
        $db["host"],
        $db["port"],
        $db["user"],
        $db["pass"],
        ltrim($db["path"], "/")
));

```

```php
#make sure to change these line too in services/broadcaster/index.php inorder to cope up with cpu usage

usleep(10); 

#this line enables a short rest from broadcasting so that cpu isnt overwhelmed
```