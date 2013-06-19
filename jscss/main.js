function addSel(sn,text,value)
{
    var exists = false;
    for(var i=0;i<sn.options.length;i++){
        if(sn.options[i].value==value){
            exists = true;
        }
    }
    if((!exists)&&(value)){
        var newElem = document.createElement("OPTION");
        newElem.text = text;
        newElem.value = value;
        sn.options.add(newElem);
   }
}//addSel

function selectSel(sn,value)
{
    for(var i=0;i<sn.options.length;i++){
        if(sn.options[i].value==value){
            sn.options[i].selected = true;
        }
    }
}

function delSelectedOption(sn)
{
	if(sn.selectedIndex)
	   sn.options[sn.selectedIndex]=null;
}
function selAllEl(elementN)
{
    var i=0;
    var ln=elementN.length;
    for(i=0;i<ln;i=i+1)
        elementN.options[i].selected=true;
}
		     
function clearSel(sn)
{
	for(var i=0;i<sn.options.length;)
	   sn.options[0] = null;
}
function popup(url,w,h,sb)
{
	atr = '';
	w = w || 800;
	h = h || 600;
	atr = atr + 'toolbar=no,';
	if (sb){
		atr = atr + 'scrollbars=no,';
	}else{
		atr = atr + 'scrollbars=yes,';
	}
	atr = atr + 'location=no,';
	atr = atr + 'statusbar=no,';
	atr = atr + 'menubar=no,';
	atr = atr + 'resizable=no,';
	atr = atr + 'width='+ w +',';
	atr = atr + 'height='+h;
	new_window=window.open(url,'_blank',atr);
	new_window.focus();
	return new_window;
}
function openCalendar(url)
{
	popup(url,100,150,false);
}
function myCustomExecCommandHandler(editor_id, elm, command, user_interface, value) {
		var linkElm, imageElm, inst;

		switch (command) {
			case "mceLink":
				inst = tinyMCE.getInstanceById(editor_id);
				linkElm = tinyMCE.getParentElement(inst.selection.getFocusElement(), "a");

				if (linkElm)
					alert("Link dialog has been overriden. Found link href: " + tinyMCE.getAttrib(linkElm, "href"));
				else
					alert("Link dialog has been overriden.");

				return true;

			case "mceImage":
				inst = tinyMCE.getInstanceById(editor_id);
				imageElm = tinyMCE.getParentElement(inst.selection.getFocusElement(), "img");

				if (imageElm)
					alert("Image dialog has been overriden. Found image src: " + tinyMCE.getAttrib(imageElm, "src"));
				else
					alert("Image dialog has been overriden.");

				return true;
		}

		return false; // Pass to next handler in chain
	}

	// Custom save callback, gets called when the contents is to be submitted
function customSave(id, content) {
	alert(id + "=" + content);
}
function formadd(frm,txt)
{
	var vl;
	vl=frm.value;
	frm.value=vl+txt;
	return vl+txt;
}//function formadd(frm)
function addSelect(sn,text,value)
{
	var newElem = document.createElement("OPTION");
	newElem.text = text;
	newElem.value = value;
	sn.options.add(newElem);
}

function confirmLink(theLink)
{
    if (confirm == '' || typeof(window.opera) != 'undefined') {
        return true;
    }

    var is_confirmed = confirm(theLink);
    if (is_confirmed) {
        theLink.href += '&is_js_confirmed=1';
    }

    return is_confirmed;
}

function insertText(elname,text)  
{
	var element;
	element = document.getElementById(elname);
    if (element && element.caretPos){
    	element.caretPos.text=text;  
    }
    else if (element && element.selectionStart+1 && element.selectionEnd+1){
    	element.value=element.value.substring(0,element.selectionStart)+text+element.value.substring(element.selectionEnd,element.value.length);  
    }else if (element){
    	element.value+=text;
    }
}
function setCookie (name, value, expires, path, domain, secure) {
      document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}
function getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}
function fileExt(fn)
{
    return fn.substr(fn.lastIndexOf('.'),fn.length);
}
function chr(code)
{
	String.fromCharCode(code);
}
function isset(  ) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: FremyCompany
    // +   improved by: Onno Marsman
    // *     example 1: isset( undefined, true);
    // *     returns 1: false
    // *     example 2: isset( 'Kevin van Zonneveld' );
    // *     returns 2: true
    var a=arguments; var l=a.length; var i=0;
    if (l==0) { 
        throw new Error('Empty isset'); 
    }
    while (i!=l) {
        if (typeof(a[i])=='undefined' || a[i]===null) { 
            return false; 
        } else { 
            i++; 
        }
    }
    return true;
}
function str_replace(search, replace, subject) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Gabriel Paderni
    // +   improved by: Philip Peterson
    // +   improved by: Simon Willison (http://simonwillison.net)
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   bugfixed by: Anton Ongson
    // +      input by: Onno Marsman
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    tweaked by: Onno Marsman
    // *     example 1: str_replace(' ', '.', 'Kevin van Zonneveld');
    // *     returns 1: 'Kevin.van.Zonneveld'
    // *     example 2: str_replace(['{name}', 'l'], ['hello', 'm'], '{name}, lars');
    // *     returns 2: 'hemmo, mars'
 
    var f = search, r = replace, s = subject;
    var ra = r instanceof Array, sa = s instanceof Array, f = [].concat(f), r = [].concat(r), i = (s = [].concat(s)).length;
 
    while (j = 0, i--) {
        if (s[i]) {
            while (s[i] = (s[i]+'').split(f[j]).join(ra ? r[j] || "" : r[0]), ++j in f){};
        }
    };
 
    return sa ? s : s[0];
}

function trim (str, charlist)
{
    var whitespace, l = 0, i = 0;
    str += '';
    
    if (!charlist) {
        // default list
        whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    } else {
        // preg_quote custom list
        charlist += '';
        whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\$1');
    }
    
    l = str.length;
    for (i = 0; i < l; i++) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(i);
            break;
        }
    }
    
    l = str.length;
    for (i = l - 1; i >= 0; i--) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(0, i + 1);
            break;
        }
    }
    
    return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
}

function print_r(arr, level) {
    var print_red_text = "";
    if(!level) level = 0;
    var level_padding = "";
    for(var j=0; j<level+1; j++) level_padding += "    ";
    if(typeof(arr) == 'object') {
        for(var item in arr) {
            var value = arr[item];
            if(typeof(value) == 'object') {
                print_red_text += level_padding + "'" + item + "' :\n";
                print_red_text += print_r(value,level+1);
		} 
            else 
                print_red_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
        }
    } 

    else  print_red_text = "===>"+arr+"<===("+typeof(arr)+")";
    return print_red_text;
}