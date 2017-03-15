<!DOCTYPE html>
<html>
  <head>
    <title>Setting up database</title>
  </head>
  <body>

    <h3>Setting up...</h3>

<?php // Example 26-3: setup.php
  require_once 'functions.php';

  createTable('members',
              'user VARCHAR(16),
              pass VARCHAR(16),
			  email VARCHAR(50),
			  gender VARCHAR(16),
			  age VARCHAR(20),
			  location VARCHAR(20),
			  interests VARCHAR(20),
              INDEX(user(6))');

  createTable('messages', 
              'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              auth VARCHAR(16),
              recip VARCHAR(16),
              pm CHAR(1),
              time INT UNSIGNED,
              message VARCHAR(4096),
              INDEX(auth(6)),
              INDEX(recip(6))');

  createTable('friends',
              'user VARCHAR(16),
              friend VARCHAR(16),
              INDEX(user(6)),
              INDEX(friend(6))');

  createTable('profiles',
              'user VARCHAR(16),
              text VARCHAR(4096),
              INDEX(user(6))');
      
  createTable('points',
            'user_id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            latitude float,
            longitude float,
            time INT(11),
            user VARCHAR(45)');
?>

    <br>...done.
  </body>
</html>