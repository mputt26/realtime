<?php

//use Pusher\Pusher;

defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
    }

    function index()
    {
        $this->load->view('product/view');
    }

    function get_product()
    {
        $data = $this->Product_model->get_product()->result();
        echo json_encode($data);
    }

    function create()
    {
        $product_name   = $this->input->post('product_name', TRUE);
        $product_price  = $this->input->post('product_price', TRUE);

        $this->Product_model->insert_product($product_name, $product_price);

        require './vendor/autoload.php';
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            'd16c66bc60dcc28b5038',
            '31fd8578a4f1cc67a466',
            '1287107',
            $options
        );

        $data['message'] = 'success';
        $pusher->trigger('my-channel', 'my-event', $data);
    }

    function update()
    {
        $product_id   = $this->input->post('product_id', TRUE);
        $product_name   = $this->input->post('product_name', TRUE);
        $product_price  = $this->input->post('product_price', TRUE);

        $this->Product_model->update_product($product_id, $product_name, $product_price);

        require './vendor/autoload.php';

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            'd16c66bc60dcc28b5038',
            '31fd8578a4f1cc67a466',
            '1287107',
            $options
        );

        $data['message'] = 'success';
        $pusher->trigger('my-channel', 'my-event', $data);
    }

    function delete()
    {
        $product_id   = $this->input->post('product_id', TRUE);

        $this->Product_model->delete_product($product_id);

        require './vendor/autoload.php';

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            'd16c66bc60dcc28b5038',
            '31fd8578a4f1cc67a466',
            '1287107',
            $options
        );

        $data['message'] = 'success';
        $pusher->trigger('my-channel', 'my-event', $data);
    }
}
