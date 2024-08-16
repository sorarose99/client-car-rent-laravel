<?php

namespace App\Admin\Controllers;

use App\Models\CardDetail;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CardDetailController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'CardDetail';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CardDetail());

        $grid->column('id', __('Id'));
        $grid->column('card_number', __('Card number'));
        $grid->column('card_holder', __('Card holder'));
        $grid->column('expiry_date', __('Expiry date'));
        $grid->column('issuer', __('Issuer'));
        $grid->column('cvv', __('Cvv'));
        $grid->column('booking_id', __('Booking id'));
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
        $show = new Show(CardDetail::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('card_number', __('Card number'));
        $show->field('card_holder', __('Card holder'));
        $show->field('expiry_date', __('Expiry date'));
        $show->field('issuer', __('Issuer'));
        $show->field('cvv', __('Cvv'));
        $show->field('booking_id', __('Booking id'));
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
        $form = new Form(new CardDetail());

        $form->text('card_number', __('Card number'));
        $form->textarea('card_holder', __('Card holder'));
        $form->date('expiry_date', __('Expiry date'))->default(date('Y-m-d'));
        $form->text('issuer', __('Issuer'));
        $form->text('cvv', __('Cvv'));
        $form->number('booking_id', __('Booking id'));

        return $form;
    }
}
