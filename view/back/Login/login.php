<?php

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