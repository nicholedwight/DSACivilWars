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
}