<?php

declare(strict_types=1);

namespace App\Psrphp\Section\Http\Item;

use App\Psrphp\Admin\Http\Common;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;
use PsrPHP\Template\Template;

class Index extends Common
{
    public function get(
        Db $db,
        Request $request,
        Template $template
    ) {
        $section = $db->get('psrphp_section_section', '*', [
            'id' => $request->get('section_id'),
        ]);
        $items = $db->select('psrphp_section_item', '*', [
            'section_id' => $section['id']
        ]);
        return $template->renderFromFile('item/index@psrphp/section', [
            'section' => $section,
            'items' => $items,
        ]);
    }
}
