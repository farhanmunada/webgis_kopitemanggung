<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Umkm;

class UMKMSubmissionReceived extends Notification
{
    use Queueable;

    protected $umkm;

    public function __construct(Umkm $umkm)
    {
        $this->umkm = $umkm;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'umkm_submission',
            'umkm_id' => $this->umkm->id,
            'title' => 'Pendaftaran Diterima',
            'message' => "Pendaftaran UMKM '{$this->umkm->business_name}' telah kami terima dan sedang dalam antrean verifikasi oleh Admin. Mohon tunggu informasi selanjutnya.",
            'icon' => 'fas fa-hourglass-half',
            'color' => 'orange',
        ];
    }
}
