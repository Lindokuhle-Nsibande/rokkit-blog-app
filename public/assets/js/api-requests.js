function registerUser(token, form){
    var fd = new FormData(form);
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':token
        }
    });
    $.ajax({
        type: "POST",
        url: "/user/add",
        cache: false,
        contentType: false,
        processData: false,
        data: fd,
        dataType: "json",
        beforeSend: function(){
            buttonLoad('#registerUserForm button');
        },
        success: function (response) {
            buttonRemoveLoad('#registerUserForm button');
            $.each(response.response, function (key, value) { 
                notification(response.status,value);
            });
            if(response.status == 200){
                window.location.href = '/login'
            }
        }
    });
}
function userLogin(token, form){
    var fd = new FormData(form);
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':token
        }
    });
    $.ajax({
        type: "POST",
        url: "/user/login",
        cache: false,
        contentType: false,
        processData: false,
        data: fd,
        dataType: "json",
        beforeSend: function(){
            buttonLoad('#userLoginForm button');
        },
        success: function (response) {
            buttonRemoveLoad('#userLoginForm button');
            $.each(response.response, function (key, value) { 
                notification(response.status,value);
            });
            if(response.status == 200){
                window.location.href = '/'
            }
        }
    });
}
function addNewBlog(token, form, limit){
    var fd = new FormData(form);
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':token
        }
    });
    $.ajax({
        type: "POST",
        url: "/add/blog",
        cache: false,
        contentType: false,
        processData: false,
        data: fd,
        dataType: "json",
        beforeSend: function(){
            buttonLoad('#addNewBlogForm button');
        },
        success: function (response) {
            buttonRemoveLoad('#addNewBlogForm button');
            $('#addNewBlog').modal('hide');
            $.each(response.response, function (key, value) { 
                notification(response.status,value);
            });
            if(response.status == 200){
                checkActiveUserFilter(limit);
                var formElement = $('#addNewBlogForm');
                clearForm(formElement);
            }
        }
    });
}
function updateBlog(token, blog_id, form){
    var fd = new FormData(form);
    fd.append('blog_id', blog_id);
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':token
        }
    });
    $.ajax({
        type: "POST",
        url: "/update/blog",
        cache: false,
        contentType: false,
        processData: false,
        data: fd,
        dataType: "json",
        beforeSend: function(){
            buttonLoad('#editForm button');
        },
        success: function (response) {
            buttonRemoveLoad('#editForm button');
            $('#editBlog').modal('hide');
            $.each(response.response, function (key, value) { 
                notification(response.status,value);
            });
            if(response.status == 200){
                location.reload(true);
            }
        }
    });
}
function deleteBlog(token, blog_id){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':token
        }
    });
    $.ajax({
        type: "POST",
        url: "/delete/blog",
        // cache: false,
        // contentType: false,
        // processData: false,
        data: {
            'blog_id': blog_id
        },
        dataType: "json",
        beforeSend: function(){
            buttonLoad('#editForm button');
        },
        success: function (response) {
            buttonRemoveLoad('#editForm button');
            $('#editBlog').modal('hide');
            $.each(response.response, function (key, value) { 
                notification(response.status,value);
            });
            if(response.status == 200){
                swal("The blog deleted", {
                    icon: "success",
                }).then((ok)=>{
                    window.location.href = '/'
                });
            }
        }
    });
}
function getAllBlogsByFilter(category, sort, Callback){
    $.ajax({
        type: "GET",
        url: "/blogs/get/"+category+'/'+sort,
        dataType: "JSON",
        beforeSend: function(){
           
        },
        success: function (response) {
            Callback(response);
        }
    });
}
function getAllUserBlogsByFilter(category, sort){
    getAllBlogsByFilter(category, sort, function(response){
        $.each(response, function(key, val){
            blogList += blogCard(val.id, val.slug, val.thumbnail, val.title, val.published, val.user.name, val.excerpt, val.category.name, val.category.name_slug); 
        });

        $('.blog-list-container').html(blogList);
    });
}
function getAllBlogsByFilterWithLimit(category, sort, limit, Callback){
    $.ajax({
        type: "GET",
        url: "/blogs/get/"+category+'/'+sort+'/'+limit,
        dataType: "JSON",
        beforeSend: function(){
           
        },
        success: function (response) {
            Callback(response);
        }
    });
}
function setAllBlogsByFilterWithLimit(category, sort, limit){
    getAllBlogsByFilterWithLimit(category, sort, limit, function(response){
        var blogList = "";

        $.each(response, function(key, val){
            blogList += blogCard(val.id, val.slug, val.thumbnail, val.title, val.published, val.user.name, val.excerpt, val.category.name, val.category.name_slug); 
        });

        $('.blog-list-container').html(blogList);
    });
}
function getAllBlogs(Callback){
    $.ajax({
        type: "GET",
        url: "/blogs/get/all",
        dataType: "text",
        beforeSend: function(){
           
        },
        success: function (response) {
            console.log(response);
            Callback(response);
        }
    });
}

function getAllUserBlogsByFilter(category, sort, Callback){
    $.ajax({
        type: "GET",
        url: "/my-blogs/get/"+category+'/'+sort,
        dataType: "JSON",
        beforeSend: function(){
           
        },
        success: function (response) {
            Callback(response);
        }
    });
}
function getAllUserBlogsByFilterWithLimit(category, sort, limit, Callback){
    $.ajax({
        type: "GET",
        url: "/my-blogs/get/"+category+'/'+sort+'/'+limit,
        dataType: "JSON",
        beforeSend: function(){
           
        },
        success: function (response) {
            Callback(response);
        }
    });
}
function setAllUserBlogsByFilter(category, sort){
    getAllUserBlogsByFilter(category, sort, function(response){
        var blogList = "";
        $.each(response, function(key, val){
            blogList += blogCard(val.id, val.slug, val.thumbnail, val.title, val.published, val.user.name, val.excerpt, val.category.name, val.category.name_slug); 
        });
        $('.blog-list-container').html(blogList);
    });
}
function setAllUserBlogsByFilterWithLimit(category, sort, limit){
    getAllUserBlogsByFilterWithLimit(category, sort, limit, function(response){
        var blogList = "";
        $.each(response, function(key, val){
            blogList += blogCard(val.id, val.slug, val.thumbnail, val.title, val.published, val.user.name, val.excerpt, val.category.name, val.category.name_slug); 
        });
        $('.blog-list-container').html(blogList);
    });
}
function searchBlog(search, Callback){
    $.ajax({
        type: "GET",
        url: '/blogs/search/'+search,
        dataType: "JSON",
        beforeSend: function(){
           
        },
        success: function (response) {
            Callback(response);
        }
    });
}
function searchUserBlog(search, Callback){
    $.ajax({
        type: "GET",
        url: '/user/blogs/search/'+search,
        dataType: "JSON",
        beforeSend: function(){
           
        },
        success: function (response) {
            Callback(response);
        }
    });
}
function setSearchedBlogs(search, pageLimit = null){
    searchBlog(search, function(response){
        var blogList = "";
        var numberOfBlogs = 0;
        if(pageLimit == null){
            var pageLimit = 1;
        }
        $.each(response, function(key, val){
            numberOfBlogs++;
            blogList += blogCard(val.id, val.slug, val.thumbnail, val.title, val.published, val.user.name, val.excerpt, val.category.name, val.category.name_slug);
        });
        $('.blog-list-container').html(blogList);
    });
}
function setSearchUserBlog(search){
    searchUserBlog(search, function(response){
        var blogList = "";
        var numberOfBlogs = 0;
        $.each(response, function(key, val){
            numberOfBlogs++;
            blogList += blogCard(val.id, val.slug, val.thumbnail, val.title, val.published, val.user.name, val.excerpt, val.category.name, val.category.name_slug);
        });
        $('.blog-list-container').html(blogList);
    });
}
function checkActiveFilter(limit){
    var url = window.location.href;
    var category = "all";
    var sort = "all";
    if(url.includes('blogs')){
        var protocolHost = location.protocol+'//'+document.location.host+'/blogs/';
        var urlString = (window.location.href).replace(protocolHost, '');
        var urlArray = urlString.split("/");
        $.each(urlArray, function(key, val){
            if(key == 0){
                category = val;
            }
            if(key == 1){
                sort = val;
            }
        });
    }
    setAllBlogsByFilterWithLimit(category, sort, limit);
}
function checkActiveUserFilter(limit){
    var url = window.location.href;
    var category = "all";
    var sort = "all";
    if(url.includes('my-blogs')){
        var protocolHost = location.protocol+'//'+document.location.host+'/my-blogs/';
        var urlString = (window.location.href).replace(protocolHost, '');
        var urlArray = urlString.split("/");
        $.each(urlArray, function(key, val){
            if(key == 0){
                category = val;
            }
            if(key == 1){
                sort = val;
            }
        });
    }
    setAllUserBlogsByFilterWithLimit(category, sort, limit);
}
function getBlogLimitPerPage(token, Callback){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':token
        }
    });
    $.ajax({
        type: "POST",
        url: "/blogs/get/limit",
        dataType: "text",
        success: function (response) {
            Callback(response);
        }
    });
}
