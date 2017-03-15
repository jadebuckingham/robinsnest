
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<link rel = "stylesheet" type = "text/css" href ="styles.css" />

<body class="background">

<?php // Example 21-9: members.php
include_once 'header.php';
?>
<div class="main">
<p>Halma is a centuries-old board game. Many variations exist. In this example, I’ve created a solitaire version of Halma with 9 pieces on a 9 × 9 board. In the beginning of the game, the pieces form a 3 × 3 square in the bottom-left corner of the board. The object of the game is to move all the pieces so they form a 3 × 3 square in the upper-right corner of the board, in the least number of moves.</p>
<ul><p>There are two types of legal moves in Halma:</p>
	<li>Take a piece and move it to any adjacent empty square. An “empty” square is one that does not currently have a piece in it. An “adjacent” square is immediately north, south, east, west, northwest, northeast, southwest, or southeast of the piece’s current position. (The board does not wrap around from one side to the other. If a piece is in the left-most column, it can not move west, northwest, or southwest. If a piece is in the bottom-most row, it can not move south, southeast, or southwest.)</li>
	
	<li>Take a piece and hop over an adjacent piece, and possibly repeat. That is, if you hop over an adjacent piece, then hop over another piece adjacent to your new position, that counts as a single move. In fact, any number of hops still counts as a single move. (Since the goal is to minimize the total number of moves, doing well in Halma involves constructing, and then using, long chains of staggered pieces so that other pieces can hop over them in long sequences.)</li>
	
	
</ul>

<br>
<br>
<br>
<p style="text-align: center">Click <a href="halma.html"> here </a> to play the game.</p>
</div>

</body>
</html>
