var xivdb_tooltips_config =
{
    // General
    'version'       : '1.6',
    'domain'        : 'xivdb.com',

    // Set options
    'zindex'        : '99999999',

    // Custom options
    'replaceName'   : true,
    'colorName'     : true,
    'showIcon'      : true,
    'debug'         : false,

    // Accept url domains
    hrefs:
    [
        'xivdb.com',
        'xivdatabase.com',
        'www.xivdb.com',
        'www.xivdatabase.com',
        'jp.xivdb.com',
        'en.xivdb.com',
        'de.xivdb.com',
        'fr.xivdb.com',
    ],

    // List of languages
    language:
    {
        list: ["JP", "EN", "DE", "FR"],
        value: 1,
    },

};

// Main tooltip function
function fPopLoadItem()
{
    "undefined" != typeof Prototype && jQuery.noConflict();
    jQuery("a").each(function (index, value) 
    {
        // Set vars
        var url  = jQuery(this).attr("href");
        var host = null;
        if (void 0 != url && url.indexOf('/') > -1)
        {  
            url = url.split('/');
            var host = url[2];
        }

        // If valid address
        var ValidAddress = xivdb_tooltips_config.hrefs.indexOf(host);

        // If host not undefined and valid address is in hrefs
        if (void 0 != host && ValidAddress != -1) 
        {
            var type, id, name;
            if (url[3]) { type = url[3].replace('?', ''); }
            if (url[4]) { id= url[4]; }
            if (url[5]) { name = url[5].replace('-', ' '); }

            // If any tooltip settings passed
            if (typeof xivdb_tooltips !== "undefined") 
            { 
                // If language set, get the value from the list using its index
                if (typeof xivdb_tooltips.language !== "undefined")
                {
                    xivdb_tooltips_config.language.value = xivdb_tooltips_config.language.list.indexOf(xivdb_tooltips.language);
                }

                // if debug mode
                if (typeof xivdb_tooltips.debug !== "undefined")
                {
                    xivdb_tooltips_config.debug = xivdb_tooltips.debug;
                }

                // if replace name
                if (typeof xivdb_tooltips.replaceName !== "undefined")
                {
                    xivdb_tooltips_config.replaceName = xivdb_tooltips.replaceName;
                }

                // if color name
                if (typeof xivdb_tooltips.colorName !== "undefined")
                {
                    xivdb_tooltips_config.colorName = xivdb_tooltips.colorName;
                }

                // if show icon
                if (typeof xivdb_tooltips.showIcon !== "undefined")
                {
                    xivdb_tooltips_config.showIcon = xivdb_tooltips.showIcon;
                }
            }

            var element = jQuery(this);
            void 0 == id || !jQuery.isNumeric(id) || (jQuery.ajax({
                url: "http://"+ xivdb_tooltips_config.domain +"/modules/fpop/fpop.php",
                data: 
                {
                    //callback: '',
                    lang: xivdb_tooltips_config.language.value,
                    version: xivdb_tooltips_config.version,
                    //location: window.location.hostname.toString(),

                    type: type,
                    id: id,
                },
                
                cache: true,
                type: 'GET',
                success: function (data) 
                {
                    //console.log(data);
                    data = JSON.parse(data);
                    //console.log(data);

                    if (void 0 != data)
                    {
                        // Remove any title attribute, messes up hover
                        element.attr("title", "");

                        // Set tooltip html
                        element.data("tooltip", data.html.replace('db.xivdev.com', 'xivtooltips.com'));

                        // If we are replacing the name of the element
                        if (xivdb_tooltips_config.replaceName && data.name != null && element.attr("data-replacename") != 0) 
                        { 
                            element.html(data.name.replace('db.xivdev.com', 'xivtooltips.com'));
                        }

                        // If we are coloring the name of the element
                        if (xivdb_tooltips_config.colorName && data.color != null  && element.attr("data-colorname") != 0) 
                        { 
                            element.css({ color: data.color });
                        }

                        // If we are coloring the name of the element
                        if (xivdb_tooltips_config.showIcon && data.icon != null  && element.attr("data-showicon") != 0) 
                        { 
                            element.html('<img src="'+ data.icon + '" style="margin:0 5px -5px 0;width:20px;height:20px;" />' + element.html());
                        }
                        
                        // Tooltip
                        element.simpletooltip({
                            fixed: !0,
                            position: "bottom"
                        });
                    }
                    else
                    {
                        if (xivdb_tooltips_config.debug)
                        {
                            console.log("Error[1] fetching tooltip data, please copy the below response to: http://xivpads.com/?Support");
                            console.log(data);
                            console.log("---");
                        }
                    }
                },

                error: function (e, t, n) 
                {
                    if (xivdb_tooltips_config.debug)
                    {
                        console.log("Error[2] fetching tooltip data, please copy the below response to: http://xivpads.com/?Support");
                        console.log(e.responseText);
                        console.log(t);
                        console.log(n);
                        console.log("---");
                    }
                }
            }));
        }
    });
}

// Other required functions
function fPopGetScript(e,t){var n=document.createElement("script");n.src=e;var r=document.getElementsByTagName("head")[0],i=!1;void 0==r&&(r=document.getElementsByTagName("body")[0]);n.onload=n.onreadystatechange=function(){i||this.readyState&&"loaded"!=this.readyState&&"complete"!=this.readyState||(i=!0,t(),n.onload=n.onreadystatechange=null,r.removeChild(n))};r.appendChild(n)};
function fPopLoadTips(){"undefined"!=typeof Prototype&&jQuery.noConflict();jQuery.fn.simpletooltip||function(e){e.fn.simpletooltip=function(){return this.each(function(){void 0!=e(this).data("tooltip")&&(e(this).hover(function(t){e("#simpleTooltip").remove();var n=e(this).data("tooltip"),r=t.pageX+5;t=t.pageY+5;e("body").append("<div id='simpleTooltip' style='position: absolute; z-index: "+ xivdb_tooltips_config.zindex +"; display: none;'>"+n+"</div>");n=e("#simpleTooltip").width();e("#simpleTooltip").width(n);e("#simpleTooltip").css("left",r).css("top",t).show()},function(){e("#simpleTooltip").remove()}),e(this).mousemove(function(t){var n=t.pageX+12,r=t.pageY+12,i=e("#simpleTooltip").outerWidth(!0),s=e("#simpleTooltip").outerHeight(!0);n+i>e(window).scrollLeft()+e(window).width()&&(n=t.pageX-i);e(window).height()+e(window).scrollTop()<r+s&&(r=t.pageY-s);e("#simpleTooltip").css("left",n).css("top",r).show()}))})}}(jQuery);fPopLoadItem()};
function fPopInit(){"undefined"==typeof jQuery?fPopGetScript("//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js",fPopLoadTips):fPopLoadTips()}

// Oncall event
initXIVDBTooltips=function(){var e=document.createElement("link");e.setAttribute("rel","stylesheet");e.setAttribute("href","http://"+xivdb_tooltips_config.domain+"/css/tooltip.css");e.setAttribute("type","text/css");document.getElementsByTagName("head")[0].appendChild(e);var e=setInterval(function(){"complete"===document.readyState&&(clearInterval(e),fPopInit())},10)}
document.addEventListener('DOMContentLoaded',function(){ initXIVDBTooltips(); })

// General functions
function xivtt_replaceAll(txt, replace, with_this) { if (txt && replace && with_this) { return txt.replace(new RegExp(replace, 'g'),with_this); } else { return txt; } };