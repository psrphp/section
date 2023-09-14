<?php

declare(strict_types=1);

namespace App\Psrphp\Section\Http;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Code;
use PsrPHP\Form\Col;
use PsrPHP\Form\Hidden;
use PsrPHP\Form\Input;
use PsrPHP\Form\Row;
use PsrPHP\Request\Request;

class Update extends Common
{
    public function get(
        Db $db,
        Request $request,
    ) {
        $section = $db->get('psrphp_section', '*', [
            'id' => $request->get('id'),
        ]);
        $form = new Builder('编辑区块');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-8'))->addItem(
                    (new Hidden('id', $section['id'])),
                    (new Code('模板', 'tpl', $section['tpl']))->setHelp('支持{$section}变量'),
                    (new Input('备注', 'tips', $section['tips'])),
                )
            )
        );
        return $form;
    }

    public function post(
        Db $db,
        Request $request,
    ) {
        $section = $db->get('psrphp_section', '*', [
            'id' => $request->post('id'),
        ]);
        $db->update('psrphp_section', [
            'tpl' => $request->post('tpl'),
            'tips' => $request->post('tips'),
        ], [
            'id' => $section['id'],
        ]);
        return Response::success('操作成功！');
    }
}
