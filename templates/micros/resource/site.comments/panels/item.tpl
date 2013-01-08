
{strip}
{if !empty($item)}
    <div class="comment">
        <div class="head">
            <span class="nickname">{$item->rcm_nickname}</span>
            <span class="date">{$item->rcm_datetime|date:"datecalt"}</span>
        </div>
        <div class="text">
            {$item->rcm_text|@stripslashes|replace:"\n":"<br />"}
        </div>
    </div>
{else}
    <script type="text/javascript">location="{const SITE_URL}";</script>
{/if}
{/strip}