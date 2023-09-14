<?php

declare(strict_types=1);

namespace App\Psrphp\Section\Model;

use Psr\Log\LoggerInterface;
use PsrPHP\Database\Db;
use PsrPHP\Framework\Framework;
use PsrPHP\Template\Template;
use Throwable;

class Section
{
    public static function render(string $name): string
    {
        return Framework::execute(function (
            Db $db,
            Template $template,
            LoggerInterface $logger,
        ) use ($name): string {
            if (!$section = $db->get('psrphp_section', '*', [
                'name' => $name,
            ])) {
                return '<div style="border: 1px solid red;padding: 10px;color: red;">区块 <code>' . $name . '</code> 不存在，请在后台创建~</div>';
            }
            try {
                return $template->renderFromString((string)$section['tpl'], [
                    'section' => $section,
                ]);
            } catch (Throwable $th) {
                $logger->error('区块渲染错误：[name:' . $name . '] ' . $th->getMessage(), $th->getTrace());
                return '<div style="border: 1px solid red;padding: 10px;color: red;">区块 <code>' . $name . '</code> 渲染错误，请看系统日志~</div>';
            }
        });
    }
}
