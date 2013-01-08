var ADD_COMMENT_URL = '{url href="alias=commentsXML&action=a"}';
var FAILED_REQUEST = '{lang code=requestisfiled.catalog.text}';
{literal}
rad_comments = {
    item: 0,
    typ: 'n',
    'loadItems': function()
    {
    },
    'init_short': function(item,typ)
    {
        rad_comments.item = item;
        rad_comments.typ = typ;
        $('b_addComment').addEvent('click', function(){
            $('comments_loader').style.display = 'block';
            var data = {'nickname':$('nickname').get('value'), 'txt':$('text_comments').get('value'), 'i':rad_comments.item, 't':rad_comments.typ, 'capcha_fld':$('capcha_fld').get('value')};
            var req = new Request({
                url: ADD_COMMENT_URL,
                data: data,
                method: 'post',
                onSuccess: function(res){
                    $('comments_items').set('html', res);
                    $('capcha_img').src=SITE_URL+'registration.htmlXML/a/cap/'+ Math.random();
                    $('comments_loader').style.display = 'none';
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                    $('comments_loader').style.display = 'none';
                }
            }).send();
        });
    },
    'showLoad': function(show)
    {
        if(show)
            $('comments_loader').style.display = '';
        else
            $('comments_loader').style.display = 'none';
    }
}
{/literal}