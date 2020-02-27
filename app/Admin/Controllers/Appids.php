<?php

namespace App\Admin\Controllers;

use App\Model\Appid;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class Appids extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'APP管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Appid());

        $grid->column('id', __('Id'));
        $grid->column('l_id', __('用户id'));
        $grid->column('app_id', __('Appid'));
        $grid->column('secret', __('Secret'));
        $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Appid::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('l_id', __('L id'));
        $show->field('app_id', __('App id'));
        $show->field('secret', __('Secret'));
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
        $form = new Form(new Appid());

        $form->number('l_id', __('L id'));
        $form->text('app_id', __('App id'));
        $form->text('secret', __('Secret'));

        return $form;
    }
}
