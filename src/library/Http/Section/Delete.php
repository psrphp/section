<?php

declare(strict_types=1);

namespace App\Psrphp\Section\Http\Section;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Request\Request;

class Delete extends Common
{
    public function get(
        Db $db,
        Request $request,
    ) {
        $section = $db->get('psrphp_section_section', '*', [
            'id' => $request->get('id'),
        ]);
        $db->delete('psrphp_section_item', [
            'section_id' => $section['id'],
        ]);
        $db->delete('psrphp_section_section', [
            'id' => $request->get('id'),
        ]);
        return Response::success('操作成功！');
    }
}
