//ajax tỉnh huyện

// $(document).ready(function () {
//     $('#province').on('change', function () {
//         let province_id = $(this).val();
//          //alert(province_id);
//         $.ajax({
//             type: 'GET',
//             url: 'get-districts/' + province_id,

//             success: function (response) {
//                 var response = JSON.parse(response);
//                 console.log(response);


//                 response.forEach(element => {
//                     $('#district').append(
//                         `<option data-name="${element['name']}" value="${element['district_id']}">${element['name']}</option>`
//                     );
//                 });
//             }
//         });
//     });
//     //quận, xã
//     $('#district').on('change', function () {
//         let district_id = $(this).val();
//         // alert(province_id);
//         console.log
//         $.ajax({
//             type: 'GET',
//             url: 'get-wards/' + district_id,

//             success: function (response) {
//                 var response = JSON.parse(response);
//                 console.log(response);


//                 response.forEach(element => {
//                     $('#ward').append(
//                         `<option data-name="${element['name']} " value="${element['ward_id']}">${element['name']}</option>`
//                     );
//                 });
//             }
//         });
//     });
// });

// ///thêm tên tỉnh quận xã vào mysql(thêm 1 input hidden) thêm thuộc tính data-name vào option
// // Sau đó, để lấy giá trị tên tỉnh từ select box, 
// // ta có thể sử dụng JavaScript để lấy giá trị data-name tương ứng 
// // với giá trị được chọn trong select box và gán giá trị đó vào một input field ẩn.
// $('#province').on('change', function () {
//     var selectedOption = $(this).find(':selected');
//     var provinceName = selectedOption.data('name');
//     $('#province_name').val(provinceName);
// });
// $('#district').on('change', function () {
//     var selectedOption = $(this).find(':selected');
//     var districtName = selectedOption.data('name');
//     $('#district_name').val(districtName);
// });
// $('#ward').on('change', function () {
//     var selectedOption = $(this).find(':selected');
//     var wardName = selectedOption.data('name');
//     $('#ward_name').val(wardName);
// });