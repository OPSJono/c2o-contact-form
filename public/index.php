<?php
    $error = false;
    $categories = [
        'Delivery',
        'Returns & Refunds',
        'Order Issues',
        'Payment, Promo & Gift Vouchers',
        'Technical',
        'Product & Stock',
    ];
    require_once('../vendor/autoload.php');

    if (isset($_GET['action']) && $_GET['action'] == 'submit') {
        $sql = "INSERT INTO contact_form (email,first_name,last_name,phone,reason)
                VALUES ('{$_GET['emails']}','{$_GET['firstName']}','{$_GET['lastName']}','{$_GET['phone_no']}','{$_GET['category']}')";

        $result = db_query($sql, db_connect());

        if ($result === false) {
            $error = true;
        }
    }
?>

<!doctype html>
<html>
<head>
    <title>Form</title>
    <link rel="stylesheet" href="css/style.min.css">
</head>
<body>
<div class="container">
    <div class="card my-5">
        <!--START FORM-->
        <form>
            <div class="card-body">
                <h1>Send us an email!</h1>
                <?= $error ? '<h1 style="color: red">Error</h1>' : '' ?>
                <hr/>
                <div class="form-group form-group-md">
                    <label for="select1" class="h6 text-uppercase">What is your question about?</label>
                    <select name="category" class="form-control" id="select1">
                        <option>Please Select</option>
                        <?php foreach ($categories as $category) {
                            echo '<option>'.$category.'</option>';
                        } ?>
                    </select>
                </div>
                <hr/>
                <h3>About you</h3>
                <div class="form-group form-group-md">
                    <div class="form-group">
                        <label for="inputEmail1" class="h6 text-uppercase">Email address</label>
                        <input name="email" class="form-control" id="inputEmail1" aria-describedby="emailHelp"
                               placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                            else.
                        </small>
                    </div>
                </div>
                <div class="form-group form-group-md">
                    <div class="form-group">
                        <label for="inputName" class="h6 text-uppercase">First name</label>
                        <input name="firstName" type="text" class="form-control" id="inputName" placeholder="Enter name">
                    </div>
                </div>
                <div class="form-group form-group-md">
                    <div class="form-group">
                        <label for="inputLastName" class="h6 text-uppercase">Last name</label>
                        <input name="lastName" type="text" class="form-control" id="inputLastName" placeholder="Enter last name">
                    </div>
                </div>
                <div class="form-group form-group-md">
                    <div class="form-group">
                        <label for="inputName" class="h6 text-uppercase">Phone</label>
                        <input name="phone" type="text" class="form-control" id="inputPhone" placeholder="Enter phone">
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <input type="submit" class="btn btn-primary btn-lg" value="Submit" />
                <input type="hidden" name="action" value="submit" />
            </div>
        </form>
        <!--END FORM-->
    </div>
</div>
<script src="main.js"></script>
</body>
</html>