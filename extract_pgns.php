<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit','2048M');

/*
SELECT PGN FROM chesspgn WHERE BlackElo > 2500 AND Result = '0-1';

SELECT PGN FROM chesspgn WHERE WhiteElo > 2500 AND Result = '1-0';
*/

	$board = array(
    'r', 'n', 'b', 'q', 'k', 'b', 'n', 'r',
    'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p',
    ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
    ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
    ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
    ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
    'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P',
    'R', 'N', 'B', 'Q', 'K', 'B', 'N', 'R'
    );


function uci_to_pgn($uci){
	global $board_map, $board_id;
	
	$pgn = '';
	//$uci = '';
	/*
	$board_map = array(
    'a8'=>'r', 'b8'=>'n', 'c8'=>'b', 'd8'=>'q', 'e8'=>'k', 'f8'=>'b', 'g8'=>'n', 'h8'=>'r',
    'a7'=>'p', 'b7'=>'p', 'c7'=>'p', 'd7'=>'p', 'e7'=>'p', 'f7'=>'p', 'g7'=>'p', 'h7'=>'p',
    'a6'=>'', 'b6'=>'', 'c6'=>'', 'd6'=>'', 'e6'=>'', 'f6'=>'', 'g6'=>'', 'h6'=>'',
    'a5'=>'', 'b5'=>'', 'c5'=>'', 'd5'=>'', 'e5'=>'', 'f5'=>'', 'g5'=>'', 'h5'=>'',
    'a4'=>'', 'b4'=>'', 'c4'=>'', 'd4'=>'', 'e4'=>'', 'f4'=>'', 'g4'=>'', 'h4'=>'',
    'a3'=>'', 'b3'=>'', 'c3'=>'', 'd3'=>'', 'e3'=>'', 'f3'=>'', 'g3'=>'', 'h3'=>'',
    'a2'=>'P', 'b2'=>'P', 'c2'=>'P', 'd2'=>'P', 'e2'=>'P', 'f2'=>'P', 'g2'=>'P', 'h2'=>'P',
    'a1'=>'R', 'b1'=>'N', 'c1'=>'B', 'd1'=>'Q', 'e1'=>'K', 'f1'=>'B', 'g1'=>'N', 'h1'=>'R'
    );
	*/
	// w O-O	$board_map['e1']='';	$board_map['g1']='K';	$board_map['h1']='';	$board_map['f1']='R';
	// w O-O-O	$board_map['e1']='';	$board_map['c1']='K';	$board_map['a1']='';	$board_map['d1']='R';
	// b O-O	$board_map['e8']='';	$board_map['g8']='k';	$board_map['h8']='';	$board_map['f8']='R';
	// b O-O-O	$board_map['e8']='';	$board_map['c8']='K';	$board_map['a8']='';	$board_map['d8']='R';
	
	$uci = str_replace(array('position startpos moves ','  '), '', $uci);
	$moves = explode(' ',$uci);
	
	$i=0;
	foreach($moves as $move){
		
		$par1 = substr($move,0,2); 
		$par2 = str_replace($par1, '', $move); 
		$par2 = substr($move, -2); 
		
		echo $move.' PGN '.$par1.' '.$board_map[$par1].' '.$par2.' '.$board_map[$par2].'<br>';
		
		if(($board_map[$par1] == 'p') or ($board_map[$par1] == 'P')){
			$board_map[$par2]=$board_map[$par1];
			$board_map[$par1]='';
			
			$pgn .= $par2.' ';
		}
		if(($board_map[$par1] == 'b') or ($board_map[$par1] == 'B')){
			if(($board_map[$par2]!='b') or ($board_map[$par2]!='B')){ $capture = 'x';}else{$capture = '';}
			$pgn .= 'B'.$capture.$par2.' ';
			$board_map[$par2]=$board_map[$par1];
			$board_map[$par1]='';
		}
		if(($board_map[$par1] == 'n') or ($board_map[$par1] == 'N')){
			if(($board_map[$par2]!='n') or ($board_map[$par2]!='N')){ $capture = 'x';}else{$capture = '';}
			$pgn .= 'N'.$capture.$par2.' ';
			$board_map[$par2]=$board_map[$par1];
			$board_map[$par1]='';
		}
		if(($board_map[$par1] == 'r') or ($board_map[$par1] == 'R')){
			if(($board_map[$par2]!='r') or ($board_map[$par2]!='R')){ $capture = 'x';}else{$capture = '';}
			$pgn .= 'R'.$capture.$par2.' ';
			$board_map[$par2]=$board_map[$par1];
			$board_map[$par1]='';
		}
		if(($board_map[$par1] == 'q') or ($board_map[$par1] == 'Q')){
			if(($board_map[$par2]!='q') or ($board_map[$par2]!='Q')){ $capture = 'x';}else{$capture = '';}
			$pgn .= 'Q'.$capture.$par2.' ';
			$board_map[$par2]=$board_map[$par1];
			$board_map[$par1]='';
		}
		if(($board_map[$par1] == 'k') or ($board_map[$par1] == 'K')){
			if(($board_map[$par2]!='k') or ($board_map[$par2]!='K')){ $capture = 'x';}else{$capture = '';}
			$pgn .= 'K'.$capture.$par2.' ';
			$board_map[$par2]=$board_map[$par1];
			$board_map[$par1]='';
		}
		
		$i++;
		/*
		$pgn .= $i.'.';
		if ($i%2==0){
			$pgn .= $move.' ';
		}else{
			$pgn .= $move.' ';
		}
		*/
		
	}
	
	echo var_dump($board_map);
	
	return $pgn;
}

/*

*/

$uci = 'position startpos moves d2d4 d7d5 c2c4 e7e6 b1c3 g8f6 g1f3 a7a6 e2e3 d5c4 f1c4 b7b5 c4b3 c8b7 e1g1 f8e7 a2a3 c7c5 d4c5 b8d7 d1e2 d7c5 b3c2 c5e4 c3e4 f6e4 f3d2 e4d6 e3e4 e8g8 d2f3 d6c4 a3a4 d8c7 c2d3 c4a5 c1e3 a5b3 a1a2 b5b4 d3c4 b3c5 e3c5 c7c5 b2b3 f8d8 a2c2 a8c8 c4d3 c5d6 c2c8 d8c8 e4e5 d6c6 d3c4 a6a5 f1c1 h7h6 c1c2 e7d8 h2h3 c6e4 e2e4 b7e4 c2e2 e4a8 e2d2 d8c7 c4a6 c8d8 d2c2 d8d1 g1h2 c7b6 h2g3 g7g5 a6e2 d1d8 e2c4 g8g7 c2e2 a8c6 f3d2 b6c7 f2f3 c6b7 g3f2 g7g6 g2g4 h6h5 f2e1 b7a8 c4b5 g6h6 b5c4 d8d4 e1f2 d4f4 f2g3 h5h4 g3f2 c7b6 f2g2 f4d4 g2f1 d4d8 f1g2 a8b7 g2f1 h6g6 d2e4 b6c7 f1g2 d8d4 e2d2 d4d2 e4d2 c7e5 c4b5 e5c7 g2f2 g6f6 d2c4 b7d5 f2e2 d5a8 b5a6 a8c6 e2e3 f6e7 e3e2 c6d5 c4d2 e7d6 e2e3 d6c5 e3d3 c7f4 d2e4 c5b6 a6c4 d5c6 d3e2 b6c7 e2e1 c6b7 e1e2 c7c6 c4d3 f7f5 e4f2 c6c5 d3c4 c5d4 c4e6 b7a6 e2e1 f4g3 g4f5 d4e3 e1d1 g3f2 f5f6 e3f3 e6g4 f3f4 d1c2 f2c5 f6f7 f4e5 g4d7 a6b7 d7g4 b7d5 g4h5 d5e6 c2b2 e6h3 f7f8b c5f8 b2c2 g5g4 c2d2 g4g3';
//echo uci_to_pgn($uci);

function pgn_to_uci($pgn){
	


	$board_map = array(
    'a8'=>'r', 'b8'=>'n', 'c8'=>'b', 'd8'=>'q', 'e8'=>'k', 'f8'=>'b', 'g8'=>'n', 'h8'=>'r',
    'a7'=>'p', 'b7'=>'p', 'c7'=>'p', 'd7'=>'p', 'e7'=>'p', 'f7'=>'p', 'g7'=>'p', 'h7'=>'p',
    'a6'=>'', 'b6'=>'', 'c6'=>'', 'd6'=>'', 'e6'=>'', 'f6'=>'', 'g6'=>'', 'h6'=>'',
    'a5'=>'', 'b5'=>'', 'c5'=>'', 'd5'=>'', 'e5'=>'', 'f5'=>'', 'g5'=>'', 'h5'=>'',
    'a4'=>'', 'b4'=>'', 'c4'=>'', 'd4'=>'', 'e4'=>'', 'f4'=>'', 'g4'=>'', 'h4'=>'',
    'a3'=>'', 'b3'=>'', 'c3'=>'', 'd3'=>'', 'e3'=>'', 'f3'=>'', 'g3'=>'', 'h3'=>'',
    'a2'=>'P', 'b2'=>'P', 'c2'=>'P', 'd2'=>'P', 'e2'=>'P', 'f2'=>'P', 'g2'=>'P', 'h2'=>'P',
    'a1'=>'R', 'b1'=>'N', 'c1'=>'B', 'd1'=>'Q', 'e1'=>'K', 'f1'=>'B', 'g1'=>'N', 'h1'=>'R'
    );
	
	$board_id = array(
    '1'=>'a8', '2'=>'b8', '3'=>'c8', '4'=>'d8', '5'=>'e8', '6'=>'f8', '7'=>'g8', '8'=>'h8',
    '9'=>'a7', '10'=>'b7', '11'=>'c7', '12'=>'d7', '13'=>'e7', '14'=>'f7', '15'=>'g7', '16'=>'h7',
    '17'=>'a6', '18'=>'b6', '19'=>'c6', '20'=>'d6', '21'=>'e6', '22'=>'f6', '23'=>'g6', '24'=>'h6',
    '25'=>'a5', '26'=>'b5', '27'=>'c5', '28'=>'d5', '29'=>'e5', '30'=>'f5', '31'=>'g5', '32'=>'h5',
    '33'=>'a4', '34'=>'b4', '35'=>'c4', '36'=>'d4', '37'=>'e4', '38'=>'f4', '39'=>'g4', '40'=>'h4',
    '41'=>'a3', '42'=>'b3', '43'=>'c3', '44'=>'d3', '45'=>'e3', '46'=>'f3', '47'=>'g3', '48'=>'h3',
    '49'=>'a2', '50'=>'b2', '51'=>'c2', '52'=>'d2', '53'=>'e2', '54'=>'f2', '55'=>'g2', '56'=>'h2',
    '57'=>'a1', '58'=>'b1', '59'=>'c1', '60'=>'d1', '61'=>'e1', '62'=>'f1', '63'=>'g1', '64'=>'h1'
    );
		
	//$pgn = '';
	$uci = '';
	
	$i=0;
	foreach($board_map as $moves){
		$i++;
		//echo $i.' '.$board_id[$i].' '.$moves."\n";
	}
	
	$pgn = str_replace(array('position startpos moves ','  '), '', $pgn);
	$pgn = str_replace('.', ' ', $pgn);
	$pgn = str_replace('+', '', $pgn);
	$moves = explode(' ',$pgn);
	
	$i=0;
	foreach($moves as $move){
		if(!is_numeric($move)){
			$i++;
			$move_ok = '';
			
			if ($i%2!=0){ // white moves
				$color='w';
				
				if(substr_count($move, 'Q')){
					$move_ok = get_queen_move_from($pgnmove=$move,$color, $board_map, $board_id).substr($move,-2);
					$board_map = update_board_map($move_ok, $board_map, $board_id);
				}
				if(substr_count($move, 'K')){ 
					$move_ok = get_king_move_from($pgnmove=$move,$color, $board_map, $board_id).substr($move,-2);
					$board_map = update_board_map($move_ok, $board_map, $board_id);
				}
				if(substr_count($move, 'N')){
					$move_ok = get_knight_move_from($pgnmove=$move,$color, $board_map, $board_id).substr($move,-2);
					$board_map = update_board_map($move_ok, $board_map, $board_id);
				}
				if(substr_count($move, 'B')){
					$move_ok = get_bishop_move_from($pgnmove=$move,$color, $board_map, $board_id).substr($move,-2);
					$board_map = update_board_map($move_ok, $board_map, $board_id);
				}
				if(substr_count($move, 'R')){
					$move_ok = get_rook_move_from($pgnmove=$move,$color, $board_map, $board_id).substr($move,-2);
					$board_map = update_board_map($move_ok, $board_map, $board_id);
				}				
				if(substr_count($move, 'O-O-O')){
					// w O-O-O	$board_map['e1']='';	$board_map['c1']='K';	$board_map['a1']='';	$board_map['d1']='R';
					$move_ok = 'e1'.'c1';
					$board_map['e1']='';	$board_map['c1']='K';	$board_map['a1']='';	$board_map['d1']='R';
				}				
				if(substr_count($move, 'O-O')){
					// w O-O	$board_map['e1']='';	$board_map['g1']='K';	$board_map['h1']='';	$board_map['f1']='R';
					$move_ok = 'e1'.'g1';
					$board_map['e1']='';	$board_map['g1']='K';	$board_map['h1']='';	$board_map['f1']='R';

				}
				if(
					!substr_count($move, '-') and 
					!substr_count($move, 'Q') and
					!substr_count($move, 'K') and
					!substr_count($move, 'R') and
					!substr_count($move, 'B') and
					!substr_count($move, 'N') 				
					){
						$move_ok = get_pawn_move_from($pgnmove=$move,$color, $board_map, $board_id).substr($move,-2);
						$board_map = update_board_map($move_ok, $board_map, $board_id);
					}
				$uci .= $move.' '.$move_ok.' '.$color.' ';
				//$uci .= $move_ok.' ';
				//$uci .= '<br>';	
				
			}else{	// black moves
				$color='b';
				
				if(substr_count($move, 'Q')){	
					$move_ok = get_queen_move_from($pgnmove=$move,$color, $board_map, $board_id).substr($move,-2);
					$board_map = update_board_map($move_ok, $board_map, $board_id);
				}
				if(substr_count($move, 'K')){
					$move_ok = get_king_move_from($pgnmove=$move,$color, $board_map, $board_id).substr($move,-2);
					$board_map = update_board_map($move_ok, $board_map, $board_id);
				}
				if(substr_count($move, 'N')){
					$move_ok = get_knight_move_from($pgnmove=$move,$color, $board_map, $board_id).substr($move,-2);
					$board_map = update_board_map($move_ok, $board_map, $board_id);
				}
				if(substr_count($move, 'B')){
					$move_ok = get_bishop_move_from($pgnmove=$move,$color, $board_map, $board_id).substr($move,-2);
					$board_map = update_board_map($move_ok, $board_map, $board_id);
				}
				if(substr_count($move, 'R')){
					$move_ok = get_rook_move_from($pgnmove=$move,$color, $board_map, $board_id).substr($move,-2);
					$board_map = update_board_map($move_ok, $board_map, $board_id);
				}				
				if(substr_count($move, 'O-O-O')){
					// b O-O-O	$board_map['e8']='';	$board_map['c8']='K';	$board_map['a8']='';	$board_map['d8']='R';
					$move_ok = 'e8'.'g8';
					$board_map['e8']='';	$board_map['c8']='k';	$board_map['a8']='';	$board_map['d8']='r';
				}				
				if(substr_count($move, 'O-O')){
					// b O-O	$board_map['e8']='';	$board_map['g8']='k';	$board_map['h8']='';	$board_map['f8']='R';
					$move_ok = 'e8'.'g8';
					$board_map['e8']='';	$board_map['g8']='k';	$board_map['h8']='';	$board_map['f8']='r';
				}
				if(
				!substr_count($move, '-') and 
				!substr_count($move, 'Q') and
				!substr_count($move, 'K') and
				!substr_count($move, 'R') and
				!substr_count($move, 'B') and
				!substr_count($move, 'N') 
				){
					$move_ok = get_pawn_move_from($pgnmove=$move,$color, $board_map, $board_id).substr($move,-2);
					$board_map = update_board_map($move_ok, $board_map, $board_id);
				}
			
				$uci .= $move.' '.$move_ok.' '.$color.' ';
				//$uci .= $move_ok.' ';
				$uci .= '<br>';
				//$uci .= "\n";					
				
			}
			
			//$par2 = substr($move, -2);
			//$uci .= $par2.' ';
			
		}
		
		//$uci .= $move.' ';
	}
	
	
	
	
	$i=0;
	foreach($board_map as $moves){
		$i++;
		//echo $i.' '.$board_id[$i].' '.$moves."\n";
	}
	return $uci;
}

$pgn = '1.Nf3 Nf6 2.g3 b6 3.Bg2 Bb7 4.O-O e6 5.d3 d5 6.Nbd2 Be7 7.e4 c5 8.e5 Nfd7 9.Re1 Nc6 10.h4 Qc7 11.Qe2 h6 12.h5 Nb4 13.Nf1 c4 14.d4 c3 15.Ne3 Ba6 16.Qd1 cxb2 17.Bxb2 Rc8 18.Qd2 b5 19.a4 Nb6 20.Ba3 Qc3 21.Qxc3 Rxc3 22.Bxb4 Bxb4 23.Reb1 Rxe3 24.fxe3 Bc3 25.axb5 Bxa1 26.Rxa1 Bxb5 27.Rxa7 Nc8 28.Rb7 Ba6 29.Rb8 Kd7 30.Bf1 Kc7 31.Rb3 Bxf1 32.Kxf1 Nb6 33.Nd2 Ra8 34.Ke2 Ra1 35.Rb1 Ra2 36.Kd3 Ra3+ 37.Rb3 Ra1 38.Rb1 Ra3+ 39.Nb3 Nd7 40.Rf1 f6 41.exf6 Nxf6 42.g4 Kd6 43.Rg1 Ne4 44.Ra1 Rxa1 45.Nxa1 Nf2+ 46.Ke2 Nxg4 47.Nb3 Nf6 48.Kf3 Nxh5 49.e4 dxe4+ 50.Kxe4 Nf6+ 51.Kd3 h5 52.c4 h4 53.Ke3 g5 54.Nd2 g4 55.Kf4 g3 56.Nf3 g2 57.Kg5 h3 58.Kxf6 h2 59.c5+ Kd5 0-1';
echo pgn_to_uci($pgn);

//echo var_dump($board_map);



/*
OUTPUT:
Nf3 Nf6 g3 b6 Bg2 Bb7 O-O e6 d3 d5 Nbd2 Be7 e4 c5 e5 Nfd7 Re1 Nc6 h4 Qc7 Qe2 h6 h5 Nb4 Nf1 c4 d4 c3 Ne3 Ba6 Qd1 cxb2 Bxb2 Rc8 Qd2 b5 a4 Nb6 Ba3 Qc3 Qxc3 Rxc3 Bxb4 Bxb4 Reb1 Rxe3 fxe3 Bc3 axb5 Bxa1 Rxa1 Bxb5 Rxa7 Nc8 Rb7 Ba6 Rb8 Kd7 Bf1 Kc7 Rb3 Bxf1 Kxf1 Nb6 Nd2 Ra8 Ke2 Ra1 Rb1 Ra2 Kd3 Ra3 Rb3 Ra1 Rb1 Ra3 Nb3 Nd7 Rf1 f6 exf6 Nxf6 g4 Kd6 Rg1 Ne4 Ra1 Rxa1 Nxa1 Nf2 Ke2 Nxg4 Nb3 Nf6 Kf3 Nxh5 e4 dxe4 Kxe4 Nf6 Kd3 h5 c4 h4 Ke3 g5 Nd2 g4 Kf4 g3 Nf3 g2 Kg5 h3 Kxf6 h2 c5 Kd5 0-1

*/

function update_board_map($move, $board_map, $board_id){
	
	$par1 = substr($move,0,2); 
	$par2 = substr($move, -2); 
	//echo 'update_board_map 1 par1 '.$par1.' par2 '.$par2.' '."\n";
		
	$board_map[$par2]=$board_map[$par1];		
	$board_map[$par1]='';						
	//echo 'update_board_map 2 par1 '.$board_map[$par1].' par2 '.$board_map[$par2].' '."\n";
	
	return $board_map;
}

function get_pawn_move_from($pgnmove, $color, $board_map, $board_id){
	
	$ucimove = '';
	
	if($color=='w'){
		$piece = 'P';
	}else{
		$piece = 'p';
	}	
	$map1 = substr($pgnmove,0,1); // first char pgnmove Example: g3 -> g
	
	$i=0;
	foreach($board_map as $moves){
		$i++;
		//echo $i.' '.$board_id[$i].' '.$moves."\n";
		if(substr_count($board_id[$i], $map1) and substr_count($moves, $piece)){ 
			$ucimove = $board_id[$i];
		}
	}
	//echo var_dump($board_map);
	return $ucimove;
}

function get_king_move_from($pgnmove, $color, $board_map, $board_id){
	
	$ucimove = '';
	
	if($color=='w'){
		$piece = 'K';
	}else{
		$piece = 'k';
	}
	$pgnmove = substr($pgnmove, -2);					
	//echo 'pgnmove '.$pgnmove."\n";
	
	$i=0;
	foreach($board_map as $moves){
		$i++;
		//echo $i.' '.$board_id[$i].' '.$moves."\n";
		if(substr_count($moves, $piece)){ 
			$ucimove = $board_id[$i];
		}
	}
	//echo ' ucimove '.$ucimove.' '."\n";
	return $ucimove;
}

function get_queen_move_from($pgnmove, $color, $board_map, $board_id){
	
	$ucimove = '';
	
	if($color=='w'){
		$piece = 'Q';
	}else{
		$piece = 'q';
	}
	$pgnmove = substr($pgnmove, -2);					
	//echo 'pgnmove '.$pgnmove."\n";
	
	$i=0;
	foreach($board_map as $moves){
		$i++;
		//echo $i.' '.$board_id[$i].' '.$moves."\n";
		if(substr_count($moves, $piece)){ 
			$ucimove = $board_id[$i];
		}
	}
	//echo ' ucimove '.$ucimove.' '."\n";
	return $ucimove;}

function get_knight_move_from($pgnmove, $color, $board_map, $board_id){
	
	$ucimove = '';
	/*
	$ceil_main = ceil($id);
	
	N + 1 - 16 		= ceil(N +1 -16) == $ceil_main -2
	N + 2 - 8		= ceil(N + 2 - 8) == $ceil_main -1
	N - 1 - 16		= ceil(N -1 -16) == $ceil_main -2
	N - 2 - 8		= ceil(N - 2 - 8) == $ceil_main -1
	
	N + 1 + 16		=				== $ceil_main +2
	N + 2 + 8		=				== $ceil_main +1
	N - 1 + 16		=				== $ceil_main +2
	N - 2 + 8		=				== $ceil_main +1
		
	*/
	
	if($color=='w'){
		$piece = 'N';
	}else{
		$piece = 'n';
	}	
	$pgnmove = substr($pgnmove, -2); 
	
	$map1 = substr($pgnmove,0,1); // first char pgnmove Example: g3 -> g
	$map2 = substr($pgnmove,-1);  // last char pgnmove Example: g3 -> 3
	
	$i=0;
	foreach($board_map as $moves){
		$i++;
		//echo $i.' '.$board_id[$i].' '.$moves."\n";
		if(
		//substr_count($board_id[$i], $map1) and 
		substr_count($moves, $piece)
		){ 
			$id = $board_id[$i];
			if(substr_count(GetValidKnightMoves($id), $pgnmove)){ 
				$ucimove = $board_id[$i];
			}

		}
	}
		
	return $ucimove;
}

function get_bishop_move_from($pgnmove, $color, $board_map, $board_id){
	
	$ucimove = '';
	
	if($color=='w'){
		$piece = 'B';
	}else{
		$piece = 'b';
	}	
	
	$pgnmove = substr($pgnmove, -2); 
	
	$map1 = substr($pgnmove,0,1); 
	$map2 = substr($pgnmove,-1);  
	
	$i=0;
	foreach($board_map as $moves){
		$i++;
		//echo $i.' '.$board_id[$i].' '.$moves."\n";
		if(
		//substr_count($board_id[$i], $map1) and 
		substr_count($moves, $piece)
		){ 
			$id = $board_id[$i];
			if(substr_count(GetValidBishopMoves($id), $pgnmove)){ 
				$ucimove = $board_id[$i];
			}

		}
	}
	
	return $ucimove;
}

function get_rook_move_from($pgnmove, $color, $board_map, $board_id){
	
	$ucimove = '';
	
	if($color=='w'){
		$piece = 'R';
	}else{
		$piece = 'r';
	}

	$pgnmove = substr($pgnmove, -2); 
	
	$map1 = substr($pgnmove,0,1); 
	$map2 = substr($pgnmove,-1);  
	
	$i=0;
	foreach($board_map as $moves){
		$i++;
		//echo $i.' '.$board_id[$i].' '.$moves."\n";
		if(
		//substr_count($board_id[$i], $map1) and 
		substr_count($moves, $piece)
		){ 
			$id = $board_id[$i];
			if(substr_count(GetValidRookMoves($id), $pgnmove)){ 
				$ucimove = $board_id[$i];
			}

		}
	}
	
	return $ucimove;
}






function GetValidKnightMoves($strStartingMove) {

  $cb_rows = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5, 'f' => 6, 'g' => 7, 'h' => 8);
  $valids  = array(
				array(-1, -2), array(-2, -1), 
				array(-2, 1), array(-1, 2), 
				array(1, 2), array(2, 1), 
				array(2, -1), array(1, -2)
				);
	
  $row = substr($strStartingMove, 0, 1);
  $col = substr($strStartingMove, 1, 1);
  $current_row = $cb_rows[$row];
  if(!in_array($current_row, $cb_rows)) {
    die("Hey, use chars from a to h only!");
  }
  $current_col = $col;
  if($current_col > 8) {
    die("Hey, use numbers from 1 to 8 only!");
  }
  $valid_moves = '';
  foreach ($valids as $valid) {
    $new_valid_row = $current_row + $valid[0];
    $new_valid_col = $current_col + $valid[1];
    if(($new_valid_row <= 8 && $new_valid_row > 0) && ($new_valid_col <= 8 && $new_valid_col > 0)) {
      $row_char = array_search($new_valid_row, $cb_rows);
      $valid_moves .= $row_char . "$new_valid_col ";
    }
  }
  return $valid_moves;
} 


function GetValidBishopMoves($strStartingMove) {

  $cb_rows = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5, 'f' => 6, 'g' => 7, 'h' => 8);
  $valids  = array(
				array(1, 1), array(2, 2), array(3, 3), array(4, 4),	array(5, 5), array(6, 6), array(7, 7),				
				array(-1, -1), array(-2, -2), array(-3, -3), array(-4, -4),	array(-5, -5), array(-6, -6), array(-7, -7),				
				array(-1, 1), array(-2, 2), array(-3, 3), array(-4, 4),	array(-5, 5), array(-6, 6), array(-7, 7),				
				array(1, -1), array(2, -2), array(3, -3), array(4, -4),	array(5, -5), array(6, -6), array(7, -7)
				);
	
  $row = substr($strStartingMove, 0, 1);
  $col = substr($strStartingMove, 1, 1);
  $current_row = $cb_rows[$row];
  if(!in_array($current_row, $cb_rows)) {
    die("Hey, use chars from a to h only!");
  }
  $current_col = $col;
  if($current_col > 8) {
    die("Hey, use numbers from 1 to 8 only!");
  }
  $valid_moves = '';
  foreach ($valids as $valid) {
    $new_valid_row = $current_row + $valid[0];
    $new_valid_col = $current_col + $valid[1];
    if(($new_valid_row <= 8 && $new_valid_row > 0) && ($new_valid_col <= 8 && $new_valid_col > 0)) {
      $row_char = array_search($new_valid_row, $cb_rows);
      $valid_moves .= $row_char . "$new_valid_col ";
    }
  }
  return $valid_moves;
}

function GetValidRookMoves($strStartingMove) {

  $cb_rows = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5, 'f' => 6, 'g' => 7, 'h' => 8);
  $valids  = array(
				array(0, 1), array(0, 2), array(0, 3), array(0, 4),	array(0, 5), array(0, 6), array(0, 7),				
				array(0, -1), array(0, -2), array(0, -3), array(0, -4),	array(0, -5), array(0, -6), array(0, -7),				
				array(-1, 0), array(-2, 0), array(-3, 0), array(-4, 0),	array(-5, 0), array(-6, 0), array(-7, 0),				
				array(1, 0), array(2, 0), array(3, 0), array(4, 0),	array(5, 0), array(6, 0), array(7, 0)
				);
	
  $row = substr($strStartingMove, 0, 1);
  $col = substr($strStartingMove, 1, 1);
  $current_row = $cb_rows[$row];
  if(!in_array($current_row, $cb_rows)) {
    die("Hey, use chars from a to h only!");
  }
  $current_col = $col;
  if($current_col > 8) {
    die("Hey, use numbers from 1 to 8 only!");
  }
  $valid_moves = '';
  foreach ($valids as $valid) {
    $new_valid_row = $current_row + $valid[0];
    $new_valid_col = $current_col + $valid[1];
    if(($new_valid_row <= 8 && $new_valid_row > 0) && ($new_valid_col <= 8 && $new_valid_col > 0)) {
      $row_char = array_search($new_valid_row, $cb_rows);
      $valid_moves .= $row_char . "$new_valid_col ";
    }
  }
  return $valid_moves;
}




//echo "\n";
//echo get_pawn_move_from($pgnmove='g3',$color='w');

sleep(60);

?>