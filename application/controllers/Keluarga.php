<?php
/**
 *
 */
class Keluarga extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Keluarga');
		$this->load->model('M_Rukuntetangga');
	}

	public function index()
	{
		$data = array('title' => 'Sistem Informasi Warga',
					  'page' => 'Data Keluarga',
					  'tabel_title' => 'Tabel Data Keluarga',
					  'data_keluarga' => $this->M_Keluarga->tampil('keluarga')->result_array());
		$this->template->load_admin('dashboard','dash_data_c1',$data);
	}

	public function anggota_keluarga()
	{
		$id = $this->uri->segment(3);
		$data = array('title' => 'Sistem Informasi Warga',
					  'page' => 'Data Keluarga',
					  'tabel_title' => 'Tabel Data Keluarga',
					  'data_kk' => $this->M_Keluarga->tampil_perid('keluarga',$id)->row_array());
		$this->template->load_admin('dashboard','dash_data_keluarga',$data);
	}

	public function tambah()
	{
		$data = array('title' => 'Sistem Informasi Warga',
					  'page' => 'Data Keluarga',
					  'tabel_title' => 'Input Data Keluarga',
					  'data_rt' => $this->M_Rukuntetangga->tampil('rt')->result_array());
		$this->template->load_admin('dashboard','dash_input_keluarga',$data);
	}

	public function simpan()
	{
		$this->form_validation->set_rules('id_rt','RT','required');
		$this->form_validation->set_rules('nomor_kk','Nomor KK','required');
		$this->form_validation->set_rules('nama_kk','Nama Kepala Keluarga','required');
		$this->form_validation->set_rules('alamat_kk','Alamat','required');
		if ($this->form_validation->run() != false) {
			$data = array('id_rt' => $this->input->post('id_rt'),
						  'nomor_kk' => $this->input->post('nomor_kk'),
						  'nama_kk' => $this->input->post('nama_kk'),
						  'alamat_kk' => $this->input->post('alamat_kk'));

			$this->M_Keluarga->simpan('keluarga', $data);
			redirect('keluarga');
		}else{
			redirect('keluarga/tambah');
		}
	}

	public function edit()
	{
		$id = $this->uri->segment(3);
		$data = array('title' => 'Sistem Informasi Warga',
					  'page' => 'Data Keluarga',
					  'tabel_title' => 'Edit Data Keluarga',
					  'data_rt' => $this->M_Rukuntetangga->tampil('rt')->result_array(),
						'data_keluarga' => $this->M_Keluarga->tampil_relasi_perid('keluarga','rt',$id)->row_array());
		$this->template->load_admin('dashboard','dash_edit_keluarga',$data);

	}

	public function update()
	{
		$this->form_validation->set_rules('id_rt','RT','required');
		$this->form_validation->set_rules('nomor_kk','Nomor KK','required');
		$this->form_validation->set_rules('nama_kk','Nama Kepala Keluarga','required');
		$this->form_validation->set_rules('alamat_kk','Alamat','required');
		if ($this->form_validation->run() != false) {
			$where = array('id' => $this->input->post('id_kk'));
			$data = array('id_rt' => $this->input->post('id_rt'),
						  'nomor_kk' => $this->input->post('nomor_kk'),
						  'nama_kk' => $this->input->post('nama_kk'),
						  'alamat_kk' => $this->input->post('alamat_kk'));

			$this->M_Keluarga->update('keluarga', $data, $where);
			redirect('keluarga');
		}else{
			redirect('keluarga/edit');
		}
	}

	public function hapus()
	{
		$id = $this->uri->segment(3);
		$this->M_Keluarga->hapus('keluarga',$id);
		redirect('keluarga');
	}

	public function tambah_anggota_keluarga()
	{
		$id = $this->uri->segment(3);
		$data = array('title' => 'Sistem Informasi Warga',
					  'page' => 'Data Keluarga',
					  'tabel_title' => 'Input Anggota Keluarga');
		$this->template->load_admin('dashboard','dash_input_anggota',$data);	}

	public function simpan_anggota_keluarga()
	{
		//1

		$this->form_validation->set_rules('nik','Nomor Induk Kependudukan','required');
		$this->form_validation->set_rules('nama','Nama Lengkap','required');
		$this->form_validation->set_rules('tempat_lahir','Tempat Lahir','required');
		$this->form_validation->set_rules('tanggal_lahir','Tanggal Lahir','required');
		$this->form_validation->set_rules('jenis_kelamin','Jenis Kelamin','required');
		$this->form_validation->set_rules('agama','Agama','required');
		$this->form_validation->set_rules('pendidikan','Pendidikan','required');
		$this->form_validation->set_rules('golongan_darah','Golongan Darah','required');
		$this->form_validation->set_rules('pekerjaan','Pekerjaan','required');
		$this->form_validation->set_rules('status_keluarga','Status Keluarga','required');
		$this->form_validation->set_rules('kewarganegaraan','Kewarganegaraan','required');
		if ($this->form_validation->run() != false) {
			$data = array('nik' => $this->input->post('nik'),
						  'nama' => $this->input->post('nama'),
						  'tempat_lahir' => $this->input->post('tempat_lahir'),
						  'tanggal_lahir' => $this->input->post('tanggal_lahir'),
						  'jenis_kelamin' => $this->input->post('jenis_kelamin'),
						  'agama' => $this->input->post('agama'),
						  'pendidikan' => $this->input->post('pendidikan'),
						  'golongan_darah' => $this->input->post('golongan_darah'),
						  'pekerjaan' => $this->input->post('pekerjaan'),
						  'status_keluarga' => $this->input->post('status_keluarga'),
						  'kewarganegaraan' => $this->input->post('kewarganegaraan'),
						);

			$this->M_Keluarga->simpan('anggota_keluarga', $data);
			redirect('keluarga/anggota_keluarga/'.$this->input->post('id_kk'));
			//	redirect('keluarga');
		}else{
			redirect('keluarga/anggota_keluarga/'.$this->input->post('id_kk'));
		}


//
	}

	public function edit_anggota_keluarga()
	{
		$id = $this->uri->segment(3);
		$data = array('title' => 'Sistem Informasi Warga',
					  'page' => 'Data Keluarga',
					  'tabel_title' => 'Input Anggota Keluarga',
						'data_anggota' => 'kerjakan disini..... ');
		$this->template->load_admin('dashboard','dash_edit_anggota',$data);
	}

	public function update_anggota_keluarga()
	{
		//tambahkan skrip disini untuk update data anggota Keluarga

		redirect('keluarga/anggota_keluarga/'.$this->input->post('id_kk'));
	}

	public function hapus_anggota_keluarga()
	{
		//tambahkan skrip disini untuk menghapus data anggota Keluarga
		// jika penghapusan berhasil kembali ke halaman keluarga/anggota_keluarga


	}

}
