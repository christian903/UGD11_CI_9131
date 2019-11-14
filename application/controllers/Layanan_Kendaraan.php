<?php
use Restserver \Libraries\REST_Controller ;
Class Layanan_Kendaraan extends REST_Controller{
    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->model('LayananKendaraanModel');
        $this->load->library('form_validation');
    }
    public function index_get(){
        return $this->returnData($this->db->get('services')->result(), false);
    }
    public function index_post($id = null){
        $validation = $this->form_validation;
        $rule = $this->LayananKendaraanModel->rules();
        // if($id == null){
        //     array_push($rule,[
        //             'field' => 'password',
        //             'label' => 'password',
        //             'rules' => 'required'
        //         ],
        //         [
        //             'field' => 'email',
        //             'label' => 'email',
        //             'rules' => 'required|valid_email|is_unique[users.email]'
        //         ]
        //     );
        // }
        // else{
        //     array_push($rule,
        //         [
        //             'field' => 'email',
        //             'label' => 'email',
        //             'rules' => 'required|valid_email'
        //         ]
        //     );
        // }
        $validation->set_rules($rule);
		if (!$validation->run()) {
			return $this->returnData($this->form_validation->error_array(), true);
        }
        $services = new KendaraanData();
        $services->nama = $this->post('nama');
        $services->biaya = $this->post('biaya');
        $services->jenis = $this->post('jenis');
        $services->tanggal = $this->post('tanggal');
        if($id == null){
            $response = $this->LayananKendaraanModel->store($services);
        }else{
            $response = $this->LayananKendaraanModel->update($services,$id);
        }
        return $this->returnData($response['msg'], $response['error']);
    }
    public function index_delete($id = null){
        if($id == null){
			return $this->returnData('Parameter Id Tidak Ditemukan', true);
        }
        $response = $this->LayananKendaraanModel->destroy($id);
        return $this->returnData($response['msg'], $response['error']);
    }
    public function returnData($msg,$error){
        $response['error']=$error;
        $response['message']=$msg;
        return $this->response($response);
    }
}
Class KendaraanData{
    public $nama;
    public $biaya;
    public $jenis;
    public $tanggal;
}