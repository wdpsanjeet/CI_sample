<html>
    <body>
<form id="redirectForm" method="post" action="<?php echo $action_url;?>">
    <input type="hidden" name="trip_date" value="<?php echo $trip_date;?>"/>
  </form>
<script>document.getElementById("redirectForm").submit();</script>
    </body>
</html>