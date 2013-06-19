var MenuEffect = {
    init: function(effect){

         //showing selected submenu
        switch(effect) {
            case 2: // 2 - accordion
                this.accordion();
                break;
            case 3: // 3 - fade toggle
                this.fadeToggle();
                break;
        }
    },
    accordion : function()
    {
        $('.lpart .menucat ul').hide(); //hiding all submenus
        $('.lpart .selected').closest('.menucat').find('ul').slideDown({duration: 750, easing: 'linear'});
        $('.lpart .menucat h3.arrow').click(function(event){
            $(this).closest('.lpart').find('.menucat ul').stop(true).slideUp('fast');
            $(this).closest('.menucat').find('ul').stop(true).slideDown({duration: 'fast', easing: 'linear'});
            //Comment next line to reload whole page on category click
            event.preventDefault();
        });
    },
    fadeToggle : function()
    {
        $('.lpart .menucat ul').addClass('mainmenusubmenus').hide(); //hiding all submenus and adding pos=absolute

        $('.lpart .menucat h3.arrow').hover(function(){
            $('.lpart .menucat ul').stop(true).hide(); //hiding all submenus
            $(this).closest('.menucat').find('ul').stop(true).fadeIn(); // and showing current submenu on main menu hover
            $(this).closest('.menucat').addClass('hovering'); //hovering - utility class means that this menu or submenu is hovering
        },function(){
            var $this = $(this);
            $(this).closest('.menucat').removeClass('hovering');
            setTimeout(function(){
                $this.closest('.menucat').not('.hovering').find('ul').stop(true).fadeOut();
            }, 800);
        });
        $('.lpart .menucat ul').hover(function(){
            $(this).closest('.menucat').addClass('hovering');
        },function(){
            var $this = $(this);
            $this.closest('.menucat').removeClass('hovering');
            setTimeout(function(){
                $this.closest('.menucat').not('.hovering').find('ul').stop(true).fadeOut();
            }, 800);
        })
    }
}