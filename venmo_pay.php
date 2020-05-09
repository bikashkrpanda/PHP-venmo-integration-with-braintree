<button type="button" id="venmo-button" style="background:white;border-bottom: none;"><img style="border-radius: 20px;" src="https://s2.r29static.com/bin/entry/1f8/0,0,2000,1050/x,80/1986150/image.jpg" height="50px" width="100px"></button>
<script src="https://js.braintreegateway.com/web/3.57.0/js/client.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.57.0/js/venmo.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.57.0/js/data-collector.min.js"></script>
<script>
var venmoButton = document.querySelector('#venmo-button');
    // Create a client.
    braintree.client.create({
      authorization: 'sandbox_s9hw272b_dgg5x66vptdfnbtb'
    }, function (clientErr, clientInstance) {
      // Stop if there was a problem creating the client.
      // This could happen if there is a network error or if the authorization
      // is invalid.
      console.log("clientInstance:",clientInstance);
      if (clientErr) {
        console.error('Error creating client:', clientErr);
        return;
      }
    
      braintree.dataCollector.create({
        client: clientInstance,
        paypal: true
      }, function (dataCollectorErr, dataCollectorInstance) {
        if (dataCollectorErr) {
          // Handle error in creation of data collector.
          console.log(dataCollectorErr);
          return;
        }
    
        // At this point, you should access the deviceData value and provide it
        // to your server, e.g. by injecting it into your form as a hidden input.
        console.log('dataCollectorInstance:', dataCollectorInstance);
        console.log('Got device data:', dataCollectorInstance.deviceData);
       
      });
    
        
      function displayVenmoButton(venmoInstance) {
      // Assumes that venmoButton is initially display: none.
      venmoButton.style.display = 'block';
      venmoButton.addEventListener('click', function () {
        venmoButton.disabled = true;
        
        venmoInstance.tokenize(function (tokenizeErr, payload) {
          venmoButton.removeAttribute('disabled');
    
          if (tokenizeErr) {
            handleVenmoError(tokenizeErr);
          } else {
            handleVenmoSuccess(payload);
          }
        });
      });
    }
    
    function handleVenmoError(err) {
      if (err.code === 'VENMO_CANCELED') {
        console.log('App is not available or user aborted payment flow');
      } else if (err.code === 'VENMO_APP_CANCELED') {
        console.log('User canceled payment flow');
      } else {
        console.error('An error occurred:', err.message);
      }
    }
      braintree.venmo.create({
        client: clientInstance,
        // Add allowNewBrowserTab: false if your checkout page does not support
        // relaunching in a new tab when returning from the Venmo app. This can
        // be omitted otherwise.
        allowNewBrowserTab: false
      }, function (venmoErr, venmoInstance) {
        if (venmoErr) {
          console.error('Error creating Venmo:', venmoErr);
          return;
        }
        console.log("venmoInstance:",venmoInstance);
        // Verify browser support before proceeding.
        if (!venmoInstance.isBrowserSupported()) {
          console.log('Browser does not support Venmo');
          return;
        }
        displayVenmoButton(venmoInstance);
    
        // Check if tokenization results already exist. This occurs when your
        // checkout page is relaunched in a new tab. This step can be omitted
        // if allowNewBrowserTab is false.
        if (venmoInstance.hasTokenizationResult()) {
          venmoInstance.tokenize(function (tokenizeErr, payload) {
            if (err) {
              handleVenmoError(tokenizeErr);
            } else {
              handleVenmoSuccess(payload);
            }
          });
          return;
        }
      });
    });
    
    
    function handleVenmoSuccess(payload) {
      // Send the payment method nonce to your server, e.g. by injecting
      // it into your form as a hidden input.
      console.log('Got a payment method nonce:', payload.nonce);
      // Display the Venmo username in your checkout UI.
      console.log('Venmo user:', payload.details.username);
        var amount = 1;
        //test nonce for venmo
        payload_nonce = "fake-venmo-account-nonce";
        var payerID = payload_nonce;//payload.nonce;
        var deviceDataToken = '{"correlation_id":"bc850bc0840ab2d9e1d34842d0e3ffa5"}';
        var deviceData = encodeURI(deviceDataToken);
        
        window.location = "/paypalWithBraintree/venmo_server.php/?payerID=" + payerID + "&deviceData=" + deviceData+ "&amount=" + amount;
    }
    
</script>