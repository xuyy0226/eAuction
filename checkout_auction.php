<?php
    require 'connection.php';
    session_start();
    $item_id=$_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Eauction</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
        <!-- jquery library -->
    <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
        <!-- Latest compiled and minified javascript -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <!-- External CSS -->
    <link href="form-validation.css" rel="stylesheet">
  </head>

  <body class="bg-light">
    <?php
      require 'header.php';
    ?>
    <div class="container">
      <div class="py-5 text-center">
        <h2>Checkout</h2>
      </div>
      <div class="row">
        <form  method="post" action="checkout_submit_auction.php?id=<?php echo $item_id; ?>">
          <div class="col-md-4 mb-6">
               <label for="state">Shipment</label><br>
               <select class="custom-select d-block w-100" name="shipprice" required="true">
               <option value="">Choose...</option>
               <option value="2">2 Day Shipping -- $25</option>
               <option value="3">3 Day Shipping -- $15</option>
               <option value="4">4 Day Shipping -- $8</option>
               </select>
          </div>
      </div>
      <div class="row">
        
        <div class="col-md-12 order-md-1">
          <h4 class="mb-6">Billing address</h4>
          
            <div class="row">
              <div class="col-md-6 mb-6">
                <label for="firstName">First name</label>
                <input type="text" class="form-control" name="firstName" placeholder="First Name" required="true">
                
              </div>
              <div class="col-md-6 mb-6">
                <label for="lastName">Last name</label>
                <input type="text" class="form-control" name="lastName" placeholder="Last Name" required="true">
              </div>
            </div>

            <div class="mb-6">
              <label for="address">Phone</label>
              <input type="text" class="form-control" name="phone" placeholder="1234 Main St" required="true">
            </div>
            <div class="mb-6">
              <label for="address">Address</label>
              <input type="text" class="form-control" name="address" placeholder="1234 Main St" required="true">

            </div>

            <div class="mb-6">
              <label for="address2">Address 2 <span class="text-muted"></span></label>
              <input type="text" class="form-control" name="address2" placeholder="Apartment or suite" required="true"><br>
            </div>
      

            <div class="row">
              <div class="col-md-4 mb-6">
                <label for="zip">City</label>
                <input type="text" class="form-control" name="city" placeholder="city" required="true">
              </div>
              <div class="col-md-4 mb-6">
                <label for="state">State</label><br>
                <select class="custom-select d-block w-100" name="state" required="true">
                  <option value="">Choose...</option>
                  <option>California</option>
                  <option></option>
                  <option></option>
                </select>
              </div>
              <div class="col-md-4 mb-6">
                <label for="zipcode">Zip</label>
                <input type="text" class="form-control" name="zipcode" placeholder="" required="true">
              </div>
            </div>
            <hr class="mb-6">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name="isbilling">
              <label class="custom-control-label" for="same-address">I want bills to this address</label>
            </div>
            
            <hr class="mb-6">

            <h4 class="mb-6">Payment</h4>

            <div class="d-block my-3">
              <div class="custom-control custom-radio">
                <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required="true">
                <label class="custom-control-label" for="credit">Credit card</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required="true">
                <label class="custom-control-label" for="debit">Debit card</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="cc-name">Name on card</label>
                <input type="text" class="form-control" name="name_on_card" placeholder="" required="true">
                <small class="text-muted">Full name as displayed on card</small>
              </div>
              <div class="col-md-6 mb-3">
                <label for="cc-number">Credit card number</label>
                <input type="text" class="form-control" name="card_number" placeholder="" required="true">
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 mb-3">
                <label for="cc-expiration">Expiration</label>
                <input type="text" class="form-control" name="expiration_date" placeholder="" required="true">
              </div>
              <div class="col-md-3 mb-3">
                <label for="cc-expiration">CVV</label>
                <input type="text" class="form-control" name="cvv" placeholder="" required="true">
              </div>
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Place Order</button>
          </form>
        </div>
      </div>

       <footer class="footer"> 
          <div class="container">
          <center>
              <p>Copyright &copy Eauction. All Rights Reserved.</p>
              <p>This website is developed by A Squad</p>
          </center>
          </div>
      </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
  </body>
</html>
