<?php

namespace App\Admin\Controllers;

use App\Models\Area;
use App\Models\DeliveryCharge;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

class CoverageAreaController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Coverage Area & Charges';

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header($this->title)
            ->body($this->grid());
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header($this->title)
            ->body($this->form());
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header($this->title)
            ->body($this->editForm()->edit($id));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DeliveryCharge);

        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();

            // Add Name filter
            $filter->equal('charges', 'Charges');

            // Add Status filter
            $filter->equal('is_active', 'Status')->radio([
                ''   => 'All',
                0    => 'Not Active',
                1    => 'Active',
            ]);

        });

        $grid->model()->orderBy( 'charges', 'desc' );

        $grid->column('id', __('Id'));
        $grid->area()->name_en('Area');
        $grid->column('charges', __('Charges in KD'));
        $grid->column('created_at', __('Created at'));

        $grid->disableBatchActions();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
        });
        $grid->disableExport();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new DeliveryCharge);

        $areas = Area::all()->pluck('name_en', 'id');

        $form->multipleSelect('area_id', 'Areas')->options($areas);

        $form->saving(function (Form $form) {

            //convert item to array in case editing
            if(!is_array($form->area_id))
            {
                $form->area_id = [$form->area_id];
            }

            foreach ($form->area_id as $area)
            {
                if($area)
                {
                    $checkArea = DeliveryCharge::where('area_id', $area)->first();
                    if($checkArea)
                    {
                        $checkArea->update(['charges' => $form->charges]);
                    }
                    else
                    {
                        DeliveryCharge::create([
                            'area_id'  => $area,
                            'charges' => $form->charges,
                        ] );
                    }
                }
            }
            $success = new MessageBag([
                'title'   => 'New Record',
                'message' => 'New record added successfully!',
            ]);

            return redirect()->route('delivery-charges.index')->with(compact('success'));
        });

        $form->decimal('charges', __('Charges in KD'));

        return $form;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function editForm()
    {
        $form = new Form(new DeliveryCharge);

        $areas = Area::all()->pluck('name_en', 'id');

        $form->select('area_id', 'Areas')->options($areas);
        $form->decimal('charges', __('Charges in KD'));

        $form->tools(function (Form\Tools $tools) {
            // Disable `Veiw` btn.
            $tools->disableView();
        });

        return $form;
    }
}
