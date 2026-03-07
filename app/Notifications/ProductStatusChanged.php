<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductStatusChanged extends Notification
{
    use Queueable;

    protected $product;
    protected $status;
    protected $reason;

    public function __construct($product, $status, $reason = null)
    {
        $this->product = $product;
        $this->status = $status;
        $this->reason = $reason;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $title = $this->status === 'approved' ? 'Produk Disetujui' : 'Produk Ditolak';
        $message = $this->status === 'approved' 
            ? "Produk '{$this->product->name}' Anda telah disetujui dan kini tampil di katalog."
            : "Produk '{$this->product->name}' Anda ditolak. " . ($this->reason ? "Alasan: {$this->reason}" : "");

        return [
            'type' => 'product_status',
            'product_id' => $this->product->id,
            'status' => $this->status,
            'title' => $title,
            'message' => $message,
            'icon' => $this->status === 'approved' ? 'fas fa-box' : 'fas fa-exclamation-triangle',
            'color' => $this->status === 'approved' ? 'blue' : 'orange',
        ];
    }
}
