<?php

declare(strict_types=1);

namespace App\Psrphp\Section\Http\Item;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Database\Db;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Component\Col;
use PsrPHP\Form\Component\Row;
use PsrPHP\Form\Field\Cover;
use PsrPHP\Form\Field\Hidden;
use PsrPHP\Form\Field\Input;
use PsrPHP\Form\Field\Radio;
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
                    (new Hidden('id', $item['id'])),
                    (new Input('标题', 'title', $item['title'])),
                    (new Input('标题样式', 'style', $item['style'])),
                    (new Cover('图片', 'pic', $item['pic'], $router->build('/psrphp/admin/tool/upload'))),
                    (new Input('链接地址', 'url', $item['url'])),
                    (new Radio('是否发布', 'state', $item['state'], [
                        '0' => '否',
                        '1' => '是',
                    ]))
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
            'type' => $request->post('type'),
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
