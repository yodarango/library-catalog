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

<section class="bottom-menu border-to border-epsilon border-top">
      <ul class="bottom-menu-list">
            <li class="bottom-menu_item browse <?php get_active_class("prayer") ?>"><a href="/admin-prayer"><i class="fa fa-list" aria-hidden="true"></i><span>Prayers</span></a></li>
            <li class="bottom-menu_item browse <?php get_active_class("library") ?>"><a href="/admin-library"><i class="fa fa-book" aria-hidden="true"></i><span>Library</span></a></li>
            <?php if (is_admin()) { ?>
                  <li class="bottom-menu_item add <?php get_active_class("coffeeshop") ?>"><a href="/admin-coffeeshop"><i class="fa fa-coffee" aria-hidden="true"></i><span>Coffeeshop</span></a></li>
            <?php } ?>
            <li class="bottom-menu_item">
                  <?php if (logged_in()) { ?>
                        <a href="logout"><i class="fa fa-sign-out" aria-hidden="true"></i> <span>Logout</span></a>
                  <?php } else { ?>
                        <a href="login"><i class="fa fa-sign-in" aria-hidden="true"></i> <span>Login</span></a>
                  <?php } ?>
            </li>
      </ul>
</section>
<?php ob_end_flush(); ?>
<footer class="footer">
</footer>
</body>

</html>