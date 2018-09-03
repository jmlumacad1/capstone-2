<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Compiled and minified Materialize JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>

<!-- external js -->
<script type="text/javascript" src="assets/js/script.js"></script>


<script type="text/javascript">
  $(document).ready(function() {
    <?php function alert_message($str) { ?>
      <?php if (isset($_SESSION[$str])): ?>
        M.toast({html: '<?php echo $_SESSION[$str] ?>'});
        <?php unset($_SESSION[$str]) ?>
      <?php endif ?>
    <?php } ?>
    
    <?php 
        $events = ['login','register'];
        foreach ($events as $event) {
            alert_message('success_'.$event);
            alert_message('error_'.$event);
        }
    ?>

    let logged_in;
    <?php
    global $logged_in;
    if ($logged_in): ?>
      logged_in = true;
    <?php else: ?>
      logged_in = false;
    <?php endif ?>

    $('#btn-pay-paypal').click(function() {
      if (!logged_in) M.toast({html: 'Please login to continue.'});
      return logged_in;
    });
  });
</script>