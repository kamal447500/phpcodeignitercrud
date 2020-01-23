<?php

	class Home extends CI_Controller {

	    public function index()
	    {
	    	$this->load->model('Crudmodel');
	    	$records = $this->Crudmodel->getRecords(); 

	        $this->load->view('home', ['records'=>$records]);
	    }

	    public function Create()
	    {
	    	$this->load->view('create');
	    }

	    public function save(){

			$this->form_validation->set_rules('customerName','CustomerName', 'required', array('required' => 'You must provide a %s.'));
			$this->form_validation->set_rules('phone','Phone', 'required', array('required' => 'You must provide a %s.'));
			$this->form_validation->set_rules('address','Address', 'required', array('required' => 'You must provide a %s.'));
			$this->form_validation->set_rules('city','City', 'required', array('required' => 'You must provide a %s.'));
			$this->form_validation->set_rules('country','Country', 'required', array('required' => 'You must provide a %s.'));
			$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
			if( $this->form_validation->run() )
			{
				$data = $this->input->post();
				$this->load->model('Crudmodel');
				if( $this->Crudmodel->saveRecord( $data ) ){
					$this->session->set_flashdata('response','Record Saved Successfully.');
				}			
				else
				{
					$this->session->set_flashdata('response','Record Not Saved.');
				}
				return redirect('home');
			} 
			else
			{
				$this->load->view('create');
			}
		}

		public function edit( $record_id ){
			$this->load->model('Crudmodel');
			$record = $this->Crudmodel->getAllRecords( $record_id );
			$this->load->view('update', ['record'=>$record]);
		}    

		public function update( $record_id ){
			$this->form_validation->set_rules('customerName','CustomerName', 'required');
			$this->form_validation->set_rules('phone','Phone', 'required');
			$this->form_validation->set_rules('address','Address', 'required');
			$this->form_validation->set_rules('city','City', 'required');
			$this->form_validation->set_rules('country','Country', 'required');
			$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
			if( $this->form_validation->run() )
			{
				$data = $this->input->post();
				$this->load->model('Crudmodel');
				if( $this->Crudmodel->updateRecords( $record_id, $data ) ){
					$this->session->set_flashdata('response','Record Updated Successfully.');
				}			
				else
				{
					$this->session->set_flashdata('response','Record Not update.');
				}
				return redirect('home');
			} 
			else
			{
				$this->load->view('update');
			}
		}

		public function delete( $record_id ){
			$this->load->model('Crudmodel');
			if( $this->Crudmodel->deleteRecords( $record_id ) ){
				$this->session->set_flashdata('response','Record Deleted Successfully.');
			}
			else{
				$this->session->set_flashdata('response','Failed to Delete Record.');				
			}
			return redirect('home');
		}

	}
?>