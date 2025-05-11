<?php
declare(strict_types=1);

namespace App\Traits;

trait Timestamps
{
    public string $created_at;
    public string $updated_at;

    public function touch(): void
    {
        $now = date('Y-m-d H:i:s');
        $this->updated_at = $now;
        if (!isset($this->created_at)) {
            $this->created_at = $now;
        }
    }
}

