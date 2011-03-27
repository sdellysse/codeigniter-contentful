<?php
class ContentfulTest extends CI_Controller {
  public function index() {
    $this->load->library('Contentful');
    $this->name = 'shawn';
    $this->contentful->load();
  }
}
