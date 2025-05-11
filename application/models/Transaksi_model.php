<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($filters = []) {
        $this->db->select('transaksi.*, user.nama AS nama_pelanggan, user.email')
                 ->from('transaksi')
                 ->join('user', 'user.id_user = transaksi.user_id', 'left')
                 ->order_by('transaksi.tanggal_transaksi', 'DESC');

        // Apply filters if any
        if (!empty($filters['status'])) {
            $this->db->where('transaksi.status_pembayaran', $filters['status']);
        }
        if (!empty($filters['method'])) {
            $this->db->where('transaksi.metode_pembayaran', $filters['method']);
        }
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $this->db->group_start()
                     ->like('transaksi.id_transaksi', $search)
                     ->or_like('user.nama', $search)
                     ->or_like('user.email', $search)
                     ->or_like('transaksi.total_bayar', $search)
                     ->group_end();
        }

        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->select('transaksi.*, user.nama AS nama_pelanggan, user.email, user.alamat, user.no_telp')
                        ->from('transaksi')
                        ->join('user', 'user.id_user = transaksi.user_id', 'left')
                        ->where('transaksi.id_transaksi', $id)
                        ->get()
                        ->row();
    }

    public function get_transaksi_items($id_transaksi) {
        return $this->db->select('dt.*, p.nama_product, p.kode_product')
                        ->from('detail_transaksi dt')
                        ->join('product p', 'p.id_product = dt.id_product', 'left')
                        ->where('dt.id_transaksi', $id_transaksi)
                        ->get()
                        ->result();
    }

    public function insert_transaksi($data) {
        $this->db->insert('transaksi', $data);
        return $this->db->insert_id();
    }

    public function update_status($id, $status) {
        $this->db->where('id_transaksi', $id);
        return $this->db->update('transaksi', ['status_pembayaran' => $status]);
    }

    public function get_today_stats() {
        $today = date('Y-m-d');
        $stats = [
            'count' => 0,
            'total_income' => 0
        ];

        // Get today's transaction count
        $count_query = $this->db->query("
            SELECT COUNT(*) as total
            FROM transaksi
            WHERE DATE(tanggal_transaksi) = ?
        ", [$today]);
        $stats['count'] = $count_query->row()->total ?? 0;

        // Get today's total income
        $income_query = $this->db->query("
            SELECT COALESCE(SUM(total_bayar), 0) as total
            FROM transaksi
            WHERE DATE(tanggal_transaksi) = ?
            AND status_pembayaran = 'lunas'
        ", [$today]);
        $stats['total_income'] = $income_query->row()->total ?? 0;

        return $stats;
    }

    public function count_all_transactions($filters = []) {
        $this->db->from('transaksi')
                 ->join('user', 'user.id_user = transaksi.user_id', 'left');

        // Apply the same filters as get_all
        if (!empty($filters['status'])) {
            $this->db->where('transaksi.status_pembayaran', $filters['status']);
        }
        if (!empty($filters['method'])) {
            $this->db->where('transaksi.metode_pembayaran', $filters['method']);
        }
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $this->db->group_start()
                     ->like('transaksi.id_transaksi', $search)
                     ->or_like('user.nama', $search)
                     ->or_like('user.email', $search)
                     ->or_like('transaksi.total_bayar', $search)
                     ->group_end();
        }

        return $this->db->count_all_results();
    }

    public function get_transactions($limit, $offset, $filters = []) {
        $this->db->select('transaksi.*, user.nama as nama_pelanggan, user.email')
                 ->from('transaksi')
                 ->join('user', 'user.id_user = transaksi.user_id', 'left')
                 ->limit($limit, $offset)
                 ->order_by('transaksi.tanggal_transaksi', 'DESC');

        // Apply filters
        if (!empty($filters['status'])) {
            $this->db->where('transaksi.status_pembayaran', $filters['status']);
        }
        if (!empty($filters['method'])) {
            $this->db->where('transaksi.metode_pembayaran', $filters['method']);
        }
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $this->db->group_start()
                     ->like('transaksi.id_transaksi', $search)
                     ->or_like('user.nama', $search)
                     ->or_like('user.email', $search)
                     ->or_like('transaksi.total_bayar', $search)
                     ->group_end();
        }

        return $this->db->get()->result();
    }

    public function get_transaction_summary($id) {
        $transaksi = $this->get_by_id($id);
        if (!$transaksi) return null;

        $items = $this->get_transaksi_items($id);
        $summary = [
            'transaksi' => $transaksi,
            'items' => $items,
            'total_items' => array_sum(array_column($items, 'jumlah')),
            'subtotal' => array_sum(array_column($items, 'subtotal'))
        ];

        return $summary;
    }
}
