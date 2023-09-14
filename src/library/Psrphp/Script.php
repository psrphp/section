<?php

declare(strict_types=1);

namespace App\Psrphp\Section\Psrphp;

use PsrPHP\Framework\Script as FrameworkScript;

class Script
{
    public static function onInstall()
    {
        $sql = <<<'str'
DROP TABLE IF EXISTS `prefix_psrphp_section`;
CREATE TABLE `prefix_psrphp_section` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `name` varchar(255) NOT NULL COMMENT '名称',
    `tpl` text COMMENT '模板',
    `tips` varchar(255) COMMENT '备注',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='区块表';
str;
        FrameworkScript::execSql($sql);
    }

    public static function onUnInstall()
    {
        $sql = <<<'str'
DROP TABLE IF EXISTS `prefix_psrphp_section`;
str;
        FrameworkScript::execSql($sql);
    }
}
