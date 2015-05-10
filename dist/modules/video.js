/*!
 * Videouri
 * Video search engine
 * http://videouri.com
 * @author Alexandru Budurovici <contact@videouri.com>
 * @version 0.0.1
 * Copyright &copy; Videouri.com 2015. Attribution-NonCommercial-NoDerivs licensed.
 */
videojs.options.flash.swf="/dist/misc/video-js.swf";var $isotopeContainer;$(document).ready(function(a){$isotopeContainer=a("#related-videos").isotope({itemSelector:".col-md-3",layoutMode:"masonry"});var b=encodeURIComponent(document.title),c=encodeURI(window.location.href),d="http://www.facebook.com/sharer.php?u="+c+"&t="+b,e="http://www.tuenti.com/?m=Share&func=index&url="+c+"&suggested-text=",f="https://twitter.com/intent/tweet?url="+c+"&text="+b+"&via=videouri";a("#facebook-share").attr("href",d),a("#tuenti-share").attr("href",e),a("#twitter-share").attr("href",f),a(".popup").click(function(b){var c=575,d=400,e=(a(window).width()-c)/2,f=(a(window).height()-d)/2,g=this.href,h=a(this).attr("id"),i="status=1,width="+c+",height="+d+",top="+f+",left="+e;return window.open(g,h,i),!1});var g=a("#videoPlayer").data("src"),h=a("#videoPlayer").data("url");videojs("videoPlayer",{techOrder:[g],src:h}).ready(function(){})});