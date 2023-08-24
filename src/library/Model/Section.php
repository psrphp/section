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
            if ($section = $db->get('psrphp_section_section', '*', [
                'name' => $name,
            ])) {
                try {
                    switch ($section['type']) {
                        case 'text':
                            return (string)$section['content'];
                            break;

                        case 'WYSIWYG':
                            return (string)$section['content'];
                            break;

                        case 'tpl':
                            return $template->renderFromString((string)$section['content'], [
                                'section' => $section,
                            ]);
                            break;

                        case 'data':
                            return $template->renderFromString((string)$section['content'], [
                                'section' => $section,
                                'items' => $db->rand('psrphp_section_item', '*', [
                                    'section_id' => $section['id'],
                                    'state' => 1,
                                ]),
                            ]);
                            break;

                        default:
                            $logger->error('区块渲染错误：[name:' . $name . '] 类型' . $section['type'] . '不支持~');
                            return '<div style="border: 1px solid red;padding: 10px;color: red;">广告 <code>' . $name . '</code> 渲染错误，请看系统日志~</div>';
                            break;
                    }
                } catch (Throwable $th) {
                    $logger->error('区块渲染错误：[name:' . $name . '] ' . $th->getMessage(), $th->getTrace());
                    return '<div style="border: 1px solid red;padding: 10px;color: red;">区块 <code>' . $name . '</code> 渲染错误，请看系统日志~</div>';
                }
            } else {
                return '<div style="border: 1px solid red;padding: 10px;color: red;">区块 <code>' . $name . '</code> 不存在，请在后台创建~</div>';
            };
        });
    }
}
