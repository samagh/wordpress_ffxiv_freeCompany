<?php

include('export_config.php');
include('export_player.php');

//add_action('ffxiv_update_db','ffxiv_update_db');
add_action('ffxiv_update_db',function() { ffxiv_update_db(); });

function ffxiv_update_db()
{
    require dirname(__FILE__).'/lib/api-autoloader.php';
    $api = new Viion\Lodestone\LodestoneAPI();
    global $wpdb;

    $fc_id = get_option('ffxiv_data_fc_id');
    if (!$fc_id || strlen($fc_id) < 1) {
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT option_value FROM $wpdb->options WHERE option_name = %s LIMIT 1", 'ffxiv_data_fc_id' ) );
	$fc_id = $row->option_value;

	if (!$fc_id || strlen($fc_id) < 1)
	{
		echo "<b>No se ha establecido Id de la FreeCompany</b>";
		return;
	}
    }

    if ( $api->Search->isMaintenance() )
    {
	echo "<b>Servidor bajo mantenimiento.</b>";
	return;
    } else {
//	echo "ID = '$fc_id'\n";
	$FreeCompany = $api->Search->FreeCompany($fc_id, true);
	// DEBUG : print_r( $FreeCompany->dump() );
	$query = "TRUNCATE TABLE ff_classinfo";
	$wpdb->query( $query );
	foreach( $FreeCompany->members as $Member )
	{
		$id = $Member["id"];
		$Character = $api->Search->Character($id);
		$rank = "<img src='".$Member["rank"]["icon"]."' title='".$Member["rank"]["title"]."'/>";
		$ClassJobs = $Character->classjobs;
		$avatar = $Character->avatar;
		$portrait = $Character->portrait;
		$sql_columns = "id,name,rank";
		$name = $Character->name;
		$sql_values = "$id,\"$name\",\"$rank\"";
		
		for ( $i = 0; $i < count( $ClassJobs ); $i++ )
		{
			$sql_columns .= ",`".$ClassJobs[$i]["name"]."`";
			if ( $ClassJobs[$i]["level"] != "-" )
				$sql_values .=  ",".$ClassJobs[$i]["level"];
			else
				$sql_values .=  ",0";
		}
		
		$sql_columns .= ",avatar_url,portrait_url";
		$sql_values .= ",'$avatar','".$portrait."'";
		$query = "INSERT INTO ff_classinfo ( $sql_columns ) VALUES ( $sql_values )";
		$wpdb->query( $query );
		export_player($Character);
	}
    }
}

?>
