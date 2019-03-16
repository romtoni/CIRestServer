<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mahasiswa');
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null)
        {
            $mahasiswa = $this->mahasiswa->getMahasiswa();     
            //var_dump($mahasiswa); 
        }
        else
        {
            $mahasiswa = $this->mahasiswa->getMahasiswa($id);     
            //var_dump($mahasiswa); 
        }

        if($mahasiswa)
        {
            $this->response([
                'status' => TRUE,
                'data' => $mahasiswa
            ], REST_Controller::HTTP_OK);
        }
        else
        {
            $this->response([
                'status' => FALSE,
                'message' => 'No data found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }


    public function index_delete()
    {
        $id = $this->delete('id');

        if($id === null)
        {
            $this->response([
                'status' => FALSE,
                'message' => "An ID required"
            ], REST_Controller::HTTP_BAD_REQUEST);
        } 
        else
        {
            if ($this->mahasiswa->deleteMahasiswa($id) > 0)
            {
                $this->response([
                    'status' => TRUE,
                    'id' => $id,
                    'message' => 'Data deleted succesfully'
                ], REST_Controller::HTTP_OK);
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'id not found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }


    public function index_post()
    {

        //urutannya harus sama dengan di tabel Mahasiswa
        $data = [
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')
        ];

        if ($this->mahasiswa->insertMahasiswa($data) > 0)
            {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Data inserted succesfully'
                ], REST_Controller::HTTP_CREATED);
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Failed to insert data'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
    }

    public function index_put()
    {

        $id = $this->put('id');

        //urutannya harus sama dengan di tabel Mahasiswa
        $data = [
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];

        if ($this->mahasiswa->updateMahasiswa($data, $id) > 0)
            {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Data updated succesfully'
                ], REST_Controller::HTTP_OK);
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Failed to update data'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
    }
}
