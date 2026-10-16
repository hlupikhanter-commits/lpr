<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function feedbackForm()
    {
        return view('feedback', ['title' => 'Обратная связь']);
    }

    public function feedbackSend(Request $request)
    {
        $name = $request->input('name', 'Аноним');
        $message = $request->input('message');

        return redirect()
            ->route('feedback.form')
            ->with('status', "Спасибо, {$name}! Сообщение получено: {$message}");
    }
}
