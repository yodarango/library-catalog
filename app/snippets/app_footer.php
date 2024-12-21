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
<section class="bottom-menu border-top">
      <ul class="bottom-menu-list">
            <li class="bottom-menu_item browse <?php get_active_class("index") ?>"><a href="/"><i class="fa fa-home" aria-hidden="true"></i><span>Home</span></a></li>
            <li class="bottom-menu_item browse <?php get_active_class("coffeeshop") ?>"><a href="/coffeeshop"><i class="fa fa-coffee" aria-hidden="true"></i><span>Coffee shop</span></a></li>
            <?php if (is_admin()) { ?>
                  <li class="bottom-menu_item add <?php get_active_class("library") ?>"><a href="/library"><i class="fa fa-book" aria-hidden="true"></i><span>Library</span></a></li>
            <?php } ?>
            <li class="bottom-menu_item">
                  <?php if (logged_in()) { ?>
                        <a href="logout"><i class="fa fa-sign-out" aria-hidden="true"></i> <span>Log out</span></a>
                  <?php } else { ?>
                        <a href="login"><i class="fa fa-sign-in" aria-hidden="true"></i> <span>Log in</span></a>
                  <?php } ?>
            </li>
      </ul>
</section>
<footer class="app-footer">
</footer>
<?php ob_end_flush(); ?>
</body>

</html>