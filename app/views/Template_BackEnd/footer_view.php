<script type="text/javascript">
    $(document).ready(function () {

        $(".select2").select2();
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        //Tree Grid
        $('.TreeGrid').treegrid({
            expanderExpandedClass: 'glyphicon glyphicon-minus',
            expanderCollapsedClass: 'glyphicon glyphicon-plus',
            initialState: 'collapsed'
        });

        var pluginURL = '<?php echo SITE_PLUGINS; ?>';
        $('textarea').each(function () {
            if (!$(this).hasClass('nock')) {
                var id = $(this).attr('id');
                CKEDITOR.replace(id, {
                    filebrowserBrowseUrl: '/browser/browse.php',
                    filebrowserImageBrowseUrl: '/browser/browse.php?type=Images',
                    filebrowserUploadUrl: '/uploader/upload.php',
                    filebrowserImageUploadUrl: '/uploader/upload.php?type=Images',
                    filebrowserWindowWidth: '900',
                    filebrowserWindowHeight: '400',
                    filebrowserBrowseUrl: pluginURL + '/ckfinder/ckfinder.html',
                            filebrowserImageBrowseUrl: pluginURL + '/ckfinder/ckfinder.html?Type=Images',
                            filebrowserFlashBrowseUrl: pluginURL + '/ckfinder/ckfinder.html?Type=Flash',
                    filebrowserUploadUrl: pluginURL + '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                            filebrowserImageUploadUrl: pluginURL + '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                            filebrowserFlashUploadUrl: pluginURL + '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                });
            }
        });

    });
</script>
<!-- FOOTER -->
<footer class="main-footer">
    <strong>Copyright &copy; 2015 <a href="<?php echo SITE_URL; ?>/Admin/Panel">Shuttle E-Ticaret Yönetim Paneli</a></strong> - Tüm hakları saklıdır.
</footer>
<!-- /FOOTER -->
</div><!-- ./wrapper -->
</body>
</html>
