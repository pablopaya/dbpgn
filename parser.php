<?php

// pgn db chess sources
//http://www.pgnmentor.com/files.html#events
//http://www.kingbase-chess.net/

include('extract_pgns.php'); 

$sqlconfig['servername'] = "localhost";
$sqlconfig['username'] = "admin";
$sqlconfig['password'] = "1234";
$sqlconfig['dbname'] = "chess";
$sqlconfig['tablename'] = "chesspgn";

create_table();


// upload_pgn($file_name="Bilbao2016.pgn");

function upload_pgn($file_name){
global $insert;
//$file = fopen("pgn/Bilbao2016.pgn", "r");
$file = fopen("pgn/".$file_name, "r");
$line_pgn = '';		
$insert[] =	'';

while(!feof($file)){
    $line = fgets($file);
	if(substr_count($line, '[')){
		//echo $line.'<br>';

//  `Event` varchar(45) DEFAULT NULL,
if(substr_count($line, '[Event ')){				$insert['[Event]'] = str_replace('[Event ', '', $line);				}
//  `Site` varchar(45) DEFAULT NULL,
if(substr_count($line, '[Site ')){				$insert['[Site]'] =	str_replace('[Site ', '', $line);				}
//  `Date` varchar(45) DEFAULT NULL,
if(substr_count($line, '[Date ')){				$insert['[Date]'] =	str_replace('[Date ', '', $line);				}
//  `Round` int(11) DEFAULT NULL,
if(substr_count($line, '[Round ')){				$insert['[Round]'] =	str_replace('[Round ', '', $line);			}
//  `White` varchar(45) DEFAULT NULL,
if(substr_count($line, '[White ')){				$insert['[White]'] =	str_replace('[White ', '', $line);			}
//  `Black` varchar(45) DEFAULT NULL,
if(substr_count($line, '[Black ')){				$insert['[Black]'] =	str_replace('[Black ', '', $line);			}
//  `Result` varchar(45) DEFAULT NULL,
if(substr_count($line, '[Result ')){			$insert['[Result]'] =	str_replace('[Result ', '', $line);			}
//  `EventDate` varchar(45) DEFAULT NULL,
if(substr_count($line, '[EventDate ')){			$insert['[EventDate]'] =	str_replace('[EventDate ', '', $line);	}
//  `Opening` varchar(45) DEFAULT NULL,
if(substr_count($line, '[Opening ')){			$insert['[Opening]'] =	str_replace('[Opening ', '', $line);		}
//  `ECO` varchar(45) DEFAULT NULL,
if(substr_count($line, '[ECO ')){				$insert['[ECO]'] = str_replace('[ECO ', '', $line);					}
//  `PlyCount` int(11) DEFAULT NULL,
if(substr_count($line, '[PlyCount ')){			$insert['[PlyCount]'] = str_replace('[PlyCount ', '', $line);		}
//  `FEN` varchar(45) DEFAULT NULL,
if(substr_count($line, '[FEN ')){				$insert['[FEN]'] =	str_replace('[FEN ', '', $line);				}
//  `Variation` varchar(45) DEFAULT NULL,
if(substr_count($line, '[Variation ')){			$insert['[Variation]'] = str_replace('[Variation ', '', $line);		}
//  `WhiteELO` int(11) DEFAULT NULL,
if(substr_count($line, '[WhiteElo ')){			$insert['[WhiteElo]'] = str_replace('[WhiteElo ', '', $line);		}
//  `BlackELO` int(11) DEFAULT NULL
if(substr_count($line, '[BlackElo ')){			$insert['[BlackElo]'] =	str_replace('[BlackElo ', '', $line);		}



	$insert['[PGN]'] =	$line_pgn;
	
	$insert['[UCI]'] =	'';
	//$insert['[UCI]'] =	pgn_to_uci($line_pgn);
		
	if(!empty($line_pgn)){
	insert_pgn();
	}
		echo var_dump($insert).'<hr>';
		//echo $line_pgn.'<br>';		
		$line_pgn = '';		
	}else{
		$quitar = array(chr(10),chr(13));
		$line = str_replace($quitar, ' ', $line);
		$line = str_replace('  ', '', $line);
		$line_pgn .= $line;

		//echo $line.'<br>';
	}
	//echo $line.'<br>';
}
fclose($file);

} // end upload_pgn




function start_insert($insert){
	$insert = trim(str_replace('  ', '', $insert));	
	$quitar = array('"',"'",'[',']',chr(10),chr(13));
	$insert = trim(str_replace($quitar, ' ', $insert));	
	return $insert;
}


function create_table(){
	global $sqlconfig;
		
	// Create connection
	$conn = new mysqli($sqlconfig['servername'], $sqlconfig['username'], $sqlconfig['password'], $sqlconfig['dbname']);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$sql = "
CREATE TABLE  IF NOT EXISTS `".$sqlconfig['dbname']."`.`".$sqlconfig['tablename']."`  (
  `sha512` varchar(128) DEFAULT NULL,
  `WhiteElo` varchar(16) DEFAULT NULL,
  `BlackElo` varchar(16) DEFAULT NULL,
  `Result` varchar(45) DEFAULT NULL,
  `PGN` varchar(1024) DEFAULT NULL,
  `UCI` varchar(1024) DEFAULT NULL,
  `Event` varchar(45) DEFAULT NULL,
  `Site` varchar(45) DEFAULT NULL,
  `Date` varchar(45) DEFAULT NULL,
  `Round` int(11) DEFAULT NULL,
  `White` varchar(45) DEFAULT NULL,
  `Black` varchar(45) DEFAULT NULL,
  `EventDate` varchar(45) DEFAULT NULL,
  `Opening` varchar(45) DEFAULT NULL,
  `ECO` varchar(45) DEFAULT NULL,
  `PlyCount` int(11) DEFAULT NULL,
  `FEN` varchar(45) DEFAULT NULL,
  `Variation` varchar(45) DEFAULT NULL,
   PRIMARY KEY (`sha512`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	";
/*
DROP TABLE IF EXISTS `chess`.`chesspgn`;
CREATE TABLE  `chess`.`chesspgn` (
  `sha512` varchar(128) DEFAULT NULL,
  `WhiteElo` varchar(16) DEFAULT NULL,
  `BlackElo` varchar(16) DEFAULT NULL,
  `Result` varchar(45) DEFAULT NULL,
  `PGN` varchar(1024) DEFAULT NULL,
  `Event` varchar(45) DEFAULT NULL,
  `Site` varchar(45) DEFAULT NULL,
  `Date` varchar(45) DEFAULT NULL,
  `Round` int(11) DEFAULT NULL,
  `White` varchar(45) DEFAULT NULL,
  `Black` varchar(45) DEFAULT NULL,
  `EventDate` varchar(45) DEFAULT NULL,
  `Opening` varchar(45) DEFAULT NULL,
  `ECO` varchar(45) DEFAULT NULL,
  `PlyCount` int(11) DEFAULT NULL,
  `FEN` varchar(45) DEFAULT NULL,
  `Variation` varchar(45) DEFAULT NULL,
   PRIMARY KEY (`sha512`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
*/
	if ($conn->query($sql) === TRUE) {
		//echo "Table created !";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
	return null;
}


	
function insert_pgn(){
	global $insert, $sqlconfig;
		
	// Create connection
	$conn = new mysqli($sqlconfig['servername'], $sqlconfig['username'], $sqlconfig['password'], $sqlconfig['dbname']);
	// Check connection
	if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
	} 
	$sql = "INSERT IGNORE INTO `".$sqlconfig['dbname']."`.`".$sqlconfig['tablename']."` (
		  `sha512`,
  		  `WhiteElo`,
		  `BlackElo`,
  		  `Result`,
  		  `PGN`,
   		  `UCI`,
		  `Event`,
		  `Site`,
		  `Date`,
		  `Round`,
		  `White`,
		  `Black`,
		  `EventDate`,
		  `Opening`,
		  `ECO`,
		  `PlyCount`,
		  `FEN`,
		  `Variation`
	)
	VALUES (
		  '".hash('sha512', start_insert($insert['[PGN]']))."',
  		  '".start_insert($insert['[WhiteElo]'])."',
		  '".start_insert($insert['[BlackElo]'])."',
  		  '".start_insert($insert['[Result]'])."',
  		  '".start_insert($insert['[PGN]'])."',
   		  '".start_insert($insert['[UCI]'])."',
		  '".start_insert($insert['[Event]'])."',
		  '".start_insert($insert['[Site]'])."',
		  '".start_insert($insert['[Date]'])."',
		  '".start_insert($insert['[Round]'])."',
		  '".start_insert($insert['[White]'])."',
		  '".start_insert($insert['[Black]'])."',
		  '".start_insert($insert['[EventDate]'])."',
		  '".start_insert($insert['[Opening]'])."',
		  '".start_insert($insert['[ECO]'])."',
		  '".start_insert($insert['[PlyCount]'])."',
		  '".start_insert($insert['[FEN]'])."',
		  '".start_insert($insert['[Variation]'])."'
	)";

	echo $sql."<br>";
	
	if ($conn->query($sql) === TRUE) {
	echo "New record created successfully";
	} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
	return null;
}

?>