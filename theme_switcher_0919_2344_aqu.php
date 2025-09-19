<?php
// 代码生成时间: 2025-09-19 23:44:38
// Load CakePHP's core components
use Cake\Event\EventManager;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Network\Request;
use Cake\Network\Response;

class ThemeSwitcherController extends AppController
{
    /**
     * Before filter method to check if the user has access to switch themes.
     *
     * @param Event $event The event object.
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Add your authentication logic here
# FIXME: 处理边界情况
    }

    /**
     * Switches the theme for the current user session.
     *
# 扩展功能模块
     * @param string $theme The name of the theme to switch to.
     * @return \Cake\Network\Response
     */
    public function switchTheme($theme)
# 增强安全性
    {
# 添加错误处理
        // Validate the theme parameter
        if (!$this->request->is(['post'])) {
            throw new MethodNotAllowedException(__('This action is only allowed for POST requests.'));
        }
# 增强安全性

        // Get the user table and find the current user
        $Users = TableRegistry::get('Users');
        $user = $Users->find('all', ['conditions' => ['Users.id' => $this->Auth->user('id')]]);

        // Check if the user exists and the theme is valid
        if (empty($user) || !in_array($theme, ['dark', 'light'])) {
            throw new NotFoundException(__('Invalid user or theme.'));
        }

        // Set the theme in the user's session
        $this->request->session()->write('User.theme', $theme);
# 增强安全性

        // Redirect back to the previous page or a default page
        return $this->redirect($this->referer());
    }
}
