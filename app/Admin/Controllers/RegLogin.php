<?php

namespace App\Admin\Controllers;

use App\Model\Reg;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RegLogin extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户管理';

    /**
     * Make a grid builder.
     *表格
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Reg());

        $grid->column('l_id', __('L id'));
        $grid->column('l_name', __('用户名'));
        $grid->column('l_company', __('公司名'));
        $grid->column('l_legal', __('法人'));
        $grid->column('l_address', __('公司地址'));
        // $grid->column('l_logo', __('营业执照照片'))->display(function($logo){
        //     return '<img src="http://open.1906.com/'.$logo.'" >';
        // });
        $grid->column('l_logo', __('营业执照照片'))->image();
        $grid->column('l_phone', __('电话'));
        $grid->column('l_email', __('邮箱'));
        $grid->column('created_at', __('Created at'));
        // $grid->column('l_pass', __('密码'));
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
        $show = new Show(Reg::findOrFail($id));

        $show->field('l_id', __('L id'));
        $show->field('l_name', __('l name'));
        $show->field('l_company', __('L company'));
        $show->field('l_legal', __('L legal'));
        $show->field('l_address', __('L address'));
        $show->field('l_logo', __('L logo'));
        $show->field('l_phone', __('L phone'));
        $show->field('l_email', __('L email'));
        $show->field('created_at', __('Created at'));
        $show->field('l_pass', __('L pass'));
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
        $form = new Form(new Reg());
        
        $form->text('l_name', __('用户名'));
        $form->text('l_company', __('公司名'));
        $form->text('l_legal', __('法人'));
        $form->text('l_address', __('公司地址'));
        $form->image('l_logo', __('营业执照照片'));
        $form->text('l_phone', __('电话'));
        $form->text('l_email', __('邮箱'));
        $form->password('l_pass', __('密码'));

        return $form;
    }
}
