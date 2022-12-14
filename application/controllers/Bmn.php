<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bmn extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Bmn_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/bmn/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/bmn/index/';
            $config['first_url'] = base_url() . 'index.php/bmn/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Bmn_model->total_rows($q);
        $bmn = $this->Bmn_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'bmn_data' => $bmn,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','bmn/tbl_bmn_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Bmn_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_bmn' => $row->id_bmn,
		'jenis_laporan' => $row->jenis_laporan,
		'keterangan' => $row->keterangan,
		'nama_file' => $row->nama_file,
	    );
            $this->template->load('template','bmn/tbl_bmn_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('bmn'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('bmn/create_action'),
	    'id_bmn' => set_value('id_bmn'),
	    'jenis_laporan' => set_value('jenis_laporan'),
	    'keterangan' => set_value('keterangan'),
	    'nama_file' => set_value('nama_file'),
	);
        $this->template->load('template','bmn/tbl_bmn_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'jenis_laporan' => $this->input->post('jenis_laporan',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'nama_file' => $this->input->post('nama_file',TRUE),
	    );

            $this->Bmn_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('bmn'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Bmn_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('bmn/update_action'),
		'id_bmn' => set_value('id_bmn', $row->id_bmn),
		'jenis_laporan' => set_value('jenis_laporan', $row->jenis_laporan),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'nama_file' => set_value('nama_file', $row->nama_file),
	    );
            $this->template->load('template','bmn/tbl_bmn_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('bmn'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_bmn', TRUE));
        } else {
            $data = array(
		'jenis_laporan' => $this->input->post('jenis_laporan',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'nama_file' => $this->input->post('nama_file',TRUE),
	    );

            $this->Bmn_model->update($this->input->post('id_bmn', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('bmn'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Bmn_model->get_by_id($id);

        if ($row) {
            $this->Bmn_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('bmn'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('bmn'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('jenis_laporan', 'jenis laporan', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('nama_file', 'nama file', 'trim|required');

	$this->form_validation->set_rules('id_bmn', 'id_bmn', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_bmn.xls";
        $judul = "tbl_bmn";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Laporan");
	xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama File");

	foreach ($this->Bmn_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis_laporan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_file);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_bmn.doc");

        $data = array(
            'tbl_bmn_data' => $this->Bmn_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('bmn/tbl_bmn_doc',$data);
    }

}

/* End of file Bmn.php */
/* Location: ./application/controllers/Bmn.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-09-05 10:35:18 */
/* http://harviacode.com */