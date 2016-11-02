<script>
$(document).on("keypress", 'form', function (e) {
            if (e.target.className.indexOf("allowEnter") == -1) {
                var code = e.keyCode || e.which;
                if (code == 13) {
                    e.preventDefault();
                    return false;
                }
            }
        });
</script>