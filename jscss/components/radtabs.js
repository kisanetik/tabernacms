RADTabs = {
    change: function(id,panel,wrapper)
    {
    	panel = panel || 'TabsPanel';
    	wrapper = wrapper || 'TabsWrapper';
		$('#'+panel+' .vkladka').removeClass('activ')
        $('#'+id).addClass('activ');
		$('#'+wrapper+' div[id$=tabcenter]').css('display', 'none');
		if($('#'+id+'_tabcenter')){
           $('#'+id+'_tabcenter').css('display','block');
       }
    }
}
