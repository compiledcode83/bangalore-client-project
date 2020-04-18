<?php

namespace App\Admin\Controllers;

use App\Imports\ProductsImport;
use App\Jobs\SendNewsletterEmails;
use App\Models\Product;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ValidationExceptionAlias;

class ImportExcelController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Products Import Excel';

    /**
     * @param Content $content
     * @return Content
     */
    public function import(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['show'] ?? trans('admin.show'))
            ->body(
                view('admin.import')
            );
    }

    public function store()
    {
        request()->validate([
            'file'  => 'required|mimes:csv,xlsx,xls|max:500',
        ]);

        Excel::import(new ProductsImport(),request()->file('file'));
        return back()->with('message', "Successfully Imported!");
    }

    /**
     * @param Content $content
     * @return Content
     */
    public function uploadImages(Content $content)
    {
        return $content
            ->title('Import Multiple Images ')
            ->description($this->description['show'] ?? trans('admin.show'))
            ->body(
                view('admin.importImages')
            );
    }

    public function storeImages()
    {
        $attribute = request()->only('replaceImages');

        if(request()->hasFile('files'))
        {
            //validation
            $rules = [];
            $photos = count(request()->file('files'));
            foreach(range(0, $photos) as $index) {
                $rules['files.' . $index] = 'image|mimes:jpeg,bmp,png|max:2000';
            }
            request()->validate($rules);

            $uploadPhotos = request()->file('files');

            // if admin need to check names
            if(!isset($attribute['replaceImages']))
            {
                $namesFound = [];
                foreach ($uploadPhotos as $photo)
                {
                    //check if image name found
                    if(is_file(public_path('uploads/images/' . $photo->getClientOriginalName())))
                    {
                        $namesFound[] = 'This name '. $photo->getClientOriginalName() .' already found';
                    }
                }

                if(!empty($namesFound))
                {
                    $namesFound[] =  'Check box below upload button to replace old names with the new one';
                    return back()->withErrors($namesFound);
                }
            }

            foreach ($uploadPhotos as $photo)
            {
                //save image
                Image::make($photo)
                    ->save('uploads/images/'.$photo->getClientOriginalName());
            }
        }

        return back()->with('message', "Successfully Imported!");
    }

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
