<?php
    require_once('../vendor/autoload.php');

    $dbConnection = db_connect();
    $sql = 'select id, name from categories;';
    $categories = db_query($sql, $dbConnection);

?>

<!doctype html>
<html lang="en">
<head>
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/style.min.css">
</head>
<body>
    <div class="container">
        <div class="card my-5">
            <!--START FORM-->
            <form action="/ajax.php" method="post" class="js-form-submit">
                <div class="card-body">
                    <h1>Send us an email!</h1>
                    <h3 class="js-has-error text-danger" style="display: none;">Whoops! There was an error submitting the form. Please try again later.</h3>
                    <h3 class="js-has-success text-success" style="display: none;">Success! Thanks for getting in touch, we will get back to you as soon as we can.</h3>
                    <h3 class="js-has-saving text-info" style="display: none;">Saving...</h3>
                    <hr/>
                    <div class="form-group row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="category" class="h6 text-uppercase">What is your question about?</label>
                            <select name="category" class="form-control selectpicker" id="category">
                                <option>Please Select</option>
                                <?php if(isset($categories) && $categories != false) {
                                    while ($row = $categories->fetch_assoc()) {
                                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="orderNumber" class="h6 text-uppercase">Order Number</label>
                            <input name="orderNumber" type="number" class="form-control" id="orderNumber" min="1" placeholder="Enter order number">
                        </div>
                    </div>
                    <hr/>
                    <h3>About you</h3>
                    <div class="form-group row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="firstName" class="h6 text-uppercase">First name</label>
                            <input name="firstName" type="text" class="form-control" id="firstName" placeholder="Enter first name">
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="lastName" class="h6 text-uppercase">Last name</label>
                            <input name="lastName" type="text" class="form-control" id="lastName" placeholder="Enter last name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="email" class="h6 text-uppercase">Email address</label>
                            <input name="email" class="form-control" id="email" aria-describedby="emailHelp"
                                   placeholder="Enter email address">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                                else.
                            </small>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="phoneNo" class="h6 text-uppercase">Phone</label>
                            <input name="phoneNo" type="text" class="form-control" id="phoneNo" placeholder="Enter phone number">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="form-group col-sm-12">
                            <label for="comment" class="h6 text-uppercase">Comment</label>
                            <textarea name="comment" class="form-control" id="comment" placeholder="How can we help?"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <input type="submit" class="btn btn-primary btn-lg" value="Submit" />
                </div>
            </form>
            <!--END FORM-->
        </div>
    </div>
    <script src="index.js"></script>
</body>
</html>