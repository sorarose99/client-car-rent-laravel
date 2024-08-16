<?php

namespace App\Admin\Controllers;

use App\Models\Booking;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BookingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Booking';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Booking());

        $grid->column('id', __('Id'));
        $grid->column('branch_id', __('Branch id'));
        $grid->column('car_id', __('Car id'));
        $grid->column('variant', __('Variant'));
        $grid->column('pickupDate', __('PickupDate'));
        $grid->column('returnDate', __('ReturnDate'));
        $grid->column('price', __('Price'));
        $grid->column('duration', __('Duration'));
        $grid->column('pickupLocation', __('PickupLocation'));
        $grid->column('dropoffLocation', __('DropoffLocation'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Booking::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('branch_id', __('Branch id'));
        $show->field('car_id', __('Car id'));
        $show->field('variant', __('Variant'));
        $show->field('pickupDate', __('PickupDate'));
        $show->field('returnDate', __('ReturnDate'));
        $show->field('price', __('Price'));
        $show->field('duration', __('Duration'));
        $show->field('pickupLocation', __('PickupLocation'));
        $show->field('dropoffLocation', __('DropoffLocation'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Booking());

        $form->number('branch_id', __('Branch id'));
        $form->number('car_id', __('Car id'));
        $form->text('variant', __('Variant'));
        $form->datetime('pickupDate', __('PickupDate'))->default(date('Y-m-d H:i:s'));
        $form->datetime('returnDate', __('ReturnDate'))->default(date('Y-m-d H:i:s'));
        $form->decimal('price', __('Price'));
        $form->text('duration', __('Duration'));
        $form->text('pickupLocation', __('PickupLocation'));
        $form->text('dropoffLocation', __('DropoffLocation'));

        return $form;
    }
}
