<?

	// config
	require_once('../../config.php');
	require_once(SITE_PATH.'/framework/mysql.class.php');
	
	
	
	if (!empty($_POST['action'])) { 
	
		switch($_POST['action']) { 
		
			case 'roses':
				
				$idBox = $_POST['arr'];
			
				$out = sendRose( $idBox );
				break;
				
			case "visits" :
				$arr = $_POST['arr'];
				
				$out = makeVisits( $arr );
				break;
			
			default:
				$out = "=== error ===";
				break;
		}
	
	}
		
	function makeVisits( &$arr ){
	
		$db	= new DB();
		
		$_SQL = array();
		
		$out = "";
		
		if($arr){		
			$i = 0;
			$_out = "Count: " . count($arr) . "<br />";
			
			foreach($arr as $id_to){
				
				//$_SQL[] = "UPDATE user_visite SET visite_nb = visite_nb+1 WHERE user_id_to = $id_to  AND user_id_from = " . $_POST["arr_id"][$i] . "<br/>";
				
				
				
				// Chech if user has already visited or not
				$check = "SELECT COUNT(1) FROM user_visite WHERE user_id_to = $id_to  AND user_id_from =" .  $_POST["arr_id"][$i];
				$db->setQuery( $check );
				$count = $db->loadResult();
				
				//$out .= "$i val: " . $count . "<br />";
				
				$incrVisitCounter = "UPDATE user_stats SET visite_total = visite_total+1 WHERE user_id = $id_to";
				
				$db->query( $incrVisitCounter );
				
				if($count > 0){
					$addVisit = "UPDATE user_visite SET visite_nb = visite_nb+1 WHERE user_id_to = $id_to  AND user_id_from = " . $_POST["arr_id"][$i];
					$db->query( $addVisit );
					
					$out = $addVisit;
				}
				else {
					$addNewVisit = "INSERT INTO user_visite(user_id_to, user_id_from, visite_last_date, visite_nb) VALUES ( $id_to , " . $_POST["arr_id"][$i]  . ", now() , 1);";
					
					$db->query( $addNewVisit );
					
					$out = $addNewVisit;
					
				}		
				
				//$out .= $incrVisitCounter . "<br/>" . $addVisit . $addNewVisit . "====<br/>";
				
				//$out = $_SQL[$i];
				
				//$db->setQuery( $incrVisitCounter );
				
				//$db->setQuery( $addVisit );
				
				$i++;
				
			}
		}
		
		/*		
		$query = "SELECT COUNT(1) FROM user_visite";
		$db->setQuery($query);
		$_TEST = $db->loadResult();
		$db->disconnect();
		*/
		
		$db->disconnect();
		
		$out = "Profil(s) mis a jour";
		
		return $out;
		//return flatten1DArray($_SQL);
	
	}
	
	function flatten1DArray(&$array) {
		$out = "";
		
		foreach($array as $item){
			$out .= $item;
		}
		
		return $out;
		
	}

	echo $out;
	exit();
