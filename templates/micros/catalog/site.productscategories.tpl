{strip}
<div class='staticpage'>
{if !empty($category)}
    {if !empty($category->tre_fulldesc)}
  	<div class="catalog_category_description" id="category_description_short">
  	    {capture name="detail_text" assign="detail_text"}{lang code="detail.news.link" ucf=true}{/capture}
        {$category->tre_fulldesc|truncate:260:'... <p class="small_text text_right"><a href="#" onclick="$(\'#category_description_full\').show();$(\'#category_description_short\').hide();return false;">Подробнее</a></p>'}
    </div>
    <div class="catalog_category_description" id="category_description_full" style="display:none;">
        {$category->tre_fulldesc}
    </div>
  {/if}
{/if}
{if isset($categories) and count($categories)}
    {capture name=categories_with_images assign=categories_wi}
        {foreach from=$categories item=caty}
            {if $caty->tre_active}
                {if !empty($caty->tre_image)}
                    <div class="category_item_with_image">
                        <ul>
                            <li class="item_image">
                                <a href="{url href="cat=`$caty->tre_id`"}">
                                    <img src="{const SITE_URL}image.php?f={$caty->tre_image}&w=150&h=200&m=menu" alt="{$caty->tre_name|replace:'"':'&quot;'}">
                                </a>
                            </li>
                            <li class="item_link">
                                <a class="podmenu{if $caty->tre_id eq $category->tre_id} active{/if}" href="{url href="cat=`$caty->tre_id`"}">{$caty->tre_name}</a>
                            </li>
                        </ul>
                    </div>
                {/if}
            {/if}
        {/foreach}
    {/capture}

    {capture name=categories_with_images assign=categories_ni}
        {foreach from=$categories item=caty}
            {if $caty->tre_active}
                {if empty($caty->tre_image)}
                    <div class="category_item">
                        <a class="podmenu{if $caty->tre_id eq $category->tre_id} active{/if}" href="{url href="cat=`$caty->tre_id`"}">{$caty->tre_name}</a>
                    </div>
                {/if}
            {/if}
        {/foreach}
    {/capture}

    {if $categories_wi ne ''}
	<div class="catalog_categories_wi">
        {$categories_wi}
    </div>
    {/if}
    {if $categories_ni ne ''}
    <div class="catalog_categories" >
        <span class="categories_title">{lang code="anothercat.catalog.text" ucf=true}</span>
        <div class="line1"></div>
        {$categories_ni}
    </div>
    {/if}
{/if}
</div>
{/strip}