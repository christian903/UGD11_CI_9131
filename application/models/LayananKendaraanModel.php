<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LayananKendaraanModel extends CI_Model
{
    private $table = 'services';


    public $id;
    public $nama;
    public $biaya;
    public $jenis;
    public $tanggal;
    public $rule = [ 
        [
            'field' => 'nama',
            'label' => 'nama',
            'rules' => 'required'
        ],
    ];
    public function Rules() { return $this->rule; }
   

    public function getAll() { return 
        $this->db->get('data_mahasiswa')->result(); 
    } 
    public function store($request) { 
        $this->nama = $request->nama; 
        $this->biaya = $request->biaya;
        $this->jenis = $request->jenis;
        $this->tanggal = date('y-m-d H:i:s'); 
      //  $this->password = password_hash($request->password, PASSWORD_BCRYPT); 
        if($this->db->insert($this->table, $this)){
            return ['msg'=>'Berhasil','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function update($request,$id) { 
        $updateData = ['nama' => $request->nama, 'biaya' =>$request->biaya, 'jenis' =>$request->jenis, 'tanggal' =>date('y-m-d H:i:s')];
        if($this->db->where('id',$id)->update($this->table, $updateData)){
            return ['msg'=>'Berhasil','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function destroy($id){
        if (empty($this->db->select('*')->where(array('id' => $id))->get($this->table)->row())) return ['msg'=>'Id tidak ditemukan','error'=>true];
        
        if($this->db->delete($this->table, array('id' => $id))){
            return ['msg'=>'Berhasil','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
}
?>