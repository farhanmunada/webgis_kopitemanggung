<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Umkm;

class UMKMStatusChanged extends Notification
{
    use Queueable;

    protected $umkm;
    protected $status;
    protected $note;

    public function __construct(Umkm $umkm, $status, $note = null)
    {
        $this->umkm = $umkm;
        $this->status = $status;
        $this->note = $note;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $title = $this->status === 'approved' ? 'Pendaftaran UMKM Disetujui' : 'Pendaftaran UMKM Ditolak';
        $message = $this->status === 'approved' 
            ? "Selamat! Pendaftaran UMKM '{$this->umkm->business_name}' telah disetujui. Anda sekarang dapat menambahkan produk."
            : "Maaf, pendaftaran UMKM '{$this->umkm->business_name}' ditolak. " . ($this->note ? "Alasan: {$this->note}" : "");

        return [
            'type' => 'umkm_status',
            'umkm_id' => $this->umkm->id,
            'status' => $this->status,
            'title' => $title,
            'message' => $message,
            'icon' => $this->status === 'approved' ? 'fas fa-check-circle' : 'fas fa-times-circle',
            'color' => $this->status === 'approved' ? 'green' : 'red',
        ];
    }
}
