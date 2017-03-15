var HALMA = {
    WHITE: 1,
};

HALMA.Game = function (options) {
    'use strict';
    
    options = options || {};
    
    /**********************************************************************************************/
    /* Private properties *************************************************************************/
   
    /** @type HALMA.BoardController */
    var boardController = null;
    
    /**
     * The board representation.
     * @type Array
     */
    var board = [
        [0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0]
    ];

    var colorTurn = HALMA.WHITE;
    
    function init() {
        boardController = new HALMA.BoardController({
            containerEl: options.containerEl,
            assetsUrl: options.assetsUrl,
            callbacks: {
                pieceCanDrop: isMoveLegal,
                pieceDropped: pieceMoved
            }
        });
     
        boardController.drawBoard(onBoardReady);
    }
    

    function onBoardReady() {
	    // setup the board pieces
	    var row, col, piece;
	    //places a piece onto the board starting from colum 6, row 6 of the board
	    for (row = 5; row < board.length; row++) {
	        for (col = 5; col < board[row].length; col++) {
	            if (row < 3 && (row + col) % 2) { // black piece
	                piece = {
	                    color: HALMA.WHITE,
	                    pos: [row, col]
	                };
	            } else if (row => 4 && (row + col) % 2) { // white piece
	                piece = {
	                    color: HALMA.BLACK,
	                    pos: [row, col]
	                };
	            } else { // empty square
	                piece = 0;
	            }
	 
	            board[row][col] = piece;
	 
	            if (piece) {
	                boardController.addPiece(piece);
	            }
	        }
	    }
	}

    /**
     * Checks if a move request is valid.
     */
    function isMoveLegal(from, to, color) {
        if (color !== colorTurn) {
            return false;
        }
     
        var fromRow = from[0];
        var fromCol = from[1];
        var toRow = to[0];
        var toCol = to[1];
     
        if (board[toRow][toCol] !== 0) { // a piece can't be dropped on an existing piece
            return false;
        }
     
        if (color === HALMA.BLACK) {
            // checks for one square move in left or right direction
            if (toRow === fromRow + 1 && (toCol === fromCol - 1 || toCol === fromCol + 1)) {
                return true;
            }
     
            // checks for 2 squares move (jumping over a piece)
            if (toRow === fromRow + 2) {
                // left direction
                if (toCol === fromCol - 2 && board[fromRow + 1][fromCol - 1] !== 0 && board[fromRow + 1][fromCol - 1].color != color) {
                    return true;
                }
     
                // right direction
                if (toCol === fromCol + 2 && board[fromRow + 1][fromCol + 1] !== 0 && board[fromRow + 1][fromCol + 1].color != color) {
                    return true;
                }
            }
        } else if (color === HALMA.WHITE) {
            // checks for one square move in left or right direction
            if (toRow === fromRow - 1 && (toCol === fromCol - 1 || toCol === fromCol + 1)) {
                return true;
            }
     
            // checks for 2 squares move (jumping over a piece)
            if (toRow === fromRow - 2) {
                // left direction
                if (toCol === fromCol - 2 && board[fromRow - 1][fromCol - 1] !== 0 && board[fromRow - 1][fromCol - 1].color != color) {
                    return true;
                }
     
                // right direction
                if (toCol === fromCol + 2 && board[fromRow - 1][fromCol + 1] !== 0 && board[fromRow - 1][fromCol + 1].color != color) {
                    return true;
                }
            }
        }
     
        return false;
    }

    /**
     * Piece moved.
     */
    function pieceMoved(from, to, color) {
        var fromRow = from[0];
        var fromCol = from[1];
        var toRow = to[0];
        var toCol = to[1];
     
        board[toRow][toCol] = board[fromRow][fromCol];
     
        board[fromRow][fromCol] = 0;

    }
    
    init();
};