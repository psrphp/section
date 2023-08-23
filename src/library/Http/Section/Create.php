<?php

declare(strict_types=1);

namespace App\Psrphp\Section\Http\Section;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Component\Col;
use PsrPHP\Form\Component\Row;
use PsrPHP\Form\Field\Code;
use PsrPHP\Form\Field\Hidden;
use PsrPHP\Form\Field\Input;
use PsrPHP\Form\Field\Summernote;
use PsrPHP\Form\Field\Textarea;
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
                    (new Hidden('type', $request->get('type'))),
                    (new Input('名称', 'name'))->set('help', '名称只能由字母开头，字母、数字、下划线组成，不超过20个字符'),
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
                                $res[] = (new Code('模板', 'content'));
                                break;

                            case 'data':
                                $res[] = (new Code('渲染模板', 'content'));
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
