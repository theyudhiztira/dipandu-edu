<?php
session_start();
session_destroy();

echo "<script>
    alert('Account Logged Out.');
    location.replace('./');
</script>";

?>