<?php

namespace App\Admin\Controllers;

use App\Jobs\SendNewsletterEmails;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

class NewsLetterController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'NewsLetters';

    /**
     * Make a NewsLetter Form.
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['show'] ?? trans('admin.show'))
            ->body(
                view('admin.newsletter')
                    ->with('usersAccounts', User::subscribedUsers())
                    ->with('companiesAccounts', User::subscribedCompanies())
            );
    }

    /**
     * send NewsLetter.
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function sendMails(Request $request)
    {
        $attributes = $request->only('subject', 'body', 'only_subscribed', 'custom_users', 'custom_company');

        if(isset($attributes['only_subscribed']))
        {
            $usersAccounts = User::subscribedUsers();
            $usersAccounts = $usersAccounts->pluck('id');
            $companiesAccounts = User::subscribedCompanies();
            $companiesAccounts = $companiesAccounts->pluck('id');
        }
        else
        {
            if(isset($attributes['custom_users']))
            {
                $usersAccounts = $attributes['custom_users'];
            }

            if(isset($attributes['custom_company']))
            {
                $companiesAccounts = $attributes['custom_company'];
            }
        }

        if(isset($usersAccounts))
        {

            foreach ($usersAccounts as $usersAccount)
            {
                $account = User::find($usersAccount);
                $data = [
                    'email' => $account->email,
                    'subject' => $attributes['subject'],
                    'body' => $attributes['body']
                ];
                try{
                    SendNewsletterEmails::dispatch($data);
                } catch (\Exception $e) {
                    return dump($e->getMessage());
                }
            }
        }

        if(isset($companiesAccounts))
        {

            foreach ($companiesAccounts as $companyAccount)
            {
                $account = User::find($companyAccount);
                $data = [
                    'email' => $account->email,
                    'subject' => $attributes['subject'],
                    'body' => $attributes['body']
                ];
                try{
                    SendNewsletterEmails::dispatch($data);
                } catch (\Exception $e) {
                    return dump($e->getMessage());
                }
            }
        }

        return redirect()->route('admin.newsletter')->with('Success', 'Emails sent successfully!');
    }
}
