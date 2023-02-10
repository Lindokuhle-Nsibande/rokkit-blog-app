<section class="navigation-bar-section">
    <div class="container">
        <nav>
            <div class="nav-wrap">
                <div class="compony-logo-container">
                    <img src="{{ url('assets/img/icons-logos/rokkit-white.png') }}" class="img-fluid" alt="">
                </div>
                <div class="link-container">
                    <ul>
                        <li><a href="/">Home</a></li>
                    </ul>
                </div>
                <div class="login-register-menu-container">
                    @auth
                        <div class="login-register loggedIn">
                            <a class="drop-down-trigger" id="drop-down-trigger">
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                {{ auth()->user()->name }}
                            </a>
                            <div class="drop-down-links-container">
                                <ul>
                                    {{-- <li><a type="button" data-toggle="modal" data-target="#addNewBlog">Add New Blog</a></li> --}}
                                    <li><a href="/my-blogs/all/all">View My Blogs</a></li>
                                    <li><a href="/logout">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    @endauth
                    @guest
                        <div class="login-register">
                            <a href="/login">
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                Login/Register
                            </a>
                        </div>
                    @endguest

                </div>
            </div>    
        </nav>
    </div>
</section>