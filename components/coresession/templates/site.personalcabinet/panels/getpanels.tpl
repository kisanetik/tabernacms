{strip}
<ul class="top_submenu">
    <li>
        <a id="profile" href="{url href='action=profile'}">{lang code="profile.session.title"}</a>
    </li>
    <li>
        <a id="orders" href="{url href='action=orders'}">{lang code="orders.session.title"}</a>
    </li>
    {if $referals_on}
    <li>
        <a id="referals" href="{url href='action=referals'}">{lang code="referals.session.title"}</a>
    </li>
    {/if}
    {*
    <li>
        <a id="partner" class="brd_r" href="{url href='action=partner'}">{lang code="partner.session.title"}</a>
    </li>
    *}
</ul>
{/strip}