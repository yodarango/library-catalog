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
<section class="coffeeshop-menu">
      <ul class="coffeeshop-menu-list">
            <li class="coffeeshop-menu_item browse <?php get_active_class("index") ?>"><a href="/"><i class="fa fa-home" aria-hidden="true"></i><span>Home</span></a></li>
            <li class="coffeeshop-menu_item browse <?php get_active_class("coffeeshop") ?>"><a href="/coffeeshop"><i class="fa fa-coffee" aria-hidden="true"></i><span>Shop</span></a></li>
            <?php if (is_admin()) { ?>
                  <li class="coffeeshop-menu_item add <?php get_active_class("orders") ?>"><a href="/admin-coffeeshop"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Orders</span></a></li>
            <?php } ?>
            <li class="coffeeshop-menu_item">
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