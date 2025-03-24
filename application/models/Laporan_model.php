<?php
class Laporan_model extends CI_Model {

    public function get_best_selling_products() {
        $query = $this->db->query("
            SELECT p.nama_product, SUM(d.jumlah) as total
            FROM detail_transaksi d
            JOIN product p ON d.id_product = p.id_product
            GROUP BY p.nama_product
            ORDER BY total DESC
            LIMIT 5
        ");
        return $query->result();
    }

    public function get_monthly_sales() {
        $query = $this->db->query("
            SELECT MONTHNAME(tanggal_transaksi) as bulan, SUM(total_bayar) as total
            FROM transaksi
            WHERE YEAR(tanggal_transaksi) = YEAR(CURDATE())
            GROUP BY MONTH(tanggal_transaksi)
            ORDER BY MONTH(tanggal_transaksi)
        ");
        return $query->result();
    }
}
