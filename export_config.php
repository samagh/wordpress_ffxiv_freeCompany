<?php
	$rows = array(
	"ff_characters" => array( "id","name","world","title","avatar","avatarTimestamp","avatarHash","portrait","portraitTimestamp","bio","race","clan",
	                 "gender","nameday","guardian","guardianIcon","city","cityIcon","activeClass","activeJob","activeLevel",
	                 "grandCompany","freeCompanyId" ),
	"ff_ClassJobs" => array( "character_id","icon","iconTimestamp","iconQueryString","name","level","exp_current","exp_level","exp_total","id","real_id" ),
	"ff_Gear" => array( "id","mirage","mirageType","miragePaintColor","icon","iconTimestamp","iconQueryString","rare","binding",
	            "color","name","hq","mirageItemIcon","mirageItemIconTimestamp","mirageItemIconQueryString","mirageItemName","mirageItemId",
	            "slot","ilv","classes","durability","spiritbond","repairClass","repairLevel","materials","convertible","projectable",
	            "desynthesizable","sellable","damage","auto_attack","delay","RealId" ),
	"ff_GearCharacter" => array ( "gear_id","character_id","slot_id" ),
	"ff_GearLevelBonus" => array( "character_id","gear_id","type","value" ),
	"ff_GearBonus" => array( "character_id","attributes","total" ),
	"ff_GearBonusItems" => array( "character_id","attributes","value","name" ),
	"ff_GearStats" => array( "character_id","id_stats","value" ),
	"ff_Attributes" => array( "character_id","clearfix_normal","cp","gp","hp","mp","tp" ),
	"ff_Minions" => array( "character_id","name","icon","iconTimestamp" ),
	"ff_Mounts" => array( "character_id","name","icon","iconTimestamp" ),
	);

	$tablas = array(
	        "direct"        => array ( "attributes" => "ff_Attributes" ),
	        "gearBonus"     => array ( "gearBonus" => "ff_GearBonus" ),
	        "gear"          => array ( "gear" => "ff_Gear" ),
	        "gearCharacter" => array ( "gear" => "ff_GearCharacter" ),
	        "array"         => array ( "classjobs" => "ff_ClassJobs", "minions" => "ff_Minions", "mounts" => "ff_Mounts" )
	);
