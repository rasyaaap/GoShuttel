<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

	public function index()
	{
		$this->load->model('Operational_model');
		$this->load->model('Settings_model');
		$this->load->model('News_model');
		$this->load->model('Gallery_model');
		
		$data['rute'] = $this->Operational_model->get_all_rute();
		$data['hero'] = $this->Settings_model->get_all_settings();
		$data['news'] = $this->News_model->get_recent(3);
		$data['gallery'] = $this->Gallery_model->get_recent(6);
		
		$this->load->view('landing/index', $data);
	}
    
    // ... existing submit_complaint ...

    public function gallery()
    {
        $this->load->model('Gallery_model');
        $data['gallery'] = $this->Gallery_model->get_all();
        $this->load->view('landing/gallery', $data);
    }

    public function submit_complaint()
    {
        $this->load->model('Complaint_model');
        
        $data = [
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'subject' => $this->input->post('subject'),
            'message' => $this->input->post('message'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        if($this->Complaint_model->insert($data)) {
            $this->session->set_flashdata('success', 'Keluhan Anda telah terkirim. Tim kami akan segera menghubungi Anda.');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengirim keluhan. Silakan coba lagi.');
        }
        redirect('/#contact'); 
    }

    public function news()
    {
        $this->load->model('News_model');
        $data['news'] = $this->News_model->get_all(); 
        $this->load->view('landing/news', $data);
    }
    
    public function news_detail($id)
    {
        $this->load->model('News_model');
        $data['news'] = $this->News_model->get_by_id($id);
        $data['recent_news'] = $this->News_model->get_recent(5); // Fetch 5 recent news for sidebar
        if(!$data['news']) show_404();
        $this->load->view('landing/news_detail', $data);
    }
}
