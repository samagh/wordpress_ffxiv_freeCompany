CREATE TABLE IF NOT EXISTS ff_characters
(
	id  INT,
	name  VARCHAR(50),
	world  VARCHAR(50),
	title  VARCHAR(50),
	avatar  VARCHAR(255),
	avatarTimestamp  INT,
	avatarHash  VARCHAR(255),
	portrait  VARCHAR(255),
	portraitTimestamp  INT,
	bio  VARCHAR(255),
	race  VARCHAR(50),
	clan  VARCHAR(50),
	gender  VARCHAR(50),
	nameday  VARCHAR(50),
	guardian  VARCHAR(50),
	guardianIcon  VARCHAR(255),
	city  VARCHAR(50),
	cityIcon  VARCHAR(255),
	activeClass  VARCHAR(50),
	activeJob  VARCHAR(50),
	activeLevel  INT,
	grandCompany  VARCHAR(50),
	freeCompanyId  VARCHAR(50),
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS ff_GrandCompany
(
	grandCompany  VARCHAR(50),
	grandCompanyRank  VARCHAR(50),
	grandCompanyIcon  VARCHAR(50),
	PRIMARY KEY (grandCompany)
);


CREATE TABLE IF NOT EXISTS ff_FreeCompany 
(
	freeCompany  VARCHAR(50),
	freeCompanyId  VARCHAR(50),
--	TODO : Seguir añadiendo los campos

	PRIMARY KEY (freeCompanyId)
);

CREATE TABLE IF NOT EXISTS ff_FreeCompanyIcon 
(
	freeCompanyId  VARCHAR(50),
	icon  VARCHAR(50),
	PRIMARY KEY (freeCompanyId,icon)
);

CREATE TABLE IF NOT EXISTS ff_ClassJobs 
(
	character_id  INT,
	icon  VARCHAR(255),
	iconTimestamp  INT,
	iconQueryString  VARCHAR(255),
	name  VARCHAR(50),
	level  INT,
	exp_current  INT,
	exp_level  INT,
	exp_total  INT,
	id  INT,
	real_id  INT,
	PRIMARY KEY(character_id,id)
);

CREATE TABLE IF NOT EXISTS ff_Gear 
(
	id VARCHAR(50),
	mirage  VARCHAR(50),
	mirageType  VARCHAR(50),
	miragePaintColor  VARCHAR(50),
	icon  VARCHAR(50),
	iconTimestamp  INT,
	iconQueryString  VARCHAR(255),
	rare  VARCHAR(50),
	binding  VARCHAR(50),
	color  VARCHAR(50),
	name  VARCHAR(50),
	hq  INT,
	mirageItemIcon  VARCHAR(255),
	mirageItemIconTimestamp  VARCHAR(50),
	mirageItemIconQueryString  VARCHAR(50),
	mirageItemName  VARCHAR(50),
	mirageItemId  VARCHAR(50),
	slot  VARCHAR(50),
	ilv  INT,
	classes  VARCHAR(50),
	durability  VARCHAR(50),
	spiritbond  VARCHAR(50),
	repairClass  VARCHAR(50),
	repairLevel  INT,
	materials  VARCHAR(50),
	convertible  VARCHAR(50),
	projectable  VARCHAR(50),
	desynthesizable  VARCHAR(50),
	sellable  VARCHAR(50),
	damage  INT,
	auto_attack  VARCHAR(50),
	delay  VARCHAR(50),
	realId  INT,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS ff_GearCharacter
(
	gear_id		VARCHAR(50),
	character_id	INT,
	slot_id		INT,
	PRIMARY KEY (gear_id,character_id,slot_id)
);

CREATE TABLE IF NOT EXISTS ff_GearLevelBonus 
(
--      [Caj]
	gear_id  VARCHAR(50),

        type  VARCHAR(50),
        value  INT,
	PRIMARY KEY (realId,type)
);

CREATE TABLE IF NOT EXISTS ff_GearBonus 
(
	character_id  INT,
	attributes  VARCHAR(50),
	total  INT,
	PRIMARY KEY(character_id,attributes)
);

CREATE TABLE IF NOT EXISTS ff_GearBonusItems 
(
        character_id  INT,
        attributes  VARCHAR(50),
        value  INT,
        name  VARCHAR(50),
	PRIMARY KEY (character_id,attributes,name)
);


CREATE TABLE IF NOT EXISTS ff_GearStats 
(
        character_id  INT,
	id_stats  INT,
	value  INT,
	PRIMARY KEY (character_id,id_stats)
);

CREATE TABLE IF NOT EXISTS ff_Attributes 
(
        character_id  INT,
	clearfix_normal  INT,
	cp  INT,
	gp  INT,
	hp  INT,
	mp  INT,
	tp  INT,
	PRIMARY KEY (character_id)
);

CREATE TABLE IF NOT EXISTS ff_Minions 
(
        character_id  INT,
	name  VARCHAR(50),
	icon  VARCHAR(50),
	iconTimestamp  INT,
	PRIMARY KEY(character_id,name)
);

CREATE TABLE IF NOT EXISTS ff_Mounts 
(
        character_id  INT,
	name  VARCHAR(50),
	icon  VARCHAR(50),
	iconTimestamp  INT,
	PRIMARY KEY (character_id,name)
);

CREATE TABLE IF NOT EXISTS `ff_classinfo` (
  `id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `avatar_url` tinytext,
  `portrait_url` tinytext,  
  `rank` tinytext,
  `gladiator` tinyint(2) NOT NULL DEFAULT '0',
  `pugilist` tinyint(2) NOT NULL DEFAULT '0',
  `marauder` tinyint(2) NOT NULL DEFAULT '0',
  `lancer` tinyint(2) NOT NULL DEFAULT '0',
  `archer` tinyint(2) NOT NULL DEFAULT '0',
  `rogue` tinyint(4) NOT NULL DEFAULT '0',
  `conjurer` tinyint(2) NOT NULL DEFAULT '0',
  `thaumaturge` tinyint(2) NOT NULL DEFAULT '0',
  `arcanist` tinyint(2) NOT NULL DEFAULT '0',
  `dark knight` tinyint(2) NOT NULL DEFAULT '0',
  `machinist` tinyint(2) NOT NULL DEFAULT '0',
  `astrologian` tinyint(2) NOT NULL DEFAULT '0',
  `carpenter` tinyint(2) NOT NULL DEFAULT '0',
  `blacksmith` tinyint(2) NOT NULL DEFAULT '0',
  `armorer` tinyint(2) NOT NULL DEFAULT '0',
  `goldsmith` tinyint(2) NOT NULL DEFAULT '0',
  `leatherworker` tinyint(2) NOT NULL DEFAULT '0',
  `weaver` tinyint(2) NOT NULL DEFAULT '0',
  `alchemist` tinyint(2) NOT NULL DEFAULT '0',
  `culinarian` tinyint(2) NOT NULL DEFAULT '0',
  `miner` tinyint(2) NOT NULL DEFAULT '0',
  `botanist` tinyint(2) NOT NULL DEFAULT '0',
  `fisher` tinyint(2) NOT NULL DEFAULT '0'
)
