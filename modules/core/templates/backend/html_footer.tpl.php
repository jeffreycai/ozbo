<script type="text/javascript">
  var site = jQuery();
  site.settings = <?php echo HTML::renderSettingsInJson() ?>;
  site.settings.subroot = '<?php echo get_sub_root(); ?>';
</script>

<?php HTML::renderOutFooterUpperRegistry(); ?>
<?php Asset::printBottomAssets('backend'); ?>
<?php HTML::renderOutFooterLowerRegistry(); ?>
</body>

</html>
