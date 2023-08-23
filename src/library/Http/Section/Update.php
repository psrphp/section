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

class Update extends Common
{
    public function get(
        Db $db,
        Router $router,
        Request $request,
    ) {
        $section = $db->get('psrphp_section_section', '*', [
            'id' => $request->get('id'),
        ]);
        $form = new Builder('编辑区块');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-8'))->addItem(
                    (new Hidden('id', $section['id'])),
                    (new Input('备注', 'tips', $section['tips'])),
                    ...(function () use ($router, $section): array {
                        $res = [];
                        switch ($section['type']) {
                            case 'text':
                                $res[] = (new Textarea('内容', 'content', $section['content']));
                                break;

                            case 'WYSIWYG':
                                $res[] = (new Summernote('内容', 'content', $section['content'], $router->build('/psrphp/admin/tool/upload')));
                                break;

                            case 'tpl':
                                $res[] = (new Code('模板', 'content', $section['content']))->set('help', '支持{$section}变量');
                                break;

                            case 'data':
                                $res[] = (new Code('渲染模板', 'content', $section['content']))->set('help', '支持{$section}、{$items}变量');
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
        Request $request,
    ) {
        $section = $db->get('psrphp_section_section', '*', [
            'id' => $request->post('id'),
        ]);
        $db->update('psrphp_section_section', [
            'tips' => $request->post('tips'),
            'content' => $request->post('content'),
        ], [
            'id' => $section['id'],
        ]);
        return Response::success('操作成功！');
    }
}
