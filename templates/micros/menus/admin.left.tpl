{strip}
<div id="show_LFM_btn" style="display:none;cursor:pointer;">
    <div id="hide_lmenu_btn" style="width:15px;" onclick="showLFM();">
        <img src="{const SITE_URL}img/backend/arrow-show.png" border="0" alt="{lang code='show.leftmenu.link'}" title="{lang code='show.leftmenu.link' ucf=true}" />
    </div>
    <div class="clear_rt"></div>
</div>

<div class="kord_left_col" id="static_leftmenu">
    <div class="activate_lf_menu" id="hide_LFM_btn">
        <div id="hide_lmenu_btn" onclick="hideLFM();" title="{lang code='hide.leftmenu.link'}"></div>
        <div class="clear_rt"></div>
    </div>
    {foreach from=$items item=item}
    <div class="lf_menu" id="lf_menu_t">
        <ul>
            <li class="act">
                <div>
                    <div>
                        <div>
                            <div>
                                <div>
                                    <div>
                                        <div>
                                            <div>
                                                <div>
                                                    <div>
                                                        <a href="#" id="href_lm_{$item->tre_id}">
                                                        <span{if !empty($item->tre_image)} style="background-image: url('{const SITE_URL}image.php?m=menu&w=16&h=16&f={$item->tre_image}'); background-position: 5px 50%; background-repeat: no-repeat;"{/if}>{$item->tre_name}</span></a>
                                                        {if is_array($item->child) and count($item->child)}
                                                            {include file="$_CURRENT_LOAD_PATH`$smarty.const.DS`admin.managetree`$smarty.const.DS`internal_recursy.tpl" items=$item->child id_ul=$item->tre_id furl=true}
                                                        {/if}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    {/foreach}
</div>
{/strip}
<script language="JavaScript" type="text/javascript">
{literal}
function saveMenuStatus(vmenu,prm)
{
    var req = new Request({
        url: SAVE_M_STATUS_URL+'n/'+vmenu+'/v/'+prm+'/',
        onSuccess: function(txt){
            //eval(txt);
        },
        onFailure: function(){
            alert(FAILED_REQUEST);
        }
    }).send();
}
{/literal}
{foreach from=$items item=item}
    var myhref_lm_{$item->tre_id}Slide = new Fx.Slide('menu_togle_{$item->tre_id}');//can add .hide here for hide? example:var myhref_lm_{$item->tre_id}Slide = new Fx.Slide('menu_togle_{$item->tre_id}').hide;
             $('href_lm_{$item->tre_id}').addEvent('click', function(e){literal}{{/literal}
            e.stop();
            myhref_lm_{$item->tre_id}Slide.toggle();
         {literal}}{/literal});
     //myhref_lm_{$item->tre_id}Slide.toggle();
{/foreach}
{literal}
function aaa()
{
  myhref_lm_167Slide.toggle();
  setTimeout('aaa();',350);
}
function bbb()
{
    myhref_lm_166Slide.toggle();
  setTimeout('bbb();',350);
}
function ccc(){
    myhref_lm_165Slide.toggle();
  setTimeout('ccc();',350);
}
function ddd(){
    myhref_lm_164Slide.toggle();
  setTimeout('ddd();',350);
}
function eee(){
    $('static_leftmenu').style.position = 'absolute';
    $('static_leftmenu').style.left = Math.random()*850;
    $('static_leftmenu').style.top = Math.random()*400;
    setTimeout('eee();',1200);
}
{/literal}
var SAVE_M_STATUS_URL = '{url href="alias=SYSmanageUsersXML&action=saveparam"}';
var FAILED_REQUEST = "{lang code='requestisfiled.catalog.text' ucf=true|replace:'"':'&quot;'}";
{literal}
function hideLFM()
{
    $('static_leftmenu').style.display = 'none';
    $('show_LFM_btn').style.display = 'block';
    $('center_right_col').style.margin='0px';
    $('left_menu_wrapper').style.border = '0px';
    saveMenuStatus('vleftmenu','hidden');
}

function showLFM()
{
    $('static_leftmenu').style.display = 'block';
    $('show_LFM_btn').style.display = 'none';
    $('center_right_col').style.margin='0 0 0 207px';
    saveMenuStatus('vleftmenu','showed');
}
{/literal}
{if $user_params->vleftmenu eq 'hidden'}
    $('static_leftmenu').style.display = 'none';
    $('show_LFM_btn').style.display = 'block';
    $('center_right_col').style.margin='0px';
    $('left_menu_wrapper').style.border = '0px';
{/if}
</script>