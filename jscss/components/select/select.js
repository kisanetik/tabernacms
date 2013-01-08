$(function(){
	if($('div#select').length) {
		$('select#files').selectmenu({
			style:'popup', 
			icons: [
				{find: '.script', icon: 'ui-icon-script'},
				{find: '.image', icon: 'ui-icon-image'}
			]
		});	
		
		$('select#filesB').selectmenu({
			style:'popup', 
			icons: [
				{find: '.video'},
				{find: '.podcast'},
				{find: '.rss'}
			]
		});			
		
		$('select#peopleA').selectmenu({
			icons: [
				{find: '.avatar'}
			],
			bgImage: function() {
				return 'url(' + $(this).attr("title") + ')';
			}
		});

		$('select#peopleB').selectmenu({
			icons: [
				{find: '.css-avatar'}
			],
			bgImage: function() {
				return $(this).css("background-image");
			}
		});

		$('select#peopleC').selectmenu({
			icons: [
				{find: '.avatar-big'}
			],
			bgImage: function() {
				return 'url(' + $(this).attr("title") + ')';
			},
			menuWidth: "300px"
		});
	}
});
				
//a custom format option callback
var addressFormatting = function(text){
	var newText = text;
	//array of find replaces
	var findreps = [
		{find:/^([^\-]+) \- /g, rep: '<span class="ui-selectmenu-item-header">$1</span>'},
		{find:/([^\|><]+) \| /g, rep: '<span class="ui-selectmenu-item-content">$1</span>'},
		{find:/([^\|><\(\)]+) (\()/g, rep: '<span class="ui-selectmenu-item-content">$1</span>$2'},
		{find:/([^\|><\(\)]+)$/g, rep: '<span class="ui-selectmenu-item-content">$1</span>'},
		{find:/(\([^\|><]+\))$/g, rep: '<span class="ui-selectmenu-item-footer">$1</span>'}
	];
	
	for(var i in findreps){
		newText = newText.replace(findreps[i].find, findreps[i].rep);
	}
	return newText;
}