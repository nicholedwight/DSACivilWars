<?php

namespace Controller;

class Base 
{
  /**
   * Render header method
   */
  public function renderHeader()
  {
    include 'views/templates/head.php';
  }
  /**
   * Render header method
   */
  public function renderFooter()
  {
    include 'views/templates/footer.php';
  }

  /**
   * Controller for 404 view
   * This view show when no page/view can be found
  */
  public function pageNotFound()
  {
    $this->renderHeader();
    include 'views/templates/404.php';
  }
}