{include common/header@psrphp/admin}
<h1>区块管理</h1>

<fieldset>
    <legend>新增</legend>
    <a href="{:$router->build('/psrphp/section/section/create', ['type'=>'text'])}">简单文本</a>
    <a href="{:$router->build('/psrphp/section/section/create', ['type'=>'WYSIWYG'])}">富文本</a>
    <a href="{:$router->build('/psrphp/section/section/create', ['type'=>'tpl'])}">模板</a>
    <a href="{:$router->build('/psrphp/section/section/create', ['type'=>'data'])}">数据</a>
</fieldset>

<table style="margin-top: 20px;">
    <thead>
        <tr>
            <th>名称</th>
            <th>备注</th>
            <th>调用</th>
            <th>管理</th>
        </tr>
    </thead>
    <tbody>
        {foreach $sections as $vo}
        <tr>
            <td>
                {$vo.name}
            </td>
            <td>
                {$vo.tips}
            </td>
            <td><code>{literal}{section{/literal} {$vo.name}{literal}}{/literal}</code></td>
            <td>
                <a href="{:$router->build('/psrphp/section/section/update', ['id'=>$vo['id']])}">编辑</a>
                <a href="{:$router->build('/psrphp/section/section/delete', ['id'=>$vo['id']])}" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
                {if $vo['type'] == 'data'}
                <a href="{:$router->build('/psrphp/section/item/index', ['section_id'=>$vo['id']])}">数据管理</a>
                {/if}
                <a href="#" onclick="event.target.parentNode.parentNode.nextElementSibling.style.display=event.target.parentNode.parentNode.nextElementSibling.style.display=='table-row'?'none':'table-row'">预览</a>
            </td>
        </tr>
        <tr style="display: none;">
            <td colspan="4">
                <?php
                try {
                    echo App\Psrphp\Section\Model\Section::render($vo['name']);
                } catch (\Throwable $th) {
                    echo '<span style="color:red;">错误：' . $th->getMessage() . '</span><pre>' . $th->getTraceAsString() . '</pre>';
                }
                ?>
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>
{include common/footer@psrphp/admin}