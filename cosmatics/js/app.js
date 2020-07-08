$(document).on('submit','#login_form',function(e){
    e.preventDefault();
    $userEmail = $(this).find('input[name="user-email"]').val();
    $userPass  = $(this).find('input[name="user-password"]').val();
    $btndis    = $(this).find('input[type="submit"]').attr("disabled", "disabled");
    $btnMsg    = $(this).find('input[id="login-btn"]').val("Please wait...");
    $.ajax({
        method: "POST",
        url: $(this).attr('action'),
        data: {"username":$userEmail,"password":$userPass,'user_type':'1'},
        success:function(response){
            var obj = JSON.parse(response);
            $('.error-msg').html(obj.massege).css('color',obj.style_color);
            $btndis.removeAttr("disabled");
            $btnMsg.val("Sign In");
            if(obj.status === true){
                window.location.href=obj.redirectURL;
            }
        }
    });
});

//$(".datepicker").datepicker();
//$('.category_id').on('change',function(){
//    subcategoryList($(this).val(),$(this).data('url'));
//})
//$(document).ready(function() {
//    subcategoryList($(".category_id").val(),$(".category_id").data('url'));
//})
//function subcategoryList($argfirst,$argsec){
//    $.ajax({
//        method: "POST",
//        url: $argsec,
//        data: {"category_id":$argfirst},
//        success:function(response){
//            var obj = JSON.parse(response);
//            if(obj.data!=''){
//                $(".sub-categoryBox").html(obj.option).show();
//            }else{
//                $(".sub-categoryBox").hide();
//            }
//        }
//    });
//}
//alert("Hello");
//var dataTable = '';
//$(document).ready(function () {
//    alert(window.location.href);
//    var dataTable = jQuery('#customer-list').DataTable({
//        "processing": true,
//        "serverSide": true,
//        "aoColumns": [
//            {"bSortable": false},
//            {"bSortable": true},
//            {"bSortable": true},
//            {"bSortable": true},
//            {"bSortable": true},
//            {"bSortable": true},
//            {"bSortable": false},
//        ],
//        "ajax": {
//            url: window.location.href, // json datasource
//            type: "post", // method  , by default get
//            error: function () {  // error handling
//                jQuery(".business-user-grid-error").html("");
//                jQuery("#buyers_grid").append('<tbody class="business-user-grid-error"><tr><th colspan="7">No data found in the server</th></tr></tbody>');
//                jQuery("#buyers_grid_processing").css("display", "none");
//            }
//        }
//    });
//});

function changeUserStatus(obj, status, accountType) { 
    var user_id = obj.id;
    $.ajax({
        url: "<?php echo site_url('admin/change_status'); ?>",
        dataType: 'JSON',
        type: "POST",
        data: {'user_id': user_id, 'status': status, 'accountType': accountType},
        success: function (data)
        {
            if (data.success == 'success') {
                window.location.reload();
            }
        }, error: function () {

        }
    });
}

$(document).ready(function () {
    $('a.Exceltest').click(function () {
        location.href = '<?php echo site_url("admin/downloadUsersExcel") ?>';
    });
});