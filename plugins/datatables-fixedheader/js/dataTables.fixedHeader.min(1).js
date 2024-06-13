/*!
 FixedHeader 3.1.9
 ©2009-2021 SpryMedia Ltd - datatables.net/license
*/
(function(d){"function"===typeof define&&define.amd?define(["jquery","datatables.net"],function(g){return d(g,window,document)}):"object"===typeof exports?module.exports=function(g,j){g||(g=window);if(!j||!j.fn.dataTable)j=require("datatables.net")(g,j).$;return d(j,g,g.document)}:d(jQuery,window,document)})(function(d,g,j,k){var i=d.fn.dataTable,l=0,h=function(a,b){if(!(this instanceof h))throw"FixedHeader must be initialised with the 'new' keyword.";!0===b&&(b={});a=new i.Api(a);this.c=d.extend(!0,
{},h.defaults,b);this.s={dt:a,position:{theadTop:0,tbodyTop:0,tfootTop:0,tfootBottom:0,width:0,left:0,tfootHeight:0,theadHeight:0,windowHeight:d(g).height(),visible:!0},headerMode:null,footerMode:null,autoWidth:a.settings()[0].oFeatures.bAutoWidth,namespace:".dtfc"+l++,scrollLeft:{header:-1,footer:-1},enable:!0};this.dom={floatingHeader:null,thead:d(a.table().header()),tbody:d(a.table().body()),tfoot:d(a.table().footer()),header:{host:null,floating:null,placeholder:null},footer:{host:null,floating:null,
placeholder:null}};this.dom.header.host=this.dom.thead.parent();this.dom.footer.host=this.dom.tfoot.parent();var e=a.settings()[0];if(e._fixedHeader)throw"FixedHeader already initialised on table "+e.nTable.id;e._fixedHeader=this;this._constructor()};d.extend(h.prototype,{destroy:function(){this.s.dt.off(".dtfc");d(g).off(this.s.namespace);this.c.header&&this._modeChange("in-place","header",!0);this.c.footer&&this.dom.tfoot.length&&this._modeChange("in-place","footer",!0)},enable:function(a,b){this.s.enable=
a;if(b||b===k)this._positions(),this._scroll(!0)},enabled:function(){return this.s.enable},headerOffset:function(a){a!==k&&(this.c.headerOffset=a,this.update());return this.c.headerOffset},footerOffset:function(a){a!==k&&(this.c.footerOffset=a,this.update());return this.c.footerOffset},update:function(){var a=this.s.dt.table().node();d(a).is(":visible")?this.enable(!0,!1):this.enable(!1,!1);this._positions();this._scroll(!0)},_constructor:function(){var a=this,b=this.s.dt;d(g).on("scroll"+this.s.namespace,
function(){a._scroll()}).on("resize"+this.s.namespace,i.util.throttle(function(){a.s.position.windowHeight=d(g).height();a.update()},50));var e=d(".fh-fixedHeader");!this.c.headerOffset&&e.length&&(this.c.headerOffset=e.outerHeight());e=d(".fh-fixedFooter");!this.c.footerOffset&&e.length&&(this.c.footerOffset=e.outerHeight());b.on("column-reorder.dt.dtfc column-visibility.dt.dtfc draw.dt.dtfc column-sizing.dt.dtfc responsive-display.dt.dtfc",function(){a.update()});b.on("destroy.dtfc",function(){a.destroy()});
this._positions();this._scroll()},_clone:function(a,b){var e=this.s.dt,c=this.dom[a],f="header"===a?this.dom.thead:this.dom.tfoot;!b&&c.floating?c.floating.removeClass("fixedHeader-floating fixedHeader-locked"):(c.floating&&(c.placeholder.remove(),this._unsize(a),c.floating.children().detach(),c.floating.remove()),c.floating=d(e.table().node().cloneNode(!1)).css("table-layout","fixed").attr("aria-hidden","true").removeAttr("id").append(f).appendTo("body"),c.placeholder=f.clone(!1),c.placeholder.find("*[id]").removeAttr("id"),
c.host.prepend(c.placeholder),this._matchWidths(c.placeholder,c.floating))},_matchWidths:function(a,b){var e=function(b){return d(b,a).map(function(){return 1*d(this).css("width").replace(/[^\d\.]/g,"")}).toArray()},c=function(a,c){d(a,b).each(function(a){d(this).css({width:c[a],minWidth:c[a]})})},f=e("th"),e=e("td");c("th",f);c("td",e)},_unsize:function(a){var b=this.dom[a].floating;b&&("footer"===a||"header"===a&&!this.s.autoWidth)?d("th, td",b).css({width:"",minWidth:""}):b&&"header"===a&&d("th, td",
b).css("min-width","")},_horizontal:function(a,b){var e=this.dom[a],c=this.s.position,d=this.s.scrollLeft;e.floating&&d[a]!==b&&(e.floating.css("left",c.left-b),d[a]=b)},_modeChange:function(a,b,e){var c=this.dom[b],f=this.s.position,g=function(a){c.floating.attr("style",function(b,c){return(c||"")+"width: "+a+"px !important;"})},i=this.dom["footer"===b?"tfoot":"thead"],h=d.contains(i[0],j.activeElement)?j.activeElement:null;h&&h.blur();if("in-place"===a){if(c.placeholder&&(c.placeholder.remove(),
c.placeholder=null),this._unsize(b),"header"===b?c.host.prepend(i):c.host.append(i),c.floating)c.floating.remove(),c.floating=null}else"in"===a?(this._clone(b,e),c.floating.addClass("fixedHeader-floating").css("header"===b?"top":"bottom",this.c[b+"Offset"]).css("left",f.left+"px"),g(f.width),"footer"===b&&c.floating.css("top","")):"below"===a?(this._clone(b,e),c.floating.addClass("fixedHeader-locked").css("top",f.tfootTop-f.theadHeight).css("left",f.left+"px"),g(f.width)):"above"===a&&(this._clone(b,
e),c.floating.addClass("fixedHeader-locked").css("top",f.tbodyTop).css("left",f.left+"px"),g(f.width));h&&h!==j.activeElement&&setTimeout(function(){h.focus()},10);this.s.scrollLeft.header=-1;this.s.scrollLeft.footer=-1;this.s[b+"Mode"]=a},_positions:function(){var a=this.s.dt.table(),b=this.s.position,e=this.dom,a=d(a.node()),c=a.children("thead"),f=a.children("tfoot"),e=e.tbody;b.visible=a.is(":visible");b.width=a.outerWidth();b.left=a.offset().left;b.theadTop=c.offset().top;b.tbodyTop=e.offset().top;
b.tbodyHeight=e.outerHeight();b.theadHeight=b.tbodyTop-b.theadTop;f.length?(b.tfootTop=f.offset().top,b.tfootBottom=b.tfootTop+f.outerHeight(),b.tfootHeight=b.tfootBottom-b.tfootTop):(b.tfootTop=b.tbodyTop+e.outerHeight(),b.tfootBottom=b.tfootTop,b.tfootHeight=b.tfootTop)},_scroll:function(a){var b=d(j).scrollTop(),e=d(j).scrollLeft(),c=this.s.position,f;this.c.header&&(f=this.s.enable?!c.visible||b<=c.theadTop-this.c.headerOffset?"in-place":b<=c.tfootTop-c.theadHeight-this.c.headerOffset?"in":"below":
"in-place",(a||f!==this.s.headerMode)&&this._modeChange(f,"header",a),this._horizontal("header",e));this.c.footer&&this.dom.tfoot.length&&(b=this.s.enable?!c.visible||b+c.windowHeight>=c.tfootBottom+this.c.footerOffset?"in-place":c.windowHeight+b>c.tbodyTop+c.tfootHeight+this.c.footerOffset?"in":"above":"in-place",(a||b!==this.s.footerMode)&&this._modeChange(b,"footer",a),this._horizontal("footer",e))}});h.version="3.1.9";h.defaults={header:!0,footer:!1,headerOffset:0,footerOffset:0};d.fn.dataTable.FixedHeader=
h;d.fn.DataTable.FixedHeader=h;d(j).on("init.dt.dtfh",function(a,b){if("dt"===a.namespace){var e=b.oInit.fixedHeader,c=i.defaults.fixedHeader;if((e||c)&&!b._fixedHeader)c=d.extend({},c,e),!1!==e&&new h(b,c)}});i.Api.register("fixedHeader()",function(){});i.Api.register("fixedHeader.adjust()",function(){return this.iterator("table",function(a){(a=a._fixedHeader)&&a.update()})});i.Api.register("fixedHeader.enable()",function(a){return this.iterator("table",function(b){b=b._fixedHeader;a=a!==k?a:!0;
b&&a!==b.enabled()&&b.enable(a)})});i.Api.register("fixedHeader.enabled()",function(){if(this.context.length){var a=this.context[0]._fixedHeader;if(a)return a.enabled()}return!1});i.Api.register("fixedHeader.disable()",function(){return this.iterator("table",function(a){(a=a._fixedHeader)&&a.enabled()&&a.enable(!1)})});d.each(["header","footer"],function(a,b){i.Api.register("fixedHeader."+b+"Offset()",function(a){var c=this.context;return a===k?c.length&&c[0]._fixedHeader?c[0]._fixedHeader[b+"Offset"]():
k:this.iterator("table",function(c){if(c=c._fixedHeader)c[b+"Offset"](a)})})});return h});