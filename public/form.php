<!doctype html>
<html lang="en">
<head>
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/style.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
</head>
<body>
<div class="container">
    <div class="card my-5">
        <!--START FORM-->
        <form action="/" method="POST" class="js-form-submit">
            <div class="card-header">
                <h1>Send us an email!</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 alert alert-success js-form-error hidden">
                        Thank you for contacting us, we aim to reply to all queries within 24 hours.
                    </div>
                    <div class="col-md-12 alert alert-danger js-form-success hidden">
                        There was a problem saving the form, please correct the errors below and try again.
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="categoryId" class="h6 text-uppercase">What is your question about?</label>
                        <select name="categoryId" required class="form-control selectpicker" id="categoryId">
                            <option value="">Please Select</option>
                            <?php if(isset($categories) && is_array($categories)): ?>
                                <?php foreach($categories as $key => $row): ?>
                                    <option value="<?php echo $row['id'] ?? '' ?>"><?php echo $row['name'] ?? '' ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="orderNumber" class="h6 text-uppercase">Order Number</label>
                        <input name="orderNumber" type="number" class="form-control" id="orderNumber" min="1" placeholder="Enter order number">
                    </div>
                </div>
                <hr/>
                <h3>About you</h3>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="firstName" class="h6 text-uppercase">First name</label>
                        <input name="firstName" type="text" class="form-control" id="firstName" placeholder="Enter first name">
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="lastName" class="h6 text-uppercase">Last name</label>
                        <input name="lastName" type="text" class="form-control" id="lastName" placeholder="Enter last name">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="email" class="h6 text-uppercase">Email address</label>
                        <input name="email" type="email" required class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email address">
                        <small id="emailHelp" class="form-text text-muted">
                            We'll never share your email with anyone else.
                        </small>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="phoneNo" class="h6 text-uppercase">Phone</label>
                        <input name="phoneNo" type="text" class="form-control" id="phoneNo" placeholder="Enter phone number">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="comment" class="h6 text-uppercase">Comment</label>
                        <textarea name="comment" class="form-control" id="comment" placeholder="How can we help?"></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
            </div>
        </form>
        <!--END FORM-->
    </div>
</div>
<script src="index.js"></script>
</body>
</html>