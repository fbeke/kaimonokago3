<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MCustomers extends CI_Model
{



	function __construct()
    {
        parent::__construct();
	}

       
        
    function getCustomerByEmail($e)
    {
        $data = array();
        $options = array('email' => $e);
        $Q = $this->db->get_where('omc_customer',$options,1);
        if ($Q->num_rows() > 0)
        {
            $data = $Q->row_array();
        }
        $Q->free_result();
        return $data;
    }


	
    function checkCustomer($e)
    {
        $numrow = 0;
        $this->db->select('customer_id');
        $this->db->where('email',db_clean($e));
        $this->db->limit(1);
        $Q = $this->db->get('omc_customer');
        if ($Q->num_rows() > 0)
        {
            $numrow = TRUE;
            return $numrow;
        }
        else
        {
            $numrow = FALSE;
            return $numrow;
        }
    }
	
	

    function verifyCustomer($e,$pw)
    {
        $this->db->where('email',db_clean($e,50));
        $this->db->where('password', db_clean(do_hash($pw),16));
        $this->db->limit(1);
        $Q = $this->db->get('omc_customer');
        if ($Q->num_rows() > 0)
        {
            $row = $Q->row_array();
            $_SESSION['customer_id'] = $row['customer_id'];
            $_SESSION['customer_first_name'] = $row['customer_first_name'];
            $_SESSION['customer_last_name'] = $row['customer_last_name'];
            $_SESSION['phone_number'] = $row['phone_number'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['address'] = $row['address'];
            $_SESSION['city'] = $row['city'];
            $_SESSION['post_code'] = $row['post_code'];
            $_SESSION['country'] = $row['country'];
        }
        else
        {
                // $_SESSION['customer_id'] = 0; // this will eliminate error
        }
    }



    function checkOrphans($id)
    {
        $data = array();
        $this->db->where('customer_id',id_clean($id));
        $Q = $this->db->get('omc_order');
        if ($Q->num_rows() > 0)
        {
            foreach ($Q->result_array() as $key=>$row)
            {
                $data[$key] = $row;
            }
        $Q->free_result();
        return $data;
        }
    }


     /* moved to kaimonokago
	function getCustomer($id){
      $data = array();
      $options = array('customer_id' => id_clean($id));
      $Q = $this->db->get_where('omc_customer',$options,1);
      if ($Q->num_rows() > 0){
        $data = $Q->row_array();
      }
      $Q->free_result();
      return $data;
	}

         *
         */

        /**
         * used in MOrders
         * @param <type> $e
         * @return <type>
         */

        /* moved to kaimonokago
         * 
	function updateCustomer(){
      $data = array('customer_first_name' => db_clean($_POST['customer_first_name'],25),
					'customer_last_name' => db_clean($_POST['customer_last_name'],25),
					'phone_number' => db_clean($_POST['phone_number'],15),
                    'email' => db_clean($_POST['email'],50),
					'address' => db_clean($_POST['address'],50),
					'city' => db_clean($_POST['city'],25),
					'post_code' => db_clean($_POST['post_code'],10),
                    'password' => db_clean(do_hash($_POST['password']),16)
                    );
	  $this->db->where('customer_id',id_clean($_POST['customer_id']));
	  $this->db->update('omc_customer',$data);	
	
	}
	*/
    /*
	Not used, moved to kaimonokago/models/delete
     *
    function deleteCustomer($id){
        $this->db->where('customer_id', id_clean($id));
        $this->db->delete('omc_customer');
    }
     * 
     */

    /*
	Moved to Kaimonokago

    function getAllCustomers(){
        $data = array();
        $Q = $this->db->get('omc_customer');
        if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row;
        }
        }
        $Q->free_result();
        return $data;
    }

     *
     */

    /*
    *
    *
	function getCustomers(){
     $data = array();
     return $this->db->get('omc_customer');
	}
    */


        /* Let's move to kaimonokago
         *
         */

        /*  moved to kaimonokago
    function addCustomer(){
         $data = array(
            'customer_first_name' => db_clean($_POST['customer_first_name'],25),
            'customer_last_name' => db_clean($_POST['customer_last_name'],25),
            'phone_number' => db_clean($_POST['phone_number'],15),
            'email' => db_clean($_POST['email'],50),
            'address' => db_clean($_POST['address'],50),
            'city' => db_clean($_POST['city'],25),
            'post_code' => db_clean($_POST['post_code'],10),
            'password' => db_clean(do_hash($_POST['password']),16)
         );
              $this->db->insert('omc_customer',$data);
    }

         *
         */

    /*
        Not used
     * 
    function changeCustomerStatus($id){
        // getting status
        $userinfo = array();
        $userinfo = $this->getUser($id);
        $status = $userinfo['status'];
        if($status =='active'){
            $data = array('status' => 'inactive');
            $this->db->where('id', id_clean($id));
            $this->db->update('omc_customer', $data);
        }else{
            $data = array('status' => 'active');
            $this->db->where('id', id_clean($id));
            $this->db->update('omc_admin', $data);
        }
    }
     * 
     */	
}


?>