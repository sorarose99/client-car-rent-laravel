<?php

namespace App\Admin\Controllers;

use App\Models\Car;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CarController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Car';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Car());

        $grid->column('id', __('Id'));
        $grid->column('branch_id', __('Branch id'));
        $grid->column('title', __('Title'));
        $grid->column('images', __('Images'));
        $grid->column('engine', __('Engine'));
        $grid->column('mileage', __('Mileage'));
        $grid->column('color', __('Color'));
        $grid->column('transmission', __('Transmission'));
        $grid->column('doors', __('Doors'));
        $grid->column('seats', __('Seats'));
        $grid->column('price_per_day', __('Price per day'));
        $grid->column('price_per_hour', __('Price per hour'));
        $grid->column('price_per_month', __('Price per month'));
        $grid->column('trim', __('Trim'));
        $grid->column('paint_parts', __('Paint parts'));
        $grid->column('plate', __('Plate'));
        $grid->column('seat_number', __('Seat number'));
        $grid->column('seat_material', __('Seat material'));
        $grid->column('condition', __('Condition'));

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
        $show = new Show(Car::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('branch_id', __('Branch id'));
        $show->field('title', __('Title'));
        $show->field('images', __('Images'));
        $show->field('engine', __('Engine'));
        $show->field('mileage', __('Mileage'));
        $show->field('color', __('Color'));
        $show->field('transmission', __('Transmission'));
        $show->field('doors', __('Doors'));
        $show->field('seats', __('Seats'));
        $show->field('price_per_day', __('Price per day'));
        $show->field('price_per_hour', __('Price per hour'));
        $show->field('price_per_month', __('Price per month'));
        $show->field('trim', __('Trim'));
        $show->field('paint_parts', __('Paint parts'));
        $show->field('plate', __('Plate'));
        $show->field('seat_number', __('Seat number'));
        $show->field('seat_material', __('Seat material'));
        $show->field('condition', __('Condition'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Car());

        $form->number('branch_id', __('Branch id'));
        $form->text('title', __('Title'));
        $form->textarea('images', __('Images'));
        $form->text('engine', __('Engine'));
        $form->text('mileage', __('Mileage'));
        $form->color('color', __('Color'));
        $form->text('transmission', __('Transmission'));
        $form->number('doors', __('Doors'));
        $form->number('seats', __('Seats'));
        $form->decimal('price_per_day', __('Price per day'));
        $form->decimal('price_per_hour', __('Price per hour'));
        $form->decimal('price_per_month', __('Price per month'));
        $form->text('trim', __('Trim'));
        $form->text('paint_parts', __('Paint parts'));
        $form->text('plate', __('Plate'));
        $form->number('seat_number', __('Seat number'));
        $form->text('seat_material', __('Seat material'));
        $form->text('condition', __('Condition'));

        return $form;
    }
}
