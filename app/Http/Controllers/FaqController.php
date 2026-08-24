<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Public FAQ list with collapsible answers (FR-53, FR-54).
     */
    public function index()
    {
        return view('faq', [
            'faqs' => Faq::published()->get(),
        ]);
    }
}
