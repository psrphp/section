{include common/header@psrphp/admin}
<h1>区块管理</h1>

<fieldset>
    <legend>管理</legend>
    <a href="{:$router->build('/psrphp/section/section/create')}">新增区块</a>
</fieldset>

<table style="margin-top: 20px;">
    <thead>
        <tr>
            <th>名称</th>
            <th>备注</th>
            <th>管理</th>
            <th>调用</th>
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
            <td>
                <a href="{:$router->build('/psrphp/section/section/update', ['id'=>$vo['id']])}">编辑</a>
                <a href="{:$router->build('/psrphp/section/section/delete', ['id'=>$vo['id']])}" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
                <a href="{:$router->build('/psrphp/section/item/index', ['section_id'=>$vo['id']])}">数据管理</a>
            </td>
            <td><code>{literal}{section{/literal} {$vo.name}{literal}}{/literal}</code></td>
        </tr>
        {/foreach}
    </tbody>
</table>
{include common/footer@psrphp/admin}