<?php
class ContentfulTest extends CI_Controller {
  public function index() {
    $this->load->library('Contentful');
    $this->name = 'Shawn Dellysse';
    $this->contentful->load();
  }
}
