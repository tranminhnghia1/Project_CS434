$(document).ready(function () {
    $('.nav-link.active .sub-menu').slideDown();
    // $("p").slideUp();

    $('#sidebar-menu .arrow').click(function () {
        $(this).parents('li').children('.sub-menu').slideToggle();
        $(this).toggleClass('fa-angle-right fa-angle-down');
    });

    $("input[name='checkall']").click(function () {
        var checked = $(this).is(':checked');
        $('.table-checkall tbody tr td input:checkbox').prop('checked', checked);
    });
});

//hiển thị ảnh khi thêm sản phẩm
$(document).ready(function() {
    // Lắng nghe sự kiện khi chọn 1 ảnh
    $('#product_thumb').change(function() {
        //console.log('#product_thumb');
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#image-preview').html('<img src="' + e.target.result + '" style="width: 100px;">');
        }
        reader.readAsDataURL(this.files[0]);
    });

    // Lắng nghe sự kiện khi chọn nhiều ảnh
    $('#product_image').change(function() {
        $('#images-preview-container').html('');
        for (var i = 0; i < this.files.length; i++) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#images-preview-container').append('<img src="' + e.target.result + '" style="width: 100px;">');
            }
            reader.readAsDataURL(this.files[i]);
        }
    });
});



