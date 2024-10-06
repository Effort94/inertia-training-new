<?php

namespace App\Http\Controllers\Profile;

use Inertia\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProfileController extends Controller
{
    /**
     * Redirect to log in view
     */
    public function downloadCv(): BinaryFileResponse
    {
        return response()->download(storage_path('app/public/cv.pdf'), 'cv.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
