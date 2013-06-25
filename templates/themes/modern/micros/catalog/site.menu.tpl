{strip} {* needs internationalization *}
<nav class="b-top-menu">
    <table>
        <tbody>
        <tr>
            <td class="b-top-first-td">
                <ul id="menu" class="b-main-menu">
                    {foreach from=$items item=item}
                        {if $item->tre_active}
                            <li class="">
                                <a href="{url href="alias=catalog&cat=`$item->tre_id`"}" class="drop fldm">
                                    {$item->tre_name}{if $item !== $items[count($items)-1]}<span class="separator"></span>{/if}
                                    <span class="drop_after">&nbsp;</span>
                                </a>
                                {if $item->child}
                                    <div class="dropdown-shadows">
                                        <table class="dropdown_5columns">
                                            <tbody>
                                            <tr>
                                                {foreach from=$item->child item='child'}
                                                    {if $child->tre_active}
                                                        <td class="onetwofree">
                                                            <div class="punkt">
                                                                <p class="menu-second-level">
                                                                    <a href="{url href="SITE_URL?alias=catalog&cat=`$child->tre_id`"}">{$child->tre_name}</a>
                                                                </p>
                                                                <ul>
                                                                    {foreach from=$item->child item='subchild'}
                                                                        {if $subchild->tre_active}
                                                                            <li>
                                                                                <a href="{url href="SITE_URL?alias=catalog&cat=`$subchild->tre_id`"}">{$subchild->tre_name}</a>
                                                                            </li>
                                                                        {/if}
                                                                    {/foreach}
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    {/if}
                                                {/foreach}
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="dropdown-shadow-top"></div>
                                        <div class="dropdown-shadow-bottom"></div>
                                    </div>
                                {/if}
                            </li>
                        {/if}
                    {/foreach}
                </ul>
            </td>
            <td>
                <div class="search_title">
                    {url file="jscss/des/modern/search_title.js" type="js"}
                    <div id="title-search" class="form-box">
                        <form id="title-search-form" action="#">
                            <input id="title-search-input" type="text" name="query" value='{lang code="searchproduct.catalog.text"}' size="40" maxlength="50" autocomplete="off" data-defaultvalue='{lang code="searchproduct.catalog.text"}' class="def-val">
                            <input name="s" type="image" src="/img/des/modern/title-search-input.png" alt="" id="search-submit-button">
                            <div id="category-block">
                                <span id="category">Везде</span> <i class="i i-open-category"></i>
                                <select name="section" id="category-select">
                                    <option value="">Везде</option>
                                    {foreach from=$items item=item}
                                        {if $item->tre_active}
                                            <option value="{$item->tre_id}">{$item->tre_name}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</nav>
{/strip}