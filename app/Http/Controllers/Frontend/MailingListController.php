<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MailingListController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
         * Generate the HTML code for the user's
         * mailing list form.
         *
         * We can replace this with the actual
         * database/form generation logic.
         */
        $mailForm = $this->generateMailingForm($user->id);

        return view(
            'frontend.user.mailing-list',
            compact('mailForm')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'mailing_form' => [
                'required',
                'string',
            ],
        ]);

        /*
         * This page mainly provides the HTML code
         * to the user for copying to another website.
         *
         * Add any required save/processing logic here.
         */

        return redirect()
            ->route('user.mailing-list')
            ->with(
                'success',
                'Mailing list form processed successfully.'
            );
    }


    private function generateMailingForm(int $userId): string
    {
        $url = url('/join-mailing-list/user' . $userId);

        return <<<HTML
            <form action="{$url}" method="POST">

                <label>First Name</label>
                <input type="text" name="first_name" required>

                <label>Last Name</label>
                <input type="text" name="last_name" required>

                <label>Email</label>
                <input type="email" name="email" required>

                <button type="submit">
                    Subscribe
                </button>

            </form>
            HTML;
    }
}