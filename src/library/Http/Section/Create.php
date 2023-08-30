<?php

declare(strict_types=1);

namespace App\Psrphp\Section\Http\Section;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Col;
use PsrPHP\Form\Row;
use PsrPHP\Form\Code;
use PsrPHP\Form\Input;
use PsrPHP\Form\Summernote;
use PsrPHP\Form\Textarea;
use PsrPHP\Request\Request;
use PsrPHP\Router\Router;

class Create extends Common
{
    public function get(
        Router $router,
        Request $request
    ) {
        $form = new Builder('添加区块');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Input('type', 'type', $request->get('type')))->setType('hidden'),
                    (new Input('名称', 'name'))->setHelp('名称只能由字母开头，字母、数字、下划线组成，不超过20个字符'),
                    (new Input('备注', 'tips')),
                    ...(function () use ($request, $router): array {
                        $res = [];
                        switch ($request->get('type')) {
                            case 'text':
                                $res[] = (new Textarea('内容', 'content'));
                                break;

                            case 'WYSIWYG':
                                $res[] = (new Summernote('内容', 'content', null, $router->build('/psrphp/admin/tool/upload')));
                                break;

                            case 'tpl':
                                $res[] = (new Code('模板', 'content'))->setHelp('支持{$section}变量');
                                break;

                            case 'data':
                                $res[] = (new Code('渲染模板', 'content'))->setHelp('支持{$section}、{$items}变量');
                                break;

                            default:
                                break;
                        }
                        return $res;
                    })()
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

        if ($db->get('psrphp_section_section', '*', [
            'name' => $name,
        ])) {
            return Response::error('名称不能重复');
        }

        $db->insert('psrphp_section_section', [
            'name' => $name,
            'tips' => $request->post('tips'),
            'type' => $request->post('type'),
            'content' => $request->post('content'),
        ]);

        return Response::success('操作成功！', null, 'javascript:history.go(-2)');
    }
}
