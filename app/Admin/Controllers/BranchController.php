<?php

namespace App\Admin\Controllers;

use App\Models\Branch;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BranchController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Branch';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Branch());

        $grid->column('id', __('Id'));
        $grid->column('car_id', __('Car id'));
        $grid->column('text', __('Text'));
        $grid->column('loclat', __('Loclat'));
        $grid->column('loclong', __('Loclong'));
        $grid->column('regionid', __('Regionid'));
        $grid->column('cityid', __('Cityid'));
        $grid->column('branchid', __('Branchid'));
        $grid->column('address1', __('Address1'));
        $grid->column('address2', __('Address2'));
        $grid->column('hours', __('Hours'));
        $grid->column('phone1', __('Phone1'));
        $grid->column('phone2', __('Phone2'));
        $grid->column('mobile', __('Mobile'));
        $grid->column('email', __('Email'));

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
        $show = new Show(Branch::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('car_id', __('Car id'));
        $show->field('text', __('Text'));
        $show->field('loclat', __('Loclat'));
        $show->field('loclong', __('Loclong'));
        $show->field('regionid', __('Regionid'));
        $show->field('cityid', __('Cityid'));
        $show->field('branchid', __('Branchid'));
        $show->field('address1', __('Address1'));
        $show->field('address2', __('Address2'));
        $show->field('hours', __('Hours'));
        $show->field('phone1', __('Phone1'));
        $show->field('phone2', __('Phone2'));
        $show->field('mobile', __('Mobile'));
        $show->field('email', __('Email'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Branch());

        $form->number('car_id', __('Car id'));
        $form->text('text', __('Text'));
        $form->text('loclat', __('Loclat'));
        $form->text('loclong', __('Loclong'));
        $form->text('regionid', __('Regionid'));
        $form->text('cityid', __('Cityid'));
        $form->text('branchid', __('Branchid'));
        $form->text('address1', __('Address1'));
        $form->text('address2', __('Address2'));
        $form->text('hours', __('Hours'));
        $form->text('phone1', __('Phone1'));
        $form->text('phone2', __('Phone2'));
        $form->mobile('mobile', __('Mobile'));
        $form->email('email', __('Email'));

        return $form;
    }
}
