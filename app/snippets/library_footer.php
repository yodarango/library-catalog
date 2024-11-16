</div>
</section>
</main>
<?php
function get_active_class($page)
{
      $path = $_SERVER['REQUEST_URI'];
      if (strpos($path, $page)) {
            echo 'active';
      }
}


?>
<section class="library-menu">
      <ul class="library-menu-list">
            <li class="library-menu_item browse <?php get_active_class("library") ?>"><a href="/library"><i class="fa fa-book" aria-hidden="true"></i><span><?php echo $lang['MENU_BROWSE']; ?></span></a></li>
            <?php if (is_admin()) { ?>
                  <li class="library-menu_item add <?php get_active_class("add") ?>"><a href="/add"><i class="fa fa-plus" aria-hidden="true"></i><span><?php echo $lang['MENU_ADD']; ?></span></a></li>
            <?php } ?>
            <li class="library-menu_item">
                  <?php if (logged_in()) { ?>
                        <a href="logout"><i class="fa fa-sign-out" aria-hidden="true"></i> <span><?php echo $lang['MENU_LOGOUT']; ?></span></a>
                  <?php } else { ?>
                        <a href="login"><i class="fa fa-sign-in" aria-hidden="true"></i> <span><?php echo $lang['MENU_LOGIN']; ?></span></a>
                  <?php } ?>
            </li>
      </ul>
</section>
<footer class="footer">
</footer>
</body>

</html>