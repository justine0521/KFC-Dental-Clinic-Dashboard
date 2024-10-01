function verifyOTP() {
    var enteredOTP = "";
    for (var i = 1; i <= 6; i++) {
        enteredOTP += $("#input" + i).val();
    }

    $.ajax({
        type: "POST",
        url: "verify_otp.php",
        data: { otp: enteredOTP },
        success: function(response) {
            alert(response);
        }
    });
}