<?php

function dump_insert($table, $array, $valid_array)
{
	global $wpdb;
	$t = "";
	$v = "";
	foreach($array as $name => $value )
	{
		$name = str_replace('-','_',$name);
        	if (!in_array($name , $valid_array)) continue;
        	if (is_array($value)) continue;
        	       
        	if ( $value == "".(int)$value."" && strlen($value) > 0) {
        	        $t .= $name . ",";
        	        $v .= $value . ",";
        	} else {
        	        $t .= $name . ",";
        	        $v .= '"' . $value . '",';
        	}
	}
	// Eliminamos la ultima ,
	$t = substr($t, 0, -1);
	$v = substr($v, 0, -1);
	$sql = "REPLACE INTO {$table} ({$t}) VALUES ({$v});";
	$wpdb->query( $sql );
	// DEBUG : echo "$sql<br>";
}

function export_player($Character)
{
	include('export_config.php');
	$struct = $Character->dump();

	/*
	 *	TABLA PRINCIPAL
	 */
	echo dump_insert("ff_characters",$struct,$rows["ff_characters"])."\n";

	$add_array = array ( "character_id" => $struct["id"] , "freeCompanyId" => $struct["freeCompanyId"] );

	/*
	 *	TABLAS DIRECTAS
	 */
	foreach($tablas as $modo => $tabla)
	{
		switch($modo)
		{
		case "root" :
			foreach ($tabla as $in_array => $in_sql)
				echo dump_insert($in_sql,$struct,$rows[$in_sql])."\n";
		break;
		case "icon" :
			foreach ($tabla as $in_array => $in_sql)
	                        foreach($struct[$in_array] as $entrada)
	                                echo dump_insert($in_sql , array_merge($add_array, array ( "icon" => $entrada ) ) , $rows[$in_sql])."\n";
		break;
		case "direct" :
			foreach ($tabla as $in_array => $in_sql)
				echo dump_insert($in_sql , array_merge($add_array, $struct[$in_array]) , $rows[$in_sql])."\n";
		break;
                case "gear" :
                        foreach ($tabla as $in_array => $in_sql)
                                foreach($struct[$in_array] as $entrada)
                                {
                                        echo dump_insert($in_sql , array_merge($add_array,$entrada) , $rows[$in_sql])."\n";
                                        foreach($entrada["bonuses"] as $bonus)
                                        {
                                                echo dump_insert("ff_GearLevelBonus",array_merge($bonus, array( "gear_id" => $entrada["id"] ) ), $rows["ff_GearLevelBonus"])."\n";
                                        }
        			}
                break;
		case "gearCharacter" :
	                foreach ($tabla as $in_array => $in_sql)
	                        foreach($struct[$in_array] as $slot_id => $entrada)
				{
					echo dump_insert($in_sql , array_merge($entrada , $add_array, array("gear_id" => "{$entrada["id"]}", "slot_id" => $slot_id)) , $rows[$in_sql])."\n";
				}
		break;


		case "gearBonus":
			foreach($tabla as $in_array => $in_sql)
				foreach($struct[$in_array] as $attribute => $valores)
				{
					echo dump_insert($in_sql , array_merge($add_array, $valores, array("attributes" => "$attribute" )) , $rows[$in_sql])."\n";
					foreach($valores["items"] as $item)
					{
						echo dump_insert("ff_GearBonusItems" , array_merge($add_array, $item, array("attributes" => "$attribute" )) , $rows["ff_GearBonusItems"])."\n";
					}
				}
		break;
		case "array" :
			foreach ($tabla as $in_array => $in_sql)
				foreach($struct[$in_array] as $entrada)
					echo dump_insert($in_sql , array_merge($add_array,$entrada) , $rows[$in_sql])."\n";
		break;
		}
	
	}
} /* function export_player() */

?>
