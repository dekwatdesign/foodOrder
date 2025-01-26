function logout() {
    $.ajax({
        url: './actions/work_auth_logout.php',
        type: 'POST',
        data: {},
        dataType: 'JSON',
        success: function(result) {
            if (result.status === 'success') {
                window.location = './login.php';
            }
            else {
                alert(result.message);
            }
        }
    });
}