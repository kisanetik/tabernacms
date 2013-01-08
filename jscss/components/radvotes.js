rad_votes = {
    'vt_id': null,
    'isCenter':false,
    'init': function(isCenter) {
    	this.isCenter = isCenter || this.isCenter;
        if($('.rad_votes').length && !this.isCenter) {
            $("<style type='text/css'> div.rad_votes_percent_title{margin-left:5%;width:90%;min-height:20px;font-size:13px;font-family:Arial,Verdana,sans-serif;text-align:center;margin-top:10px;} span.rad_votes_percent_title{width:100%;display:block;} .rad_votes_percent{background:#4C8EC5;}</style>").appendTo("head");
        }
        if($('.rad_votes a').length) {
            $('.rad_votes a').click(function() {
                rad_votes.vt_id = $(this).attr('vtq_vtid');
                $('#rad_votes_vt_id_'+rad_votes.vt_id).load(VOTES_POST_URL, {'vtq_id':$(this).attr('vtq_id'), 'vote':rad_votes.vt_id, 'iscenter':rad_votes.isCenter});
                return false;
            });
        }
    }
}