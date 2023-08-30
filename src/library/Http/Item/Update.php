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

class Update extends Common
{
    public function get(
        Db $db,
        Router $router,
        Request $request,
    ) {
        $item = $db->get('psrphp_section_item', '*', [
            'id' => $request->get('id'),
        ]);
        $form = new Builder('编辑广告');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-8'))->addItem(
                    (new Input('id', 'id', $item['id']))->setType('hidden'),
                    (new Input('标题', 'title', $item['title'])),
                    (new Input('标题样式', 'style', $item['style'])),
                    (new Cover('图片', 'pic', $item['pic'], $router->build('/psrphp/admin/tool/upload'))),
                    (new Input('链接地址', 'url', $item['url'])),
                    (new Radios('是否发布'))->addRadio(
                        new Radio('否', 'state', 0, $item['state'] == 0),
                        new Radio('是', 'state', 1, $item['state'] == 1),
                    )
                )
            )
        );
        return $form;
    }

    public function post(
        Db $db,
        Request $request,
    ) {
        $item = $db->get('psrphp_section_item', '*', [
            'id' => $request->post('id'),
        ]);
        $db->update('psrphp_section_item', [
            'title' => $request->post('title'),
            'style' => $request->post('style'),
            'pic' => $request->post('pic'),
            'url' => $request->post('url'),
            'state' => $request->post('state'),
        ], [
            'id' => $item['id'],
        ]);
        return Response::success('操作成功！');
    }
}
