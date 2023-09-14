{include common/header@psrphp/admin}
<h1>区块管理</h1>

<fieldset>
    <legend>管理</legend>
    <a href="{:$router->build('/psrphp/section/create')}">新增</a>
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
                <a href="{:$router->build('/psrphp/section/update', ['id'=>$vo['id']])}">编辑</a>
                <a href="{:$router->build('/psrphp/section/delete', ['id'=>$vo['id']])}" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
                <a href="#" onclick="event.target.parentNode.parentNode.nextElementSibling.style.display=event.target.parentNode.parentNode.nextElementSibling.style.display=='table-row'?'none':'table-row'">预览</a>
            </td>
        </tr>
        <tr style="display: none;">
            <td colspan="4">
                <?php
                echo App\Psrphp\Section\Model\Section::render($vo['name']);
                ?>
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>
{include common/footer@psrphp/admin}