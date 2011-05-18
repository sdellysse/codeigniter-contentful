<?php
class ContentfulTest extends CI_Controller {
    public function index () {
        $this->load->library('Contentful');

        $data['name'] = 'Shawn Dellysse';
        $this->contentful->load('contentful_test/index', $data);
    }
}
