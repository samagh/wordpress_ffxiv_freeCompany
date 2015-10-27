<?php

if ( is_admin() ){
	/* Call the html code */
	add_action('admin_menu', 'ffxiv_admin_menu');
	function ffxiv_admin_menu() {
		add_options_page('FFXIV', 'FFXIV', 'administrator','ffxiv', 'ffxiv_html_page');
	}
}

function ffxiv_html_page() {
?>
<div>
<h2>FFXIV Options</h2>
<form method="post" action="options.php">
<?php wp_nonce_field('update-options');

    require dirname(__FILE__).'/lib/api-autoloader.php';
    $api = new Viion\Lodestone\LodestoneAPI();

    if ( $api->Search->isMaintenance() )
    {
	echo "<b>Servidor bajo mantenimiento.</b>";
    } else {
	echo "<b>Servidor Operativo.</b>";
    }

    $FreeCompany = $api->Search->FreeCompany( get_option('ffxiv_data_fc_id') , true);
?>
<table width="510">
	<tr valign="top">
		<th scope="row">Enter Free Company ID</th>
		<td >
		<input name="ffxiv_data_fc_id" type="text" id="ffxiv_data_fc_id" value="<?php echo get_option('ffxiv_data_fc_id'); ?>" />(ex. 11..22..33)</td>
	</tr>
	<tr>
		<td>Free Company Name</td>
		<td><?php if ($FreeCompany) echo $FreeCompany->name; else echo "&nbsp;"; ?></td>
	</tr>
</table>

    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="ffxiv_data_fc_id" />
    <p>
	<input type="submit" value="<?php _e('Save Changes') ?>" />
    </p>
</form>
</div>

<table>
    <tr>
	<th>Tabla</th>
	<th>Campos</th>
    </tr>
<?php
	/* Mostramos la info de la bbdd */
	global $wpdb;
	$query = "SELECT table_name AS t FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name LIKE 'ff_%'";
	$tables = $wpdb->get_results( $query );
	foreach ($tables as $tabla)
	{
		$sql = "SELECT COUNT(*) FROM ".$tabla->t.";";
		$c = $wpdb->get_var( $sql );
		echo "<tr><td>".$tabla->t."</td><td>".$c."</td></tr>";
	}
?>
</table>
<?php
}

function ffxiv_freeCompany_classes_html()
{
?>
<!-- Check if jQuery has been loaded... -->
<script>
	window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"><\/script>')
</script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<?php
include('config.php');
global $wpdb;

// Fetch how many rows we have so we can fill the select box
$query = "SELECT COUNT(*) AS n FROM ff_classinfo";
$res = $wpdb->get_results( $query );
$rows = $res[0]->n;
unset( $res );
//$url = plugins_url() . "/ffxiv/";
$url = dirname (__FILE__) . "/";
print "<link rel='stylesheet' type='text/css' href='".$url."style/style.css'>
		<script type='text/javascript' src='".$url."lib/jquery.tablesorter.min.js'></script>
		<script type='text/javascript' src='".$url."lib/jquery.tablesorter.widgets.min.js'></script>
		<script type='text/javascript' src='".$url."lib/jquery.tablesorter.pager.min.js'></script>";
//pager( $rows );
echo "<table class='tablesorter'><thead><tr><th width='20%'>Name</th><th width='5%'>Rank</th>";

// Generate table headers (this is also a decent place to fill our max values, there's no point doing a for loop twice)
foreach( $classes as $data )
{
		echo "<th class='".$data['type']."' title='".ucwords( $data['name'] )."'><img src=".$url.$data['image']."></th>";
		
		//Max query and array storage
		$query = "SELECT MAX( `".$data['name']."` ) AS n FROM ff_classinfo";
		$res = $wpdb->get_results( $query );
		$obj = $res[0];
		$values[$data['name']] = intval( $obj->n );
		unset( $obj );
		unset( $res );
}
echo "</tr></thead><tbody>";

// Generate our query
$query = "SELECT * FROM ff_classinfo";
if ( $result = $wpdb->get_results( $query ) )
{
	// We have our result, generate our table data
	foreach( $result as $row )
	{
		print "<tr>
		<td width='20%' title='".$row->name."' style='text-align: left;'><img class='members' src='".$row->avatar_url."'/> <a portrait='".$row->portrait_url."' class='char' href='/character/?id=".$row->id."' target=_blank>".$row->name."</a></td>
		<td>".$row->rank."</td>";
		foreach( $classes as $data )
		{
			$row->$data['name'] == $values[$data['name']] ?	$num = "<b>".$row->$data['name']."</b>" : $num = $row->$data['name'];
			echo "<td class=".$data['name']." style='text-align: center;'>$num</td>";
		}
		echo "</tr>";
	}
	unset( $result );
}
echo "</tbody></table>";
//pager( $rows );
?>
<script type='text/javascript'>
	jQuery('table').tablesorter({
		widgets: ['zebra', 'columns'],
		sortInitialOrder: "desc"
	}).tablesorterPager({
		container: jQuery(".pager"),
		output: '{startRow} to {endRow} ({totalRows})',
		size: 200,
		removeRows: true
	});
        jQuery( '.char' ).tooltip({
                content: function() {
                        var portrait = jQuery( this ).find('a').attr('portrait');
                        return "<img height='320' width='240' src='" + portrait + "'>";
                }
        });
</script>
<?php
}

function ffxiv_freeCompany_jobs_html()
{
?>
<!-- Check if jQuery has been loaded... -->
<script>
	window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"><\/script>')
</script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<?php
include('config.php');
global $wpdb;

// Fetch how many rows we have so we can fill the select box
$query = "SELECT COUNT(*) AS n FROM ff_classinfo";
$res = $wpdb->get_results( $query );
$rows = $res[0]->n;
unset( $res );
//$url = plugins_url() . "/ffxiv/";
$url = dirname (__FILE__) . "/";
print "<link rel='stylesheet' type='text/css' href='".$url."style/style.css'>
		<script type='text/javascript' src='".$url."lib/jquery.tablesorter.min.js'></script>
		<script type='text/javascript' src='".$url."lib/jquery.tablesorter.widgets.min.js'></script>
		<script type='text/javascript' src='".$url."lib/jquery.tablesorter.pager.min.js'></script>";
//pager( $rows );
echo "<table class='tablesorter'><thead><tr><th width='20%'>Name</th><th width='5%'>Rank</th>";

// Generate table headers (this is also a decent place to fill our max values, there's no point doing a for loop twice)
//foreach( $classes as $data )
foreach( $jobs as $data )
{
		echo "<th class='".$data['type']."' title='".ucwords( $data['name'] )."'><img src=".$url.$data['image']."></th>";
		
		//Max query and array storage
		$query = "SELECT MAX( `".$data['name']."` ) AS n FROM ff_classinfo";
		$res = $wpdb->get_results( $query );
		$obj = $res[0];
		$values[$data['name']] = intval( $obj->n );
		unset( $obj );
		unset( $res );
}
echo "</tr></thead><tbody>";

// Generate our query
$query = "SELECT * FROM ff_classinfo";
if ( $result = $wpdb->get_results( $query ) )
{
	// We have our result, generate our table data
	foreach( $result as $row )
	{
		print "<tr>
		<td width='20%' title='".$row->name."' style='text-align: left;'><img class='members' src='".$row->avatar_url."'/> <a portrait='".$row->portrait_url."' class='char' href='/character/?id=".$row->id."' target=_blank>".$row->name."</a></td>
		<td>".$row->rank."</td>";
		//foreach( $classes as $data )
		foreach( $jobs as $data )
		{
			$row->$data['name'] == $values[$data['name']] ?	$num = "<b>".$row->$data['name']."</b>" : $num = $row->$data['name'];
			echo "<td class=".$data['name']." style='text-align: center;'>$num</td>";
		}
		echo "</tr>";
	}
	unset( $result );
}
echo "</tbody></table>";
//pager( $rows );
?>
<script type='text/javascript'>
	jQuery('table').tablesorter({
		widgets: ['zebra', 'columns'],
		sortInitialOrder: "desc"
	}).tablesorterPager({
		container: jQuery(".pager"),
		output: '{startRow} to {endRow} ({totalRows})',
		size: 200,
		removeRows: true
	});
	jQuery( '.char' ).tooltip({
      		content: function() {
			var portrait = jQuery( this ).find('a').attr('portrait');
          		return "<img height='320' width='240' src='" + portrait + "'>";
      		}
    	});
</script>
<?php
}
