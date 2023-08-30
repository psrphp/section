<?php

declare(strict_types=1);

namespace App\Psrphp\Section\Http\Item;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Col;
use PsrPHP\Form\Row;
use PsrPHP\Form\Cover;
use PsrPHP\Form\Input;
use PsrPHP\Form\Radio;
use PsrPHP\Form\Radios;
use PsrPHP\Request\Request;
use PsrPHP\Router\Router;

class Create extends Common
{
    public function get(
        Db $db,
        Router $router,
        Request $request,
    ) {
        $section = $db->get('psrphp_section_section', '*', [
            'id' => $request->get('section_id'),
        ]);

        $form = new Builder('添加数据');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Input('section_id', $section['id'])),
                    (new Input('标题', 'title')),
                    (new Input('标题样式', 'style')),
                    (new Cover('图片', 'pic', null, $router->build('/psrphp/admin/tool/upload'))),
                    (new Input('链接地址', 'url', null)),
                    (new Radios('是否发布'))->addRadio(
                        new Radio('否', 'state', 0, true),
                        new Radio('是', 'state', 1, false),
                    )
                )
            )
        );
        return $form;
    }

    public function post(
        Db $db,
        Request $request
    ) {
        $section = $db->get('psrphp_section_section', '*', [
            'id' => $request->post('section_id'),
        ]);

        $db->insert('psrphp_section_item', [
            'section_id' => $section['id'],
            'title' => $request->post('title'),
            'style' => $request->post('style'),
            'pic' => $request->post('pic'),
            'url' => $request->post('url'),
            'state' => $request->post('state'),
        ]);

        return Response::success('操作成功！');
    }
}
