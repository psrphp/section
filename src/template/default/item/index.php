{include common/header@psrphp/admin}
<h1>数据管理</h1>

<fieldset>
    <legend>管理</legend>
    <a href="{:$router->build('/psrphp/section/item/create', ['section_id'=>$section['id']])}">添加数据</a>
</fieldset>

<table style="margin-top: 20px;">
    <thead>
        <tr>
            <th>标题</th>
            <th>标题样式</th>
            <th>图片</th>
            <th>链接地址</th>
            <th>状态</th>
            <th>管理</th>
        </tr>
    </thead>
    <tbody>
        {foreach $items as $vo}
        <tr>
            <td>{$vo.title}</td>
            <td><code>{$vo.style}</code></td>
            <td>
                {if $vo['pic']}
                <img src="{$vo.pic}" width="50" alt="">
                {/if}
            </td>
            <td>{$vo.url}</td>
            <td>
                {if $vo['state'] == 1}
                <span>已发布</span>
                {else}
                <span>未发布</span>
                {/if}
            </td>
            <td>
                <a href="{:$router->build('/psrphp/section/item/update', ['id'=>$vo['id']])}">编辑</a>
                <a href="{:$router->build('/psrphp/section/item/delete', ['id'=>$vo['id']])}" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>
{include common/footer@psrphp/admin}