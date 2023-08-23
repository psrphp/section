<?php

declare(strict_types=1);

namespace App\Psrphp\Section\Model;

use PsrPHP\Database\Db;
use PsrPHP\Framework\Framework;
use PsrPHP\Template\Template;

class Section
{
    public static function render(string $name): string
    {
        return Framework::execute(function (
            Db $db,
            Template $template
        ) use ($name): string {
            if ($section = $db->get('psrphp_section_section', '*', [
                'name' => $name,
            ])) {
                switch ($section['type']) {
                    case 'text':
                        return (string)$section['content'];
                        break;

                    case 'WYSIWYG':
                        return (string)$section['content'];
                        break;

                    case 'tpl':
                        $template->renderFromString((string)$section['content'], [
                            'section' => $section,
                        ]);
                        break;

                    case 'data':
                        $template->renderFromString((string)$section['content'], [
                            'section' => $section,
                            'items' => $db->rand('psrphp_section_item', '*', [
                                'section_id' => $section['id'],
                                'state' => 1,
                            ]),
                        ]);
                        break;

                    default:
                        break;
                }
            };
            return '';
        });
    }
}
