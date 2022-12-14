<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Zibirokrasi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //is_login();
        $this->load->model('Zibirokrasi_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/zibirokrasi/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/zibirokrasi/index/';
            $config['first_url'] = base_url() . 'index.php/zibirokrasi/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Zibirokrasi_model->total_rows($q);
        $zibirokrasi = $this->Zibirokrasi_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'zibirokrasi_data' => $zibirokrasi,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','zibirokrasi/tbl_zibirokrasi_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Zibirokrasi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_zibirokrasi' => $row->id_zibirokrasi,
		'no_dokumen' => $row->no_dokumen,
		'judul' => $row->judul,
		'tgl_upload' => $row->tgl_upload,
		'id_kategori' => $row->id_kategori,
		'nama_file' => $row->nama_file,
	    );
            $this->template->load('template','zibirokrasi/tbl_zibirokrasi_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('zibirokrasi'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('zibirokrasi/create_action'),
	    'id_zibirokrasi' => set_value('id_zibirokrasi'),
	    'no_dokumen' => set_value('no_dokumen'),
	    'judul' => set_value('judul'),
	    'tgl_upload' => set_value('tgl_upload'),
	    'id_kategori' => set_value('id_kategori'),
	    'nama_file' => set_value('nama_file'),
	);
        $this->template->load('template','zibirokrasi/tbl_zibirokrasi_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
        $zibirokrasi = $this->upload_filezibirokrasi();
        // echo "<pre>";
        // print_r ($kepskhakim);
        // die;
        // echo "</pre>";


        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'no_dokumen' => $this->input->post('no_dokumen',TRUE),
		'judul' => $this->input->post('judul',TRUE),
		'tgl_upload' => $this->input->post('tgl_upload',TRUE),
		'id_kategori' => $this->input->post('id_kategori',TRUE),
		// 'nama_file' => $this->input->post('nama_file',TRUE),
        'nama_file'     => $zibirokrasi['file_name'],
	    );

            $this->Zibirokrasi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('zibirokrasi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Zibirokrasi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('zibirokrasi/update_action'),
		'id_zibirokrasi' => set_value('id_zibirokrasi', $row->id_zibirokrasi),
		'no_dokumen' => set_value('no_dokumen', $row->no_dokumen),
		'judul' => set_value('judul', $row->judul),
		'tgl_upload' => set_value('tgl_upload', $row->tgl_upload),
		'id_kategori' => set_value('id_kategori', $row->id_kategori),
		'nama_file' => set_value('nama_file', $row->nama_file),
	    );
            $this->template->load('template','zibirokrasi/tbl_zibirokrasi_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('zibirokrasi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
        $zibirokrasi = $this->upload_filezibirokrasi();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_zibirokrasi', TRUE));
        } else {
            $data = array(
		'no_dokumen' => $this->input->post('no_dokumen',TRUE),
		'judul' => $this->input->post('judul',TRUE),
		'tgl_upload' => $this->input->post('tgl_upload',TRUE),
		'id_kategori' => $this->input->post('id_kategori',TRUE),
		// 'nama_file' => $this->input->post('nama_file',TRUE),
        'nama_file'     => $zibirokrasi['file_name'],
	    );

            $this->Zibirokrasi_model->update($this->input->post('id_zibirokrasi', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('zibirokrasi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Zibirokrasi_model->get_by_id($id);

        if ($row) {
            $this->Zibirokrasi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('zibirokrasi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('zibirokrasi'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_dokumen', 'no dokumen', 'trim|required');
	$this->form_validation->set_rules('judul', 'judul', 'trim|required');
	$this->form_validation->set_rules('tgl_upload', 'tgl upload', 'trim|required');
	$this->form_validation->set_rules('id_kategori', 'id kategori', 'trim|required');
	// $this->form_validation->set_rules('nama_file', 'nama file', 'trim|required');

	$this->form_validation->set_rules('id_zibirokrasi', 'id_zibirokrasi', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_zibirokrasi.xls";
        $judul = "tbl_zibirokrasi";
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
	xlsWriteLabel($tablehead, $kolomhead++, "No Dokumen");
	xlsWriteLabel($tablehead, $kolomhead++, "Judul");
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl Upload");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Kategori");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama File");

	foreach ($this->Zibirokrasi_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_dokumen);
	    xlsWriteLabel($tablebody, $kolombody++, $data->judul);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl_upload);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_kategori);
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
        header("Content-Disposition: attachment;Filename=tbl_zibirokrasi.doc");

        $data = array(
            'tbl_zibirokrasi_data' => $this->Zibirokrasi_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('zibirokrasi/tbl_zibirokrasi_doc',$data);
    }

    function upload_filezibirokrasi(){
        $config['upload_path']          = './assets/file_zibirokrasi';
        $config['allowed_types']        = 'gif|jpg|png|pdf|doc|docx|zip|rar';
        $config['max_size']             = 2000;
        //$config['max_width']            = 1024;
        //$config['max_height']           = 768;
        $this->load->library('upload', $config);
        $this->upload->do_upload('nama_file');
        return $this->upload->data();
    }

}

/* End of file Zibirokrasi.php */
/* Location: ./application/controllers/Zibirokrasi.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-07-20 08:29:32 */
/* http://harviacode.com */