<?php 
session_start();
session_unset();
session_destroy();

echo "<script>
        alert('ออกจากระบบแล้ว'); 
        window.location='index.php';
      </script>";
?>
