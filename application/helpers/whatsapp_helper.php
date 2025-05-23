<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('send_whatsapp_notification')) {
    function send_whatsapp_notification($phone, $message) {
        // Format nomor telepon (hapus karakter selain angka)
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Pastikan nomor dimulai dengan 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        // URL API WhatsApp (menggunakan API WhatsApp Business)
        $url = 'https://api.whatsapp.com/send';
        
        // Parameter untuk URL
        $params = [
            'phone' => $phone,
            'text' => $message
        ];
        
        // Buat URL lengkap
        $whatsapp_url = $url . '?' . http_build_query($params);
        
        // Buka WhatsApp di browser baru
        echo "<script>window.open('" . $whatsapp_url . "', '_blank');</script>";
        
        return true;
    }
}

if (!function_exists('get_status_message')) {
    function get_status_message($status, $order_id, $customer_name) {
        $admin_phone = '083836339182';
        $messages = [
            'pending' => "Halo Admin,\n\nAda pesanan baru dari $customer_name\nID Pesanan: #$order_id\n\nSilakan proses pesanan ini.",
            'diproses' => "Halo $customer_name,\n\nPesanan Anda dengan ID #$order_id sedang diproses.\n\nTerima kasih telah berbelanja di Hijauloka.",
            'dikirim' => "Halo $customer_name,\n\nPesanan Anda dengan ID #$order_id telah dikirim.\n\nTerima kasih telah berbelanja di Hijauloka.",
            'dibatalkan' => "Halo $customer_name,\n\nPesanan Anda dengan ID #$order_id telah dibatalkan.\n\nJika ada pertanyaan, silakan hubungi kami di $admin_phone"
        ];
        
        return $messages[$status] ?? '';
    }
} 