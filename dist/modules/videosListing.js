/*!
 * Videouri
 * Video search engine
 * http://videouri.com
 * @author Alexandru Budurovici <contact@videouri.com>
 * @version 0.0.1
 * Copyright &copy; Videouri.com 2015. Attribution-NonCommercial-NoDerivs licensed.
 */
"use strict";var $isotopeContainer,page,curPage,nextPage;$(document).ready(function(){$("img.lazy-image").lazyload(),$isotopeContainer=$("#video-list").isotope({itemSelector:".col-md-3",layoutMode:"masonry"}),$(".video-source").on("click",function(){var a=$(this).data("filter");$(".choosen-source").html("Source: "+$(this).text()),$isotopeContainer.isotope({filter:a})}),$(".pagination .previous").click(function(){return curPage=$.query.get("page"),console.log(curPage+"previous"),0===curPage.length?!1:(nextPage=curPage-1,page=$.query.set("page",nextPage).toString(),void window.location.replace(page))}),$(".pagination .next").click(function(){curPage=$.query.get("page"),console.log(curPage+"next"),nextPage=0===curPage.length?curPage+2:curPage+1,page=$.query.set("page",nextPage).toString(),window.location.replace(page)})});