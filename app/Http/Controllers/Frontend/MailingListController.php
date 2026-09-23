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
        $url = url('/join-mailing-list/user/' . $userId);

        return <<<HTML
    <style>
    .mail_form {
        background-color: #F7F7F7;
        padding: 15px;
        border-collapse: collapse;
    }

    .mail_form td {
        color: #000000;
        font-family: Arial, sans-serif;
        font-size: 13px;
        padding: 5px;
    }

    .mail_form input[type="text"],
    .mail_form input[type="email"] {
        width: 275px;
        padding: 6px;
        box-sizing: border-box;
    }

    .mailing_button {
        color: #000000;
        font-family: Arial, sans-serif;
        font-size: 13px;
        font-weight: bold;
        padding: 7px 15px;
        cursor: pointer;
    }
    </style>

    <script>
    function mailing_form_check(form) {

        var msg = "";

        var email = form.mailing_email.value.trim();

        if (email === "") {

            msg += "Please enter your Email.\\n";

        } else if (!isEmail(email)) {

            msg += "Please enter a correct Email.\\n";

        }

        if (msg === "") {
            return true;
        }

        alert(msg);

        return false;
    }

    function isEmail(email) {

        var regex = /^[\\w-]+(?:\\.[\\w-]+)*@(?:[\\w-]+\\.)+[a-zA-Z]{2,}$/;

        return regex.test(email);
    }
    </script>

    <form
        name="frm_mailing_list_{$userId}"
        method="POST"
        action="{$url}"
        onsubmit="return mailing_form_check(this);"
    >

        <table
            width="400"
            cellpadding="0"
            cellspacing="0"
            border="0"
            class="mail_form"
        >

            <tbody>

                <tr>
                    <td>
                        <strong>First name</strong>
                    </td>

                    <td>
                        <input
                            type="text"
                            name="mailing_fName"
                            value=""
                            maxlength="100"
                        >
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>Last name</strong>
                    </td>

                    <td>
                        <input
                            type="text"
                            name="mailing_lName"
                            value=""
                            maxlength="100"
                        >
                    </td>
                </tr>

                <tr>
                    <td>
                        <span style="color:#F00">*</span>
                        <strong>Email</strong>
                    </td>

                    <td>
                        <input
                            type="email"
                            name="mailing_email"
                            value=""
                            maxlength="255"
                            required
                        >
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="height:10px;"></td>
                </tr>

                <tr>
                    <td></td>

                    <td>
                        <input
                            type="submit"
                            name="submit"
                            value="Submit"
                            class="mailing_button"
                        >

                        <input
                            type="hidden"
                            name="mailing_user"
                            value="user"
                        >

                    </td>
                </tr>

            </tbody>

        </table>

    </form>
    HTML;
    }
}