
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<link rel="stylesheet" href="contact.css">

<body>
            <div class="container contact">
                <div class="row">
                    <div class="col-md-3">
                        <div class="contact-info">
                            <img src="https://image.ibb.co/kUASdV/contact-image.png" alt="image"/>
                            <h2>Contact Us</h2>
                            <h4>We would love to hear from you !</h4>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <form class="myForm contact-form">
                            <div class="form-group">
                            <label class="control-label col-sm-2" for="fname">Full Name:</label>
                            <div class="col-sm-10">          
                                <input type="text" class="form-control" id="name" placeholder="Enter Full Name" name="fname" required>
                            </div>
                            </div>
                            <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Email:</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
                            </div>
                            </div>
                            <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Subject:</label>
                            <div class="col-sm-10">
                                <input  class="form-control" id="subject" placeholder="Type the Subject" name="email" required>
                            </div>
                            </div>
                            <div class="form-group">
                            <label class="control-label col-sm-2" for="comment">Comment:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" id="body"></textarea>
                            </div>
                            </div>
                            <div class="form-group">        
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" onclick="sendEmail()" name="submit" class="btn btn-default">Submit</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            



	<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
        function sendEmail() {
            var name = $("#name");
            var email = $("#email");
            var subject = $("#subject");
            var body = $("#body");

            if (isNotEmpty(name) && isNotEmpty(email) && isNotEmpty(subject) && isNotEmpty(body)) {
                $.ajax({
                   url: 'sendEmail.php',
                   method: 'POST',
                   dataType: 'json',
                   data: {
                       name: name.val(),
                       email: email.val(),
                       subject: subject.val(),
                       body: body.val()
                   }, success: function (response) {
                        $('#myForm')[0].reset();
                        $('.sent-notification').text("Message Sent Successfully.");
                   }
                });
            }
        }

        function isNotEmpty(caller) {
            if (caller.val() == "") {
                caller.css('border', '1px solid red');
                return false;
            } else
                caller.css('border', '');

            return true;
        }
    </script>

</body>
</html>