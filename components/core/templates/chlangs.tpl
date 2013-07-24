{if isset($action) and ($action eq 'getjs')}
{*URLS*}
var CHANGE_CONTENTLNG_URL = '{url href="alias=chlang&action=contentlng"}';

{*MESSAGES*}
var FAILED_REQUEST = "{lang code='requestisfiled.system.error' htmlchars=true}";
var CONT_CHANGE_CONTENTLANG = "{lang code='cantchangecontentlng.session.error' htmlchars=true}";

RADCHLangs = {literal}{{/literal}
    lng_id: {$contLngId},
    lng_code: '{$contentLngObj->lng_code}',
    {literal}
    handlers: new Array(),
    'changeContent': function(lng_id,lng_code)
    {
        var req = new Request({
            url:CHANGE_CONTENTLNG_URL+'i/'+lng_id+'/',
            onSuccess: function(txt){
                eval(txt);
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    'changeAdmin': function(lng_id,lng_code)
    {
    },
    'addContainer': function(handler)
    {
        return this.handlers.push(handler);
    },
    'changeContentResult': function(isok,lngid,lngcode)
    {
        if(isok){
            this.lng_id = lngid;
            this.lng_code = lngcode;
            $('cont_langs_table').getElements('a').each(function(el){el.style.display='block';});
            $('cont_langs_table').getElements('span').each(function(el){el.style.display='none';});
            $('lngcont_href_'+lngid).style.display = 'none';
            $('lngcont_'+lngid).style.display = 'block';
            if(this.handlers.length){
                for(var i=0; i < this.handlers.length; i++){
                    eval(this.handlers[i]+'('+lngid+',"'+lngcode+'")');
                }
            }
        }else{
            alert(CONT_CHANGE_CONTENTLANG);
        }
    }
}
{/literal}
{/if}