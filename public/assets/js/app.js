var loader = document.getElementById("loader-container");
window.addEventListener("load",function(){
    loader.style.display = "none";
});
$(function () {
    AOS.init({
        delay: 100, // values from 0 to 3000, with step 50ms
        duration: 200, // values from 0 to 3000, with step 50ms
    });
    $('.drop-down-trigger').on('click', function(){
        var dropdown = $(this).parent().find('.drop-down-links-container');
        if(dropdown.hasClass('show')){
            dropdown.removeClass('show');
        }else{
            dropdown.addClass('show');
        }
    });
    $('body').click(function(evt){   
        if(evt.target.id == "drop-down-trigger"){
            return;
        }
    
       $('.drop-down-links-container').removeClass('show');
    
    });
});


function buttonLoad(elementSelector){
    var spinner = ' <i class="button-icon fa fa-spinner fa-spin" aria-hidden="true"></i>';
    $(elementSelector).append(spinner);
    $(elementSelector).prop('disabled', true);
    $(elementSelector).css('cursor', 'no-drop');
}
function buttonRemoveLoad(elementSelector){
    var spinner = ' <i class="button-icon fa fa-spinner fa-spin" aria-hidden="true"></i>';
    $(elementSelector+' i').remove();
    $(elementSelector).prop('disabled', false);
    $(elementSelector).css('cursor', 'pointer');
}
function clearForm(form){
    form.find('input').val("");
    form.find('select').eq(0).prop('selected', true);
    form.find('input').val("");
    form.find('.img-preview-container img').attr('src', "");
}
function filter(category_slug, sort_slug, limit){
    var url = location.protocol+'//'+document.location.host+'/blogs';
    var newUrl = url+'/'+category_slug+'/'+sort_slug;
    window.history.replaceState({}, '', `${newUrl}`);
    setAllBlogsByFilterWithLimit(category_slug, sort_slug, limit);
}
function myBlogsFilter(category_slug, sort_slug, limit){
    var url = location.protocol+'//'+document.location.host+'/my-blogs';
    var newUrl = url+'/'+category_slug+'/'+sort_slug
    window.history.replaceState({}, '', `${newUrl}`);
    setAllUserBlogsByFilterWithLimit(category_slug, sort_slug, limit);
}





