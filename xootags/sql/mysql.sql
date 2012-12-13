CREATE TABLE `xootags_link` (
  `tl_id` int(10) NOT NULL AUTO_INCREMENT,
  `tag_id` int(10) NOT NULL DEFAULT '0',
  `tag_modid` smallint(5) NOT NULL DEFAULT '0',
  `tag_itemid` int(10) NOT NULL DEFAULT '0',
  `tag_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tl_id`),
  KEY `tag_id` (`tag_id`),
  KEY `tag_time` (`tag_time`),
  KEY `tag_item` (`tag_modid`,`tag_itemid`)
) ENGINE=MyISAM;

CREATE TABLE `xootags_tags` (
  `tag_id` int(10) NOT NULL AUTO_INCREMENT,
  `tag_term` varchar(64) NOT NULL DEFAULT '',
  `tag_status` tinyint(1) NOT NULL DEFAULT '0',
  `tag_count` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tag_id`),
  KEY `tag_term` (`tag_term`),
  KEY `tag_status` (`tag_status`)
) ENGINE=MyISAM;
