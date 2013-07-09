var ADD_COMMENT_URL = '{url href="comments_action=a"}';
var FAILED_REQUEST = '{lang code="requestisfiled.catalog.text" ucf=true|replace:'"':'&quot;'}';
var REFRESH_URL = '{url href=""}' + 'oid/';
var EMPTY_COMMENT_FIELD = '{lang code="emptycommentfield.catalog.text" ucf=true|replace:'"':'&quot;'}';
var TEXT_ADD_COMMENT = '{lang code="commenttext.catalog.text"}';
var HASH = '{$hash}';

{literal}
RADAdminOrderComments = {
    'addComment': function(oid)
    {
        if($('comment_text').get('value').length > 0 && $('comment_text').get('value') !== TEXT_ADD_COMMENT) {
            var data = {'txt':$('comment_text').get('value'), 't':'order', 'i':oid, 'hash':HASH};
            var req = new Request({
                url: ADD_COMMENT_URL,
                data: data,
                method: 'post',
                onSuccess: function(txt){
                    new Request.HTML({
                        url: REFRESH_URL + oid,
                        onSuccess: function(respTree, respElements, respHTML, respJS) {
                            $('order-comments').set('html', respHTML);
                        },
                        onFailure: function() {
                            alert(FAILED_REQUEST);
                        }
                    }).send();
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        } else {
            alert(EMPTY_COMMENT_FIELD);
        }
    }
}
{/literal}