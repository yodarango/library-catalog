</div>
</section>
</main>
<?php
function get_active_class($page)
{
      $path = $_SERVER['REQUEST_URI'];
      if ($path == "/$page") {
            echo 'active';
      }
}


?>
<section class="bottom-menu">
      <ul class="bottom-menu-list">
            <li class="bottom-menu_item browse <?php get_active_class("admin") ?>"><a href="/admin"><i class="fa fa-home" aria-hidden="true"></i><span>Home</span></a></li>
            <li class="bottom-menu_item browse <?php get_active_class("admin-library") ?>"><a href="/admin-library"><i class="fa fa-book" aria-hidden="true"></i><span>Library</span></a></li>
            <li class="bottom-menu_item add <?php get_active_class("admin-coffeeshop") ?>"><a href="/admin-coffeeshop"><i class="fa fa-coffee" aria-hidden="true"></i><span>Cofeeshop</span></a></li>
            <li class="bottom-menu_item">
                  <?php if (logged_in()) { ?>
                        <a href="logout"><i class="fa fa-sign-out" aria-hidden="true"></i> <span><?php echo $lang['MENU_LOGOUT']; ?></span></a>
                  <?php } else { ?>
                        <a href="login"><i class="fa fa-sign-in" aria-hidden="true"></i> <span><?php echo $lang['MENU_LOGIN']; ?></span></a>
                  <?php } ?>
            </li>
      </ul>
</section>
<div style="height: 6rem"></div>
<footer class="footer">
</footer>
</body>

</html>