<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Spm_belanja_pegawai extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // is_login();
        $this->load->model('Spm_belanja_pegawai_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/spm_belanja_pegawai/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/spm_belanja_pegawai/index/';
            $config['first_url'] = base_url() . 'index.php/spm_belanja_pegawai/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Spm_belanja_pegawai_model->total_rows($q);
        $spm_belanja_pegawai = $this->Spm_belanja_pegawai_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'spm_belanja_pegawai_data' => $spm_belanja_pegawai,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','spm_belanja_pegawai/tbl_spm_belanja_pegawai_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Spm_belanja_pegawai_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_spmbp' => $row->id_spmbp,
		'no_spm' => $row->no_spm,
		'tgl_spm' => $row->tgl_spm,
		'uraian_spm' => $row->uraian_spm,
		'nilai_spm' => $row->nilai_spm,
		'nama_file' => $row->nama_file,
	    );
            $this->template->load('template','spm_belanja_pegawai/tbl_spm_belanja_pegawai_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('spm_belanja_pegawai'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('spm_belanja_pegawai/create_action'),
	    'id_spmbp' => set_value('id_spmbp'),
	    'no_spm' => set_value('no_spm'),
	    'tgl_spm' => set_value('tgl_spm'),
	    'uraian_spm' => set_value('uraian_spm'),
	    'nilai_spm' => set_value('nilai_spm'),
	    'nama_file' => set_value('nama_file'),
	);
        $this->template->load('template','spm_belanja_pegawai/tbl_spm_belanja_pegawai_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'no_spm' => $this->input->post('no_spm',TRUE),
		'tgl_spm' => $this->input->post('tgl_spm',TRUE),
		'uraian_spm' => $this->input->post('uraian_spm',TRUE),
		'nilai_spm' => $this->input->post('nilai_spm',TRUE),
		'nama_file' => $this->input->post('nama_file',TRUE),
	    );

            $this->Spm_belanja_pegawai_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('spm_belanja_pegawai'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Spm_belanja_pegawai_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('spm_belanja_pegawai/update_action'),
		'id_spmbp' => set_value('id_spmbp', $row->id_spmbp),
		'no_spm' => set_value('no_spm', $row->no_spm),
		'tgl_spm' => set_value('tgl_spm', $row->tgl_spm),
		'uraian_spm' => set_value('uraian_spm', $row->uraian_spm),
		'nilai_spm' => set_value('nilai_spm', $row->nilai_spm),
		'nama_file' => set_value('nama_file', $row->nama_file),
	    );
            $this->template->load('template','spm_belanja_pegawai/tbl_spm_belanja_pegawai_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('spm_belanja_pegawai'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_spmbp', TRUE));
        } else {
            $data = array(
		'no_spm' => $this->input->post('no_spm',TRUE),
		'tgl_spm' => $this->input->post('tgl_spm',TRUE),
		'uraian_spm' => $this->input->post('uraian_spm',TRUE),
		'nilai_spm' => $this->input->post('nilai_spm',TRUE),
		'nama_file' => $this->input->post('nama_file',TRUE),
	    );

            $this->Spm_belanja_pegawai_model->update($this->input->post('id_spmbp', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('spm_belanja_pegawai'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Spm_belanja_pegawai_model->get_by_id($id);

        if ($row) {
            $this->Spm_belanja_pegawai_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('spm_belanja_pegawai'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('spm_belanja_pegawai'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_spm', 'no spm', 'trim|required');
	$this->form_validation->set_rules('tgl_spm', 'tgl spm', 'trim|required');
	$this->form_validation->set_rules('uraian_spm', 'uraian spm', 'trim|required');
	$this->form_validation->set_rules('nilai_spm', 'nilai spm', 'trim|required');
	$this->form_validation->set_rules('nama_file', 'nama file', 'trim|required');

	$this->form_validation->set_rules('id_spmbp', 'id_spmbp', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_spm_belanja_pegawai.xls";
        $judul = "tbl_spm_belanja_pegawai";
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
	xlsWriteLabel($tablehead, $kolomhead++, "No Spm");
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl Spm");
	xlsWriteLabel($tablehead, $kolomhead++, "Uraian Spm");
	xlsWriteLabel($tablehead, $kolomhead++, "Nilai Spm");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama File");

	foreach ($this->Spm_belanja_pegawai_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_spm);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl_spm);
	    xlsWriteLabel($tablebody, $kolombody++, $data->uraian_spm);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nilai_spm);
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
        header("Content-Disposition: attachment;Filename=tbl_spm_belanja_pegawai.doc");

        $data = array(
            'tbl_spm_belanja_pegawai_data' => $this->Spm_belanja_pegawai_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('spm_belanja_pegawai/tbl_spm_belanja_pegawai_doc',$data);
    }

}

/* End of file Spm_belanja_pegawai.php */
/* Location: ./application/controllers/Spm_belanja_pegawai.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-09-05 08:52:41 */
/* http://harviacode.com */