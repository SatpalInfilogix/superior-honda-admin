<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="img js-fullheight" style="background-image: url(assets/images/bg.jpg);">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Login</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Have an account?</h3>
                        <form action="{{ route('authenticate') }}" class="signin-form" method="post">
                            @csrf
                            <div class="form-group form-primary">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Username" required>
                                <span class="text-danger error-message" id="email-error"></span>
                            </div>
                            <div class="form-group form-primary">
                                <input id="password-field" name="password" id="password" type="password" class="form-control" placeholder="Password" required>
                                <span class="text-danger error-message" id="password-error"></span>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <label class="checkbox-wrap checkbox-primary">Remember Me
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="#" style="color: #fff">Forgot Password</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"8ba2ed5d7b22a747","serverTiming":{"name":{"cfL4":true}},"version":"2024.8.0","token":"cd0b4b3a733644fc843ef0b185f98241"}'
        crossorigin="anonymous"></script>
    <script>
        $(function() {
            $("form").validate({
                rules: {
                    email: {
                        required: true,
                        email: true // Email format validation
                    },
                    password: {
                        required: true,
                        minlength: 6 // Password must be at least 6 characters long
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    }
                },
                errorClass: "text-danger f-12",
                errorElement: "span",
                errorPlacement: function(error, element) {
                    var errorId = "#" + element.attr("id") + "-error";
                    $(errorId).text(error.text());
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).parent().removeClass("form-primary").addClass("form-danger");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).parent().removeClass("form-danger").addClass("form-primary");
                    var errorId = "#" + $(element).attr("id") + "-error";
                    $(errorId).text(""); // Clear the error message
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });

        // Toggle password visibility
        $(".toggle-password").on('click', function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
</body>

</html>
