<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Global_model extends CI_Model {

	function save_to_db($name,$mark)
	{
		$arr = [
		'name' => $name,
		'mark' => $mark
		];
		$this->db->insert('es_tbl', $arr);
	}

}

/* End of file Global_model.php */
/* Location: ./application/models/Global_model.php */