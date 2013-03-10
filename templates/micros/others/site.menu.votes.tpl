{if isset($is_center)}
    {include file="$_CURRENT_LOAD_PATH/site.votes.tpl"}
{elseif !empty($items)}
    {if empty($showVote) or empty($vote)}
        {url file="jscss/components/radvotes.js" type="js"}
        <script type="text/javascript">
            var VOTES_POST_URL = '{url href="alias=votes.XML"}';
                {literal}
                $(document).ready(function () {
                    rad_votes.init();
                });
                {/literal}
        </script>
            <div class="interview rad_votes">
                <div class="pic1"></div>
                <h4>{$params->title}</h4>
    {/if}
                {foreach from=$items item="item"}
                    {if empty($showVote) or empty($vote)}<div id="rad_votes_vt_id_{$item->vt_id}">{/if}
                        <p>{$item->vt_question|@htmlspecialchars}</p>
                        {if empty($item->vt_answers)}

                        {else}
                            {if isset($showVote)}
                                {foreach from=$item->vt_answers item=ans}
                                    <div class="rad_votes_percent_title votesmall">
                                        <span class="rad_votes_percent_title " >{$ans->vtq_name}:</span>
										<div class="field_response leftmnu"></div>
                                        <div class="rad_votes_percent" style="width:{$ans->percent_vote}%"></div><p >{$ans->percent_vote}%</p>
                                    </div>
                                {/foreach}
                            {else}
                                {foreach from=$item->vt_answers item=ans}
                                    <a href="#{$ans->vtq_name}" class="vtq_answer" vtq_id="{$ans->vtq_id}" vtq_vtid="{$ans->vtq_vtid}"><span>{$ans->vtq_name}</span></a>
                                {/foreach}
                            {/if}
                    {/if}
                    {if empty($showVote) or empty($vote)}</div>{/if}
                {/foreach}
        {if empty($showVote) or empty($vote)}
            {*
                <a href="{url href='alias=votes.html'}" class="txdecnone">
				    <input type="button"  name="arhive"  class="btnblue ltblue tx wt arhive" value="{lang code="questionsarchive.others.text" ucf=true}" />
				</a>
			*}
            </div>
        {/if}
{/if}