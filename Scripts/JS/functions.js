//Function is used in INDEX page, gets details from database and displays them using AJAX, depending which option is selected.
function showUser(str)
{
	var xhttp;
	if (str == "")
	{
		document.getElementById("text-container").innerHTML = "";
		return;
	}

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("text-container").innerHTML = this.responseText;
		}
	};

	xhttp.open("GET", "get-user.php?q=" + str, true);
	xhttp.send();
	
}

//function is used to gather data from the sign up form, validate it, and insert the data in to javascript.
$(document).ready(function(){
	$("#sign-up-form").submit(function(event) 
	{
		event.preventDefault();
	    $(".form-group").removeClass("has-error");
	    $(".help-block").remove();

	    var formData = 
	    {
	        username: $("#username").val(),
	        password: $("#password").val(),
	        verifypassword: $("#verifypassword").val(),
	        gender: $("#gender").val(),
	        pnumber: $("#pnumber").val(),
	    };

	    $.ajax({
	        type: "POST",
	        url: "Validate/sign-up.php",
	        data: formData,
	        dataType: "json",
	        encode: true,
	    }).done(function(data) 
	    {
	        console.log(data);
	        if (!data.success) //if errors are found
	        {
	            if (data.errors.username) //display error messages dynamically
	            {
	                $("#username-group").addClass("has-error");
	                $("#username-group").append(
	                    '<div class="help-block">' + data.errors.username + "</div>"
	                );
	            }

	            if (data.errors.password) 
	            {
	                $("#password-group").addClass("has-error");
	                $("#password-group").append(
	                    '<div class="help-block">' + data.errors.password + "</div>"
	                );
	            }

	            if (data.errors.verifypassword) 
	            {
	                $("#verify-password-group").addClass("has-error");
	                $("#verify-password-group").append(
	                    '<div class="help-block">' + data.errors.verifypassword + "</div>"
	                );
	            }

	            if (data.errors.gender) 
	            {
	                $("#gender-group").addClass("has-error");
	                $("#gender-group").append(
	                    '<div class="help-block">' + data.errors.gender + "</div>"
	                );
	            }

	            if (data.errors.pnumber) 
	            {
	                $("#phone-group").addClass("has-error");
	                $("#phone-group").append(
	                    '<div class="help-block">' + data.errors.pnumber + "</div>"
	                );
	            }

	        } 
	        else 
	        {
	            $("#sign-up-form").html(
	                '<div class="alert alert-success">' + data.message + "</div>"
	            );
	        }
	    });
	});
});

//function gets information inputted from the login form, validates it with the database.
$(document).ready(function() 
{
    $("#log-in-form").submit(function(event) 
    {
    	event.preventDefault();
        $(".form-group").removeClass("has-error");
        $(".help-block").remove();

        var formData = 
        {
            username: $("#username-input").val(),
            password: $("#password-input").val(),
        };

        $.ajax(
        {
            type: "POST",
            url: "Validate/log-in.php",
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function(data) 
        {
            console.log(data);
            if (!data.success) //if errors are found, display error messages dynamically
            {
                if (data.errors.username) 
                {
                    $("#login-username-group").addClass("has-error");
                    $("#login-username-group").append(
                        '<div class="help-block">' + data.errors.username + "</div>"
                    );
                }

                if (data.errors.password) 
                {
                    $("#login-password-group").addClass("has-error");
                    $("#login-password-group").append(
                        '<div class="help-block">' + data.errors.password + "</div>"
                    );
                }


            } 

            else //if an account has been found
            {
                $("#log-in-form").html(
                    '<div class="alert alert-success">' + data.message + "</div>"
                );
                
                setTimeout(function() //redirect user to index page
                {
                	window.location.href = "index.php";
                }, 2000);
            }
        });
    });
});

//Function to process the review search form.
$(document).ready(function() {
    $("#search-form").submit(function(event) {
        $("#review-card-container").empty();
        var formData = {
            title: $("#title-reviews-search").val(),
            rating: $("#rating-reviews-search").val(),
        };
        $.ajax({
            type: "POST",
            url: "Validate/review-search.php",
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function(data) { //once the inputs are processed, data is dynamically selected from the database and is displayed.
            console.log(data.success);

            if(data.success == false)
            {
                $("#review-card-container").append("<h2 class='text-center'>"+ data.message +"</h2>");
            }

            else
            {
                for (let i = 0; i < data.Titles.length; i++) {
                    $("#review-card-container").append('<div class="review-cards"><div class="card border-dark"><div class="card-header">' + data.Titles[i] + '</div><div class="card-body"><h5 class="card-title">' + data.Ratings[i] + '/5</h5><p class="card-text">' + data.Opinions[i] + '</p></div><div class="card-footer">Submitted by ' + data.Usernames[i] + '</div></div></div>');
                }
            }
            

        });

        event.preventDefault();
    });
});

//Function to process the submit review form.
$(document).ready(function() {
    $("#review-form").submit(function(event) {
    	event.preventDefault();
        $(".form-group").removeClass("has-error");
        $(".help-block").remove();

        var formData = {
            title: $("#title-input").val(),
            rating: $("#rating-input").val(),
            opinion: $("#opinion-input").val(),
        };

        $.ajax({
            type: "POST",
            url: "Validate/submit-review.php",
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function(data) {
            console.log(data);
            if (!data.success) { //if errors are found, display messages dynamically
                if (data.errors.rating) {
                    $("#rating-group").addClass("has-error");
                    $("#rating-group").append(
                        '<div class="help-block text-center">' + data.errors.rating + "</div>"
                    );
                }

                if (data.errors.opinion) {
                    $("#opinion-group").addClass("has-error");
                    $("#opinion-group").append(
                        '<div class="help-block">' + data.errors.opinion + "</div>"
                    );
                }

                if (data.errors.title) {
                    $("#title-group").addClass("has-error");
                    $("#title-group").append(
                        '<div class="help-block">' + data.errors.title + "</div>"
                    );
                }

            } else {
                $("#review-form").html( //if form is successfully submitted, show user a success message.
                    '<div class="alert alert-success">' + data.message + "</div>"
                );
            }
        });
    });
});

//Function to process the form when a user wants to change their password
$(document).ready(function() 
{
    $("#change-password-form").submit(function(event) 
    {
        $(".form-group").removeClass("has-error");
        $(".help-block").remove();

        var formData = 
        {
            current_password: $("#current_password").val(),
            new_password: $("#new_password").val(),
            verify_new_password: $("#verify_new_password").val(),
        };

        $.ajax(
        {
            type: "POST",
            url: "Validate/change-password.php",
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function(data) 
        {
            console.log(data);
            if (!data.success) //if there are errors, display messages dynamically
            {
                if (data.errors.current_password) 
                {
                    $("#current-password-group").addClass("has-error");
                    $("#current-password-group").append(
                        '<div class="help-block">' + data.errors.current_password + "</div>"
                    );
                }

                if (data.errors.new_password) 
                {
                    $("#password-group").addClass("has-error");
                    $("#password-group").append(
                        '<div class="help-block">' + data.errors.new_password + "</div>"
                    );
                }

                if (data.errors.verify_new_password) 
                {
                    $("#verify-password-group").addClass("has-error");
                    $("#verify-password-group").append(
                        '<div class="help-block">' + data.errors.verify_new_password + "</div>"
                    );
                }


            } 

            else //if there are no errors, display success message.
            {
                $("#change-password-form").html(
                    '<div class="alert alert-success">' + data.message + "</div>"
                );
            }
        });

        event.preventDefault();
    });
});