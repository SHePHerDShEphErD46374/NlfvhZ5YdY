<?php
// 代码生成时间: 2025-10-11 03:52:22
// 文件：BreadcrumbComponent.php
// 面包屑导航组件，用于生成面包屑导航链接

App::uses('Component', 'Controller');

class BreadcrumbComponent extends Component {
    
    private $_controller;
    private $_crumbs = [];
    private $_separator = ' \ ' ;
    public $components = array('Session');
    
    // 初始化面包屑组件
    public function initialize(Controller $controller) {
        $this->_controller = $controller;
    }
    
    // 启动组件
    public function startup(Controller $controller) {
        // 获取页面标题
        $this->_crumbs['home'] = array(
            'title' => __('Home'),
            'url' => array('controller' => 'pages', 'action' => 'display', 'home')
        );
    }
    
    // 添加面包屑
    public function add($title, $url = null) {
        if ($title === null || $title === '') {
            $this->log('Breadcrumb title cannot be empty.', 'error');
            return false;
        }
        
        $this->_crumbs[] = array(
            'title' => $title,
            'url' => $url
        );
    }
    
    // 设置面包屑分隔符
    public function setSeparator($separator) {
        $this->_separator = $separator;
    }
    
    // 获取面包屑HTML
    public function getHtml() {
        if (empty($this->_crumbs)) {
            return '';
        }
        
        $html = '';
        foreach ($this->_crumbs as $crumb) {
            if (isset($crumb['url'])) {
                $html .= $this->_controller->Html->link($crumb['title'], $crumb['url']) . $this->_separator;
            } else {
                $html .= $crumb['title'] . $this->_separator;
            }
        }
        return rtrim($html, $this->_separator);
    }
    
    // 面包屑展开为数组
    public function getArray() {
        return $this->_crumbs;
    }
    
    // 日志记录
    private function log($message, $type = 'error') {
        $this->log = $this->getLogger();
        $this->log->{$type}($message);
    }
}
