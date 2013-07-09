/** 
    Bug fix: rewrites Mootools method for Internet Explorer 9 (and highest in future)
*/

Document.implement({

    newElement: function(tag, props){
        if (Browser.Engine.trident && props && this.getInternetExplorerVersion<9){
            ['name', 'type', 'checked'].each(function(attribute){
                if (!props[attribute]) return;
                tag += ' ' + attribute + '="' + props[attribute] + '"';
                if (attribute != 'checked') delete props[attribute];
            });
            tag = '<' + tag + '>';
        }
        return $.element(this.createElement(tag)).set(props);
    },

    newTextNode: function(text){
        return this.createTextNode(text);
    },

    getDocument: function(){
        return this;
    },

    getWindow: function(){
        return this.window;
    },

    getInternetExplorerVersion: function(){
        //Returns the version of Internet Explorer or a -1
        //(indicating the use of another browser).
        var rv = -1; // Return value assumes failure.
        if (navigator.appName == 'Microsoft Internet Explorer'){
            var ua = navigator.userAgent;
            var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
            if (re.exec(ua) != null)
                rv = parseFloat( RegExp.$1 );
        }
        return rv;
    }

});