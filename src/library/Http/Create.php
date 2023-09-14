<?php

declare(strict_types=1);

namespace App\Psrphp\Section\Http;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Col;
use PsrPHP\Form\Row;
use PsrPHP\Form\Code;
use PsrPHP\Form\Input;
use PsrPHP\Request\Request;

class Create extends Common
{
    public function get()
    {
        $form = new Builder('添加区块');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Input('名称', 'name'))->setHelp('名称只能由字母开头，字母、数字、下划线组成，不超过20个字符'),
                    (new Code('模板', 'tpl'))->setHelp('支持{$section}变量'),
                    (new Input('备注', 'tips')),
                )
            )
        );
        return $form;
    }

    public function post(
        Db $db,
        Request $request
    ) {
        $name = $request->post('name');

        if (!preg_match('/^[A-Za-z][A-Za-z0-9_]{0,18}[A-Za-z0-9]$/', $name)) {
            return Response::error('名称只能由字母开头，字母、数字、下划线组成，不超过20个字符');
        }

        if ($db->get('psrphp_section', '*', [
            'name' => $name,
        ])) {
            return Response::error('名称不能重复');
        }

        $db->insert('psrphp_section', [
            'name' => $name,
            'tpl' => $request->post('tpl'),
            'tips' => $request->post('tips'),
        ]);

        return Response::success('操作成功！', null, 'javascript:history.go(-2)');
    }
}
