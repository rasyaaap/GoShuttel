<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends CI_Controller {

	public function index()
	{
        $this->load->model('Operational_model');
        // Fetch full schedule with route details
        $data['jadwal'] = $this->Operational_model->get_all_jadwal();

		$this->load->view('landing/jadwal', $data);
	}
}
