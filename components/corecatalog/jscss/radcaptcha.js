var RADCaptcha =
{
    renew: function(imageId, page)
    {
        if(page=='undefined') {
            page = '';
        } else {
            page = 'page/'+page+'/';
        }
        $('#'+imageId).attr('src', URL_SHOWCAPTCHA+page+ Math.random());
        return false;
    }
};
