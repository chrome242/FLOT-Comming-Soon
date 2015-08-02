      
      
      <div class="footer"><!-- Site footer -->
        <p style>&copy; 2015 Finger Lakes On Tap</p>
      </div>
    </div><!-- /container -->
<?php if(isset($section) && ($section == ADMIN."Extras/")){echo PHP_EOL.'    <!-- Custom JS for the Extras Page. -->'. PHP_EOL;}?>
<?php if(isset($section) && ($section == ADMIN."Extras/")){echo'    <script type="text/javascript" src="/'.JAVASCRIPT .'hidden.toggle.js"></script>'. PHP_EOL;}?>
<?php if(isset($pageJavaScript)){echo PHP_EOL.'    <!-- Additional JS for the Page. -->'. PHP_EOL;}?>
<?php if(isset($pageJavaScript)){echo'    <script type="text/javascript" src="/'.JAVASCRIPT . $pageJavaScript .'.js"></script>'. PHP_EOL;}?>
  </body>
</html>