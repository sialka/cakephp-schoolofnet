<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * /
  namespace App\Controller;

  use Cake\Core\Configure;
  use Cake\Network\Exception\ForbiddenException;
  use Cake\Network\Exception\NotFoundException;
  use Cake\View\Exception\MissingTemplateException;

  / **
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 * /
  class PagesController extends AppController
  {

  / **
 * Displays a view
 *
 * @param array ...$path Path segments.
 * @return \Cake\Http\Response|null
 * @throws \Cake\Network\Exception\ForbiddenException When a directory traversal attempt.
 * @throws \Cake\Network\Exception\NotFoundException When the view file could not
 *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
 * /
  public function display(...$path)
  {
  $count = count($path);
  if (!$count) {
  return $this->redirect('/');
  }
  if (in_array('..', $path, true) || in_array('.', $path, true)) {
  throw new ForbiddenException();
  }
  $page = $subpage = null;

  if (!empty($path[0])) {
  $page = $path[0];
  }
  if (!empty($path[1])) {
  $subpage = $path[1];
  }
  $this->set(compact('page', 'subpage'));

  try {
  $this->render(implode('/', $path));
  } catch (MissingTemplateException $exception) {
  if (Configure::read('debug')) {
  throw $exception;
  }
  throw new NotFoundException();
  }
  }
  }
 */

namespace App\Controller;

class PagesController extends AppController {

    public function index() {
        //$pages = $this->Pages->find()->all();
        
        $this->paginate = [
            "limit" => 5
        ];
        $pages = $this->paginate($this->Pages);
        $this->set('pages', $pages);
    }

    public function view($id = null) {
        $page = $this->Pages->get($id);

        $this->set('page', $page);
        //debug('Visualizando: '.$page );
        //exit;
    }

    public function add() {
        // $this->viewBuilder()->layout('layoutB');
        $page = $this->Pages->newEntity();
        if ($this->request->is('post')) {
            $page = $this->Pages->patchEntity($page, $this->request->getData());

            if ($this->Pages->save($page)) {
                $this->Flash->success('Salvo com sucesso');
                return $this->redirect(['controller' => 'Pages', 'action' => 'index']);
            }
            $this->Flash->error('Não foi possivel Salvar');
        }

        $this->set(['page' => $page]);
    }

    public function edit($id = null) {
        $page = $this->Pages->get($id);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $page = $this->Pages->patchEntity($page, $this->request->getData());

            if ($this->Pages->save($page)) {
                $this->Flash->success('Editado com sucesso');
                return $this->redirect(['controller' => 'Pages', 'action' => 'index']);
            }
            $this->Flash->error('Não foi possivel editar');
        }

        $this->set('page', $page);
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $page = $this->Pages->get($id);

        if ($this->Pages->delete($page)) {
            $this->Flash->success('Deletado com sucesso');
        } else {
            $this->Flash->error('Não foi possivel deletar');
        }


        return $this->redirect(['controller' => 'Pages', 'action' => 'index']);
    }

}
