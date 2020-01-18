$('document').ready(function() { 
    /* Validator */
    $('#register-form').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {

			user_email: {
                validators: {
                    notEmpty: {
                        message: 'Enter your email address'
                    },
                    emailAddress: {
                        message: 'Enter a valid email address'
                    }
                }
            }
		}
	})
	/* Form submit */
	.on('success.form.bv', function(e) {
		$('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
		$('#register-form').data('bootstrapValidator').resetForm();

		// Prevent form submission
		e.preventDefault();

		// Get the form instance
		var $form        = $(e.target),
			validator    = $form.data('bootstrapValidator'),
			submitButton = validator.getSubmitButton();

		// Use Ajax to submit form data
		$this = $(this);
		$.ajax({
			type : 'POST',
			url  : 'change.php',
			data : $this.serialize(),
			beforeSend: function() { 
				$("#error").fadeOut();
				$("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success : function(data) {
				if(data==1){
					$("#error").fadeIn(1000, function() {
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Email address already exists !</div>');
						$("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Reset Password');
					});
				}
				else if(data=="resetpw") {
					$("#btn-submit").html('<img src="img/btn-ajax-loader.gif" /> &nbsp; Signing Up ...');
					setTimeout('$(".form-signin").fadeOut(500, function(){ $(".signin-form").load("success2.php"); }); ',5000);
				}
				else {
					$("#error").fadeIn(1000, function() {
						$("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');
						$("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Reset Password');
					});
				}
			}
		});
	});
});