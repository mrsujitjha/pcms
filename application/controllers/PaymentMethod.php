<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PaymentMethod extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Financial', 'finance');
    }

    public function index()
    {
        $data['content'] = "v_payment_accept";
        $data['getPayList'] = $this->db->order_by('cid', 'DESC')->get('tabpaycon')->result();
        $this->load->view('template', $data);
    }

    public function view($cid)
    {
        $payment = $this->get_by_id($cid);

        if ($payment) {
            echo json_encode([
                'status' => 'success',
                'data' => [
                    'payment_name' => $payment->pname,
                    'description'  => $payment->detail,
                    'logic'        => $payment->logic,
                ]
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Payment record not found.'
            ]);
        }
    }

    

    public function get_by_id($cid)
    {
        return $this->db->get_where('tabpaycon', ['cid' => $cid])->row();
    }

    public function save()
    {
        $pname   = $this->input->post('pname');
        $details = $this->input->post('details');
        $logic   = $this->input->post('logic');

        $data = [
            'pname' => $pname,
            'detail'  => $details,
            'logic'        => $logic
        ];

        $inserted = $this->db->insert('tabpaycon', $data);

        if ($inserted) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save payment.']);
        }
    }

    public function edit($cid)
    {
        $payment = $this->db->get_where('tabpaycon', ['cid' => $cid])->row();

        if ($payment) {
            echo json_encode(['status' => 'success', 'data' => $payment]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Payment not found.']);
        }
    }

    public function update()
    {
        $cid     = $this->input->post('cid');
        $pname   = $this->input->post('pname');
        $details = $this->input->post('details');
        $logic   = $this->input->post('logic');

        $data = [
            'pname' => $pname,
            'detail'  => $details,
            'logic'        => $logic
        ];

        $this->db->where('cid', $cid);
        $updated = $this->db->update('tabpaycon', $data);

        if ($updated) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update.']);
        }
    }

    public function delete()
    {
        $cid = $this->input->post('cid');

        if (!$cid) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID.']);
            return;
        }

        $this->db->where('cid', $cid);
        $deleted = $this->db->delete('tabpaycon');

        if ($deleted) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete record.']);
        }
    }
}
