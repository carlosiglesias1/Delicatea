<?php
if (isset($_POST['submit'])) {
    if (session_status() == PHP_SESSION_ACTIVE) {
        session_destroy();
    }
    $name = $_POST['username'];
    $password = "";
    if (isset($_POST["password"]))
        $password = substr(hash("sha512", $_POST['password']), 0, 50);
    try {
        logIn($name, $password);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<body>
    <div class="cabecera"></div>
    <div class="contenedor">
        <div class="modal abrir" id="modal"></div>
    </div>
</body>

</html>
<script>
    $(document).ready(
        function() {
            $.ajax({
                url: "<?= $_SESSION['INDEX_PATH'] ?>" + "Includes/modal.php?modo=1",
                success: function(data) {
                    $('#modal').html(data);
                }
            })
        }
    );
</script>