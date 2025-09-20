<?php
// 代码生成时间: 2025-09-20 08:23:08
// user_interface_components.php

// 使用CakePHP框架的命名空间
use Cake\Http\Exception\NotFoundException;
use Cake\Routing\Router;

// 用户界面组件类
class UserInterfaceComponents {

    /**
     * 显示面包屑导航
     * @param array $crumbs 面包屑数据
     * @return string 面包屑导航的HTML代码
     */

    public function renderBreadcrumb($crumbs) {

        if (empty($crumbs)) {

            throw new NotFoundException(__('No crumbs available'));
        }


        $html = '<nav aria-label="Breadcrumb">
';
        $html .= '<ol class="breadcrumb">
';
        foreach ($crumbs as $key => $crumb) {
            if (array_key_exists('url', $crumb)) {
                $html .= '<li class="breadcrumb-item"><a href="' . h($crumb['url']) . '">' . h($crumb['text']) . '</a></li>';
            } else {
                $html .= '<li class="breadcrumb-item active">' . h($crumb) . '</li>';
            }
        }
        $html .= '</ol>
';
        $html .= '</nav>';
        return $html;
    }

    /**
     * 显示分页组件
     * @param array $params 分页参数
     * @return string 分页组件的HTML代码
     */

    public function renderPagination($params) {

        if (!isset($params['url']) || !isset($params['total']) || !isset($params['limit'])) {

            throw new NotFoundException(__('Pagination parameters are not complete'));
        }


        $request = Router::getRequest();
        $query = $request->getQueryParams();
        $url = $params['url'] . '?' . http_build_query($query);

        $html = '<nav aria-label="Page navigation example">
';
        $html .= '<ul class="pagination justify-content-center">
';
        for ($i = 1; $i <= ceil($params['total'] / $params['limit']); $i++) {
            if ($i == $params['page']) {
                $html .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
            } else {
                $html .= '<li class="page-item"><a class="page-link" href="' . $url . '&page=' . $i . '