{strip}
{if count($items)}
    <table cellpadding="0" cellspacing="0" border="0" class="tb_list" id="tb_list" width="100%">
        <tr class="header">
            <td style="width:90px;">{lang code="nickname.session.text" ucf=true}</td>
            <td style="width:70px;">{lang code="date.system.title" ucf=true}</td>
            <td>{lang code="typecomment.resource.title" ucf=true}</td>
            <td>{lang code="textcomment.resource.text" ucf=true}</td>
            <td>{lang code="-action" ucf=true}</td>
        </tr>
    {foreach from=$items item="item"}
        <tr>
            <td>{$item->rcm_nickname}</td>
            <td>{$item->rcm_datetime|date_format:"%d-%m-%Y"}</td>
            <td>
                {if isset($item->news->nw_id)}
                    {lang code="news.catalog.text"}:<br />
                    <a href="{url href="alias=news&nid=`$item->news->nw_id`"}" target="_blank">
                        {$item->news->nw_title}
                    </a>
                {elseif isset($item->articles->art_id)}
                    {lang code="article.articles.text"}:<br />
                    <a href="{url href="alias=articles&a=`$item->articles->art_id`"}" target="_blank">
                        {$item->articles->art_title}
                    </a>
                {elseif isset($item->product->cat_id)}
                    {lang code="product.articles.text"}:<br />
                    <a href="{url href="alias=product&p=`$item->product->cat_id`"}" target="_blank">
                        {$item->product->cat_name}
                    </a>
                {elseif isset($item->order->order_id)}
                    {lang code="order.order.title"}:<br />
                    <a href="{url href="alias=CATManageOrders&action=edit&oid=`$item->order->order_id`"}" target="_blank">
                        {$item->order->order_num}
                    </a>
                {else}
                    {*debug*}
                {/if}
            </td>
            <td>{$item->rcm_text}</td>
            <td>
                <a href="javascript:RADComments.change({$item->rcm_id});">
                    <img src="{const SITE_URL}img/backend/billiard_marker.png" alt="{lang code="-edit" ucf=true}" border="0" />
                </a>
                <a href="javascript:RADComments.delItem({$item->rcm_id})">
                    <img src="{const SITE_URL}img/backend/icons/cross.png" alt="{lang code="-delete" ucf=true}" border="0" />
                </a>
            </td>
        </tr>
    {/foreach}
    <tr>
        <td colspan="5">
            <div class="paginator_items">
                {foreach from=$paginator->getPages() item=page}
                    {if $page->isCurrentPage}
                        <b>
                    {else}
                        <a href="{$page->href()|replace:'XML':''}">
                    {/if}
                    {$page->text()}
                    {if $page->isCurrentPage}
                        </b>
                    {else}
                        </a>
                    {/if}&nbsp;
                {/foreach}
            </div>
        </td>
    </tr>
    </table>
{else}
    <div align="center">{lang code="norecords.resource.text" ucf=true}</div>
{/if}
{/strip}