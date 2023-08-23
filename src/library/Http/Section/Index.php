<?php

declare(strict_types=1);

namespace App\Psrphp\Section\Http\Section;

use App\Psrphp\Admin\Http\Common;
use PsrPHP\Database\Db;
use PsrPHP\Template\Template;

class Index extends Common
{
    public function get(
        Db $db,
        Template $template
    ) {
        return $template->renderFromFile('section/index@psrphp/section', [
            'sections' => $db->select('psrphp_section_section', '*'),
        ]);
    }
}
