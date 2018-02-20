<?php
session_start();
session_unset();
session_destroy();
?>
<script language="javascript">
//window.close();
javascript:history.back(0);
</script>
<?php
header ("location: index.php"); 
?>
