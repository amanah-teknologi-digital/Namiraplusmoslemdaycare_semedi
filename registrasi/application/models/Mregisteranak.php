<?php  

	class MRegisteranak extends CI_Model
	{
		public function __construct() {
			parent::__construct();

	        ## declate table name here
	        $this->table_name = 'registrasi_data_anak' ;
            $this->login = $this->session->userdata['auth'];
	    }

        function getListEducator(){
            $sql = "SELECT a.id, a.name as nama_educator
                FROM data_user a 
                WHERE a.id_role = 3 AND a.is_active = 1";
            $query = $this->db->query($sql);

            return $query->result();
        }

	    ## get all data in table
	    function getAll() {
            
	    	//$this->db->where('is_active','1');

            if($this->login->id_role == 4) {

                $this->db->where('id_orangtua', $this->login->id);                
            }
            $this->db->order_by('is_active', 'desc')->order_by('id', 'desc');
            $this->db->join('data_user', 'data_user.id = registrasi_data_anak.educator', 'left');
            $this->db->select('registrasi_data_anak.*, data_user.name as nama_educator');
	        $query = $this->db->get($this->table_name);

	        return $query->result();
		}

		## get all data in table for list (select)
	    function getList() {
	    	
	    	$this->db->where(array('is_active' => '1'));

	        $query = $this->db->get($this->table_name);

	        return $query->result();
		}

		## get data by id in table
	    function getByID($id) {
	        $this->db->where(array('id' => $id));
	        
	        $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

        ## get data by id in table
        function getByIDorangtua($id) {
            $this->db->where(array('id_orangtua' => $id));
            
            $query = $this->db->get($this->table_name);
            
            return $query->result();
        }

	    ## get column name in table
	    function getColumn() {

	        return $this->db->list_fields($this->table_name);
	    }

	    ## insert data into table
	    function insert() {
	        $a_input = array();
	       
	        foreach ($_POST as $key => $row) {
	            $a_input[$key] = $row;
	        }

	        $a_input['date_created'] = date('Y-m-d H:m:s');
	        $a_input['is_active']	 = '1';
            $a_input['id_orangtua']  = $this->login->id;

	        $this->db->insert($this->table_name, $a_input);

	        return $this->db->error();	        
	    }

	    ## update data in table
	    function update($id) {
	    	$_data = $this->input->post() ;
	    	
	        foreach ($_data as $key => $row) {
	            $a_input[$key] = $row;
	        }

	        $a_input['date_updated'] = date('Y-m-d H:m:s');	        

	        $this->db->where('id', $id);
	        
	        $this->db->update($this->table_name, $a_input);

	        return $this->db->error(1);	        
	    }

        function updatestatus($id) {
            $a_input['is_active'] = $_POST['status'];
	        $a_input['date_updated'] = date('Y-m-d H:m:s');

	        $this->db->where('id', $id);

	        $this->db->update($this->table_name, $a_input);

	        return $this->db->error(1);
	    }

	    ## delete data in table
		function delete($id) {
            $this->db->where('id', $id);

            $this->db->delete($this->table_name);

            return $this->db->affected_rows();
		}

		## get data by id in table
	    function getByKode($id) {
	        $this->db->where(array('kode' => $id));
	        
	        $query = $this->db->get($this->table_name);
	        
	        return $query->row();
	    }

        ## get data by id orang tua in table
        function getDetails($id_anak) {
            $this->db->where(
                array(
                    'registrasi_data_anak.id' => $id_anak,
                    'registrasi_data_anak.is_active' => 1,
                )
            );

            $this->db->select('
                registrasi_data_anak.*, 
                registrasi_data_berkas.upload_foto_anak
            ');

            $this->db->join('registrasi_data_berkas', 'registrasi_data_berkas.id_anak = registrasi_data_anak.id', 'left'); 
            
            $query = $this->db->get($this->table_name);
            
            return $query->row();
        }

	}

?>