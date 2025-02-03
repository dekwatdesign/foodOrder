function logout() {
    $.ajax({
        url: webroot+'actions/logout.php',
        type: 'POST',
        data: {},
        dataType: 'JSON',
        success: function(result) {
            if (result.status === 'success') {
                window.location.href = webroot+'login.php';
            }
            else {
                alert(result.message);
            }
        }
    });
}