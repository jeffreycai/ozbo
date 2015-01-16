<?php

if (!is_cli()) {
  HTML::registerHeaderLower('<link rel="stylesheet" href="' . uri('modules/outdated-browser/assets/libraries/outdated-browser/outdatedbrowser/outdatedbrowser.min.css', false) . '">');
  HTML::registerFooterUpper('<div id="outdated"></div>');
  HTML::registerFooterLower('<script src="' . uri('modules/outdated-browser/assets/libraries/outdated-browser/outdatedbrowser/outdatedbrowser.min.js', false) . '"></script>');
  HTML::registerFooterLower('
<script type="text/javascript">
$( document ).ready(function() {
    outdatedBrowser({
        bgColor: "#f25648",
        color: "#ffffff",
        lowerThan: "boxShadow", // Lower Than (<): "IE11","borderImage" | "IE10", "transform" (Default property) | "IE9", "boxShadow" | "IE8", "borderSpacing"
        languagePath: "' . uri('modules/outdated-browser/assets/libraries/outdated-browser/outdatedbrowser/lang/' . get_language() . '.html', false) . '"
    })
})
</script>

');
}