<?php

declare(strict_types=1);

namespace App\Psrphp\Section\Psrphp;

use PsrPHP\Framework\Script as FrameworkScript;

class Script
{
    public static function onInstall()
    {
        $sql = <<<'str'
DROP TABLE IF EXISTS `prefix_psrphp_section_section`;
CREATE TABLE `prefix_psrphp_section_section` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `name` varchar(255) NOT NULL COMMENT '名称',
    `tips` varchar(255) COMMENT '备注',
    `type` varchar(255) COMMENT '类型',
    `content` text COMMENT '内容',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='区块表';
DROP TABLE IF EXISTS `prefix_psrphp_section_item`;
CREATE TABLE `prefix_psrphp_section_item` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `section_id` int(10) unsigned NOT NULL COMMENT '所属区块id',
    `title` varchar(255) COMMENT '标题',
    `style` varchar(255) COMMENT '标题样式',
    `pic` varchar(255) COMMENT '图片',
    `url` varchar(255) COMMENT '跳转地址',
    `state` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否发布',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='区块数据';
str;
        FrameworkScript::execSql($sql);
    }

    public static function onUnInstall()
    {
        $sql = <<<'str'
DROP TABLE IF EXISTS `prefix_psrphp_section_section`;
DROP TABLE IF EXISTS `prefix_psrphp_section_item`;
str;
        FrameworkScript::execSql($sql);
    }
}
