//ajax cart
$(document).ready(function () {
    $(".num_order").change(function () {
        //alert("đã thay đổi dữ liệu");
        var id = $(this).attr("data-id");
        var qty = $(this).val();
        var token = $("#token").val();
        var data = {
            id: id,
            qty: qty,
            _token: token
        };

        console.log(data)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: $(this).attr('data-url'),
            method: 'POST', // Post goặc Get, mặc ddingj Get
            data: data, // Dữ liệu truyền lên Sever
            dataType: 'json', // Html, text, script hoặc json
            success: function (data) {
                $("#sub_total-" + id).text(data.sub_total);
                $("#total-price span").text(data.total_price);
                //alert("ok");
            },
            // kiểm tra nếu có lỗi nó xuất lên
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    });
});


//ajax lọc sp
// $(document).on('change', '.ajax-filter-form select', function(event) {
//     alert("đã thay đổi dữ liệu");
// //     var form = $(this).closest('.ajax-filter-form');
// //    // event.preventDefault(); // Ngăn chặn trình duyệt tải lại trang
// //    // var formId = $(this).attr('id'); // Lấy ID của form
// //     var data = $(this).serialize(); // Lấy dữ liệu của form
// //     $.ajax({
// //         type: 'POST',
// //         url: '{{ route("filter_product") }}',
// //         data: data,
// //         success: function(data) {
// //             $('#' + formId).closest('.ajax-container').html(data); // Cập nhật nội dung trong container
// //         },
// //         error: function(xhr, status, error) {
// //             console.log(error);
// //         }
//     // });
// });
//ajajx thêm vào giỏ hàng
$(document).ready(function () {
    $('.add-to-cart-form').on('submit', function (event) {
        // alert('ok')
        event.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function (response) {
                if (response.success) {
                    $('#addToCartModal').modal('show');
                    // .html(response).fadeIn();
                    $('#addToCartModal .modal-body').html(response.message);
                    var count = response.count; // Số lượng sản phẩm trong giỏ hàng
                    $('#cart-count').text(count); // Cập nhật số lượng sản phẩm trên giao diện
                };
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    $(document).on('click', '.close-addToCartModal', function () {
        $('#addToCartModal').fadeOut();
    });
});







