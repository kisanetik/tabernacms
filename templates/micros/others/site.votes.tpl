{strip}
{if isset($items)}
    {foreach from=$items item=item}
        {if empty($showVote) or empty($vote)}
            {url file="jscss/components/radvotes.js" type="js"}
            <script type="text/javascript">
                var VOTES_POST_URL = '{url href="alias=votes.XML"}';
                    {literal}
                    $(document).ready(function(){
                        rad_votes.init();
                    });
                    {/literal}
            </script>
        {/if}

        {if empty($showVote) or empty($vote)}<div id="rad_votes_vt_id_{$item->vt_id}">{/if}
        <div class="votes_blok" id="votes_cblock_{$item->vt_id}">
		<div class="votes_question">
            <h2>{$item->vt_question}</h2>
		</div>
            {if count($item->vt_answers)}
            <div class="vote_pages_elements_area">
                {if isset($showVote)}
                    {foreach from=$item->vt_answers item=ans}
                    <div class="rad_votes_percent_title" style="text-align: bottom;">
                    	<span class="rad_votes_percent_title">{$ans->vtq_name}:</span>
						<div class="field_response"></div>
						
                    	<div class="rad_votes_percent" style="width:{if isset($ans->percent_vote)}{$ans->percent_vote}{else}0{/if}%"></div><p>{if isset($ans->percent_vote)}{$ans->percent_vote}{else}0{/if}%</p>
                    </div>
					
                    {/foreach}
                {else}
                    <div class="rad_votes">
                    {foreach from=$item->vt_answers item=ans}
                        <a href="#{$ans->vtq_name}" class="vtq_answer" vtq_id="{$ans->vtq_id}" vtq_vtid="{$ans->vtq_vtid}"><span>{$ans->vtq_name}</span></a><br />
                    {/foreach}
                    </div>
                {/if}
            </div>
            {/if}
        </div>
        {if empty($showVote) or empty($vote)}</div>{/if}
    
{/foreach}


{elseif isset($votes)}
    {if isset($categories) and count($categories)}
        <h1>{lang code='categoriesvotes.others.title' ucf=true}</h1>
        {foreach from=$categories item=cat}
            <a href="{url href="vcp=`$cat->tre_id`"}">{$cat->tre_name}</a><br />
        {/foreach}
    {/if}
    {if isset($votes)}
        <div class="submenu_area">
        <h1>{lang code='votes.others.title' ucf=true}</h1>
        {if count($votes)}
        <ul class="votes_list">
            {foreach from=$votes item=vote}
            <li><a href="{url href="v=`$vote->vt_id`&vcp=`$vote->vt_treid`"}">{$vote->vt_question}</a></li>
            {/foreach}
        </ul>
        {else}
            {lang code='norecords.others.text'}
        {/if}
        </div>
    {/if}
{/if}
{/strip}