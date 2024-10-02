<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/solid.min.css">


    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
        type="text/css">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet" type="text/css">

    {{-- chọn nhiều select option 1 lúc  phân quyền --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <title>Admintrator</title>
</head>

<body>
    <div id="warpper" class="nav-fixed">
        <nav class="topnav shadow navbar-light bg-white d-flex">
            <div class="navbar-brand"><a href="?">UNITOP ADMIN</a></div>
            <div class="nav-right ">
                <div class="btn-group mr-auto">
                    <button type="button" class="btn dropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="plus-icon fas fa-plus-circle"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('admin/posts/add') }}">Thêm bài viết</a>
                        <a class="dropdown-item" href="{{ url('admin/products/add') }}">Thêm sản phẩm</a>
                        <a class="dropdown-item" href="{{ url('admin/orders/list') }}">Xem đơn hàng</a>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Tài khoản</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end nav  -->
        @php
            $module_active = session('module_active'); //gọi thằng active trong hàm construct controlle thằng cần active ra
        @endphp
        <div id="page-body" class="d-flex">
            <div id="sidebar" class="bg-white">
                <ul id="sidebar-menu">
                    <li class="nav-link {{ $module_active == 'dashboard' ? 'active' : '' }}">
                        <a href="{{ url('dashboard') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Dashboard
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                    </li>
                    @canany(['product.list', 'product.add', 'product.edit', 'product.delete'])
                        <li class="nav-link {{ $module_active == 'product' ? 'active' : '' }}">
                            <a href="{{ url('admin/products/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Sản phẩm
                            </a>
                            <i class="arrow fas fa-angle-down"></i>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/products/add') }}">Thêm mới</a></li>
                                <li><a href="{{ url('admin/products/list') }}">Danh sách</a></li>
                                <li><a href="{{ url('admin/products/cat/list') }}">Danh mục</a></li>
                            </ul>
                        </li>
                    @endcanany
                    @canany(['order.list', 'order.add', 'order.edit', 'order.delete'])
                        <li class="nav-link {{ $module_active == 'order' ? 'active' : '' }}">
                            <a href="{{ url('admin/orders/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Bán hàng
                            </a>
                            <i class="arrow fas fa-angle-right"></i>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/orders/list') }}">Đơn hàng</a></li>
                            </ul>
                        </li>
                    @endcanany
                    @canany(['page.list', 'page.add', 'page.edit', 'page.delete'])
                        <li class="nav-link {{ $module_active == 'page' ? 'active' : '' }}">
                            <a href="{{ url('admin/pages/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Trang
                            </a>
                            <i class="arrow fas fa-angle-right"></i>

                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/pages/add') }}">Thêm mới</a></li>
                                <li><a href="{{ url('admin/pages/list') }}">Danh sách</a></li>
                            </ul>
                        </li>
                    @endcanany
                    @canany(['slider.list', 'slider.add', 'slider.edit', 'slider.delete'])
                        <li class="nav-link {{ $module_active == 'sliders' ? 'active' : '' }}">
                            <a href="{{ url('admin/sliders/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Slider
                            </a>
                            <i class="arrow fas fa-angle-right"></i>

                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/sliders/add') }}">Thêm mới</a></li>
                                <li><a href="{{ url('admin/sliders/list') }}">Danh sách</a></li>
                            </ul>
                        </li>
                    @endcanany
                    @canany(['banner.list', 'banner.add', 'banner.edit', 'banner.delete'])
                        <li class="nav-link {{ $module_active == 'banners' ? 'active' : '' }}">
                            <a href="{{ url('admin/banners/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Banner
                            </a>
                            <i class="arrow fas fa-angle-right"></i>

                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/banners/add') }}">Thêm mới</a></li>
                                <li><a href="{{ url('admin/banners/list') }}">Danh sách</a></li>
                            </ul>
                        </li>
                    @endcanany
                    @canany(['menu.list', 'menu.add', 'menu.edit', 'menu.delete'])
                        <li class="nav-link {{ $module_active == 'menus' ? 'active' : '' }}">
                            <a href="{{ url('admin/menus/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Menu
                            </a>
                            <i class="arrow fas fa-angle-right"></i>

                            <ul class="sub-menu">

                                <li><a href="{{ url('admin/menus/list') }}">Danh sách</a></li>
                            </ul>
                        </li>
                    @endcanany
                    @canany(['post.list', 'post.add', 'post.edit', 'post.delete'])
                        <li class="nav-link {{ $module_active == 'post' ? 'active' : '' }}">
                            <a href="{{ url('admin/posts/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Bài viết
                            </a>
                            <i class="arrow fas fa-angle-right"></i>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/posts/add') }}">Thêm mới</a></li>
                                <li><a href="{{ url('admin/posts/list') }}">Danh sách</a></li>
                                <li><a href="{{ url('admin/posts/cat/list') }}">Danh mục</a></li>
                            </ul>
                        </li>
                    @endcanany
                    @canany(['user.list', 'user.add', 'user.edit', 'user.delete'])
                        <li class="nav-link {{ $module_active == 'user' ? 'active' : '' }}">
                            <a href="{{ url('admin/users/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Users
                            </a>
                            <i class="arrow fas fa-angle-right"></i>

                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/users/add') }}">Thêm mới</a></li>
                                <li><a href="{{ url('admin/users/list') }}">Danh sách</a></li>
                            </ul>
                        </li>
                    @endcanany
                    @canany(['role.list', 'role.add', 'role.edit', 'role.delete'])
                        <li class="nav-link {{ $module_active == 'permission' ? 'active' : '' }}">
                            <a href="{{ route('permission.add') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Phân quyền
                            </a>
                            <i class="arrow fas fa-angle-right"></i>

                            <ul class="sub-menu">
                                <li><a href="{{ route('permission.add') }}">Quyền</a></li>
                                @can('role.add')
                                    <li><a href="{{ url('admin/role/add') }}">Thêm vai trò</a></li>
                                @endcan

                                <li><a href="{{ url('admin/role/list') }}">Danh sách vai trò</a></li>
                            </ul>
                        </li>
                    @endcanany

                    {{-- <li class="nav-link {{ $module_active == 'role' ? 'active' : '' }}">
                        <a href="{{ url('admin/role/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Danh sách các vai trò
                        </a>
                        <i class="arrow fas fa-angle-right"></i>

                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/role/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/role/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'permission' ? 'active' : '' }}">
                        <a href="{{ url('admin/permission/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Danh sách các quyền
                        </a>
                        <i class="arrow fas fa-angle-right"></i>

                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/permission/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/permission/list') }}">Danh sách</a></li>
                        </ul>
                    </li> --}}

                    <!-- <li class="nav-link"><a>Bài viết</a>
                        <ul class="sub-menu">
                            <li><a>Thêm mới</a></li>
                            <li><a>Danh sách</a></li>
                            <li><a>Thêm danh mục</a></li>
                            <li><a>Danh sách danh mục</a></li>
                        </ul>
                    </li>
                    <li class="nav-link"><a>Sản phẩm</a></li>
                    <li class="nav-link"><a>Đơn hàng</a></li>
                    <li class="nav-link"><a>Hệ thống</a></li> -->

                </ul>
            </div>
            <div id="wp-content">
                @yield('content')

            </div>
        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    {{-- tiny --}}
    <script src="https://cdn.tiny.cloud/1/z59s9nax0wvio1urcclud8r5t1i9iawi7onkcdo19prd7ppn/tinymce/4/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ asset('js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
    {{-- chọn nhiều select option 1 lúc phân quyền --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script type="text/javascript">
        var editor_config = {
            path_absolute: "http://localhost/unimart/",
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback: function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };

        tinymce.init(editor_config);

        /// checkbox vai trò và quyên
        //checkbox all xuống các checkbox parent_của checkbox con
        // Lấy đối tượng của checkbox cha
        var parentCheckbox = document.getElementById('item-1');

        // Lấy danh sách các checkbox con
        var childCheckboxes = document.querySelectorAll('.checkbox_child');

        // Đăng ký sự kiện change cho checkbox cha
        parentCheckbox.addEventListener('change', function() {
            // Nếu checkbox cha được chọn
            if (parentCheckbox.checked) {
                // Chọn tất cả các checkbox con
                childCheckboxes.forEach(function(checkbox_child) {
                    checkbox_child.checked = true;
                });
            } else {
                // Bỏ chọn tất cả các checkbox con
                childCheckboxes.forEach(function(checkbox_child) {
                    checkbox_child.checked = false;
                });
            }
        });

        // Đăng ký sự kiện change cho mỗi checkbox con
        childCheckboxes.forEach(function(checkbox_child) {
            checkbox_child.addEventListener('change', function() {
                // Nếu tất cả các checkbox con đều được chọn
                if (document.querySelectorAll('.checkbox_child:checked').length === childCheckboxes
                    .length) {
                    // Chọn checkbox cha
                    parentCheckbox.checked = true;
                } else {
                    // Bỏ chọn checkbox cha
                    parentCheckbox.checked = false;
                }
            });
        });
    </script>

</body>

</html>
