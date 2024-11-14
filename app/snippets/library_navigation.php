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
            <li class="library-menu_item browse <?php get_active_class("index") ?>"><a href="./index"><i class="fa fa-book" aria-hidden="true"></i><span><?php echo $lang['MENU_BROWSE']; ?></span></a></li>
            <li class="library-menu_item add <?php get_active_class("add") ?>"><a href="./add"><i class="fa fa-plus" aria-hidden="true"></i><span><?php echo $lang['MENU_ADD']; ?></span></a></li>
            <li class="library-menu_item authors <?php get_active_class("authors") ?>"><a href="./authors"><i class="fa fa-users" aria-hidden="true"></i><span><?php echo $lang['MENU_AUTHORS']; ?></span></a></li>
            <li class="library-menu_item publishers <?php get_active_class("publishers") ?>"><a href="./publishers"><i class="fa fa-building" aria-hidden="true"></i><span><?php echo $lang['MENU_PUBLISHERS']; ?></span></a></li>
            <li class="library-menu_item genres <?php get_active_class("genres") ?>"><a href="./genres"><i class="fa fa-tags" aria-hidden="true"></i><span><?php echo $lang['MENU_GENRES']; ?></span></a></li>
            <li class="library-menu_item lent <?php get_active_class("lent") ?>"><a href="./display?lent=on"><i class="fa fa-handshake-o" aria-hidden="true"></i><span><?php echo $lang['MENU_LENT']; ?></span></a></li>
            <li class="library-menu_item">
                  <a href=" logout"><i class="fa fa-sign-out" aria-hidden="true"></i> <span><?php echo $lang['MENU_LOGOUT']; ?></span></a>
            </li>
      </ul>
</section>