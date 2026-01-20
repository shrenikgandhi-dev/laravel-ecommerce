<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasStatusTrash
{
    /**
     * Override the delete method to just mark the record as trash.
     */
    public function delete()
    {
        if ($this instanceof Model) {
            $this->status = 'trash';
            return $this->save();
        }
        return false;
    }

    /**
     * Restore a trashed record.
     */
    public function restore()
    {
        if ($this instanceof Model && $this->status === 'trash') {
            $this->status = 'active';
            return $this->save();
        }
        return false;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isTrashed(): bool
    {
        return $this->status === 'trash';
    }

    public function getAllPassive() {
        return self::where('status', '!=', 'trash')->get();
    }
}