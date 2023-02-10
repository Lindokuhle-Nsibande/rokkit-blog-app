function notification(status,msg){
    var notificationHtml = '';
        if(status == 200){
            notificationHtml = '<div class="alert show alert-success alert-dismissible" role="alert" data-aos="fade-down" data-aos-easing="ease-in-out">'+msg+''+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                '<span aria-hidden="true">&times;</span>'+
                '</button>'+
            '</div>';
            $('.notification-container').append(notificationHtml);
        }
        else{
            notificationHtml = '<div class="alert show alert-danger alert-dismissible fade" role="alert" data-aos="fade-down" data-aos-easing="ease-in-out">'+msg+''+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                    '<span aria-hidden="true">&times;</span>'+
                '</button>'+
            '</div>';
            $('.notification-container').append(notificationHtml);
        }
        $(this).addClass('show');
        setTimeout(() => {
            $('.alert').removeClass('show');
        }, 5000);
}
function blogCard(id, tiltle_slug, imgPath, title, published, publisher, excerpt, category, category_slug){
    imgPath = location.protocol+'//'+document.location.host+'/'+imgPath;
    var cardElement = '<div class="col-lg-4 mb-4">'+
        '<div class="each-blog-container">'+
            '<div class="img-container" style="background-image:url(\''+imgPath+'\'); background-position: center; background-size: cover;" >'+
                
            '</div>'+
            '<div class="blog-info-container">'+
                '<h2>'+title+'</h2>'+
                '<div class="publish-info">'+
                    '<div class="each-info">'+
                        '<i class="fa fa-clock-o" aria-hidden="true"></i>'+
                        ' '+published+''+
                    '</div>'+
                    '|'+
                    '<div class="each-info">'+
                        '<i class="fa fa-user-o" aria-hidden="true"></i>'+
                        ' '+publisher+''+
                    '</div>'+
                '</div>'+
                '<div class="category-container">'+
                    '<a href="/blogs/'+category_slug+'/all">'+category+'</a>'+
                '</div>'+
                '<p>'+excerpt+'</p>'+
                '<a href="/blog/'+id+'/'+tiltle_slug+'" class="theme-btn">Read More</a>'+
            '</div>'+
        '</div>'+
    '</div>';

    return cardElement;
}