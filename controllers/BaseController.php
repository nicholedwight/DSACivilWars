<?php

/**
 * Renders header and footer and deals with 404s.
 *
 * This controller contains functions for rendering
 * header and footers which are located in the views/templates
 * folder. Also contains a function for displaying the 404
 * page for when a page cannot be found.
 */

namespace Controller;

class Base
{
  /**
   * Function for including the header which is located
   * in the views/templates folder.
   * @param string $battles Battles data rendered in header.
   */
  public function renderHeader($battles)
  {
    include 'views/templates/head.php';
  }
  /**
   * Function for including the footer which is located
   * in the views/templates folder.
   */
  public function renderFooter($battles)
  {
    include 'views/templates/footer.php';
  }

  /**
   * Function for including the 404 page which is located
   * in the views/templates folder.
  */
  public function pageNotFound()
  {
    $this->renderHeader();
    include 'views/templates/404.php';
  }
}
