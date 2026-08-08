<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    protected function currentUser(): ?\App\Models\Admin
    {
        return auth()->user();
    }

    protected function currentUserId(): ?int
    {
        return auth()->id();
    }
}
